<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: JSON');

require_once './PHPExcel/Classes/PHPExcel.php';
require_once './PHPExcel/Classes/PHPExcel/IOFactory.php';
include_once 'Database.php';
include_once '../model/Table.php';

// to retreive file
function retrieveFile($filename)
{
    $file = "/var/www/project/Bulli/resources/migrationdata/allinvoices/" . $filename;

    if (file_exists($file)) {

        return $file;
    } else {
        return "couldn't find file";
    }
}


// fetch id for user
function fetchid($table_name, $id, $wherecolumn, $value)
{
    $conn = new Database();
    $db = $conn->connect("NewBulli.db");
    $return_id = null;
    if ($db) {
        $query = "select $id from $table_name where $wherecolumn= '$value' limit 1";
        $result = $db->query($query);
        if ($result) {
            if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $return_id = $row[$id];
            }
            $db->close();
            return $return_id;
        } else {
            echo "error fetching id";
            $db->close();
            die();
            return -1;
        }
    } else {
        echo "error connecting db in fetchid";
        $db->close();
        die();
        return -1;
    }
}

//migrate user given a cards. cards have user in them
function fetchandmigrateuser($spreadsheet)
{
    $conn = new Database();
    $db = $conn->connect("NewBulli.db");
    if ($db) {
        $table = new Table($db);
        $users = array();
        $usercounter = 0;
        for ($row = 0; $row < sizeof($spreadsheet); $row++) {
            // rows of cards
            if (!empty($spreadsheet[$row][7])) {
                if ($usercounter == 0) {
                    $users[$usercounter] = $spreadsheet[$row][7];
                    $usercounter++;
                } elseif (!in_array($spreadsheet[$row][7], $users)) {
                    $users[$usercounter] = $spreadsheet[$row][7];
                    $usercounter++;
                }
            }
        }

        $c = 0;
        foreach ($users as $user) {
            $arg = array(
                'table' => "User",
                'userId' => $c,
                'name' => $users[$c],
                'currentlyActive' => "YES"
            );

            //print_r($arg);
            $table->insertIntoTable("User", $arg);
            $c++;
        }
    }
    $db->close();
}

// to migrate each table
function migratetable($table_name, $columns, $values)
{
    $args = [];
    $args['table'] = $table_name;

    $counter = 0;
    foreach ($columns as $c) {
        $args[$c] = $values[$counter];
        $counter++;
    }
    $conn = new Database();
    $db = $conn->connect("NewBulli.db");
    if ($db) {
        $table = new Table($db);
        //print_r($args);
        $table->insertIntoTable($table_name, $args);
    } else {
        echo "error connecting db in migrate";
        $db->close();
        die();
    }
    $db->close();
}


if (isset($_GET['migrate'])) {
    if ($_GET['migrate'] == 1) {
        echo "i am running!";
        /*read conenteents from spreadsheet*/
        $resourcepath = "../resources/migrationdata/sp.gnumeric";
        $array = array();
        $spreadcounter = 0;
        $objPHPExcel = PHPExcel_IOFactory::load($resourcepath);

        // read from each speadsheet 
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle     = $worksheet->getTitle();   // get file name didnt needed might need for dynamic allocation
            $highestRow         = $worksheet->getHighestRow(); // get no of rows per spreadsheet
            $highestColumn      = $worksheet->getHighestColumn(); // get no of columns per spreadsheet
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $nrColumns = ord($highestColumn) - 64;

            $rowcounter = 0;
            for ($row = 1; $row <= $highestRow; ++$row) {
                if ($row < 2) {
                    $worksheet->removeRow($row);
                } else {
                    $colcounter = 0;
                    for ($col = 0; $col < $highestColumnIndex; ++$col) {
                        $cell = $worksheet->getCellByColumnAndRow($col, $row);
                        $val = $cell->getFormattedValue(); // to remove formula and correct output of date

                        if ($row > 2) {
                            $array[$spreadcounter][$rowcounter][$colcounter] = $val;
                        }
                        $colcounter++;
                    }
                    if ($row > 2) {
                        $rowcounter++;
                    }
                }
            }

            $spreadcounter++;
        }

        //before migration migrate user
        fetchandmigrateuser($array[3]); //users are in Cards

        //migrate tables starting from Category because we need cateegory for other tables
        for ($x = (sizeof($array) - 1); $x >= 0; $x--) {
            $table_name = "";
            $columns = array();
            
            // based on different table use different column
            switch ($x) {
                case 0:
                    $table_name = "Cash";
                    $columns = array("date", "description", "income", "expense", "balance", "gst", "categoryId", "invoice");
                    break;
                case 1:
                    $table_name = "Bendigo";
                    $columns = array("date", "description", "income", "expense", "balance", "gst", "categoryId", "invoice");
                    break;
                case 2:
                    $table_name = "DGR";
                    $columns = array("date", "description", "income", "expense", "balance", "gst", "categoryId");
                    break;
                case 3:
                    $table_name = "Card";
                    $columns = array("date", "description", "income", "expense", "balance", "gst", "categoryId", "UserId", "invoice");
                    break;
                case 4:
                    $table_name = "Deposit";
                    $columns = array("date", "description", "income", "expense", "balance", "gst", "categoryId");
                    break;
                case 5:
                    $table_name = "Social";
                    $columns = array("date", "description", "income", "expense", "balance", "gst", "categoryId", "invoice");
                    break;
                case 6:
                    $table_name = "Category";
                    $columns = array("name", "description");
                    break;
                default:
                    $table_name = "error";
                    $columns = array("Error");
                    break;
            }

            //migration happens here different table ahs different sceanro
            for ($row = 0; $row < sizeof($array[$x]) - 2; $row++) {
                if ($table_name == "Category") {
                    migratetable($table_name, $columns, $array[$x][$row]);
                } else if ($table_name == "DGR" || $table_name == "Deposit") {
                    if (!empty($array[$x][$row][6])) {
                        $array[$x][$row][6] = fetchid("Category", "categoryId", "name", $array[$x][$row][6]);
                    }
                    migratetable($table_name, $columns, $array[$x][$row]);
                } else if ($table_name == "Card") {
                    if (!empty($array[$x][$row][6])) {
                        $array[$x][$row][6] = fetchid("Category", "categoryId", "name", $array[$x][$row][6]);
                    }
                    if (!empty($array[$x][$row][7])) {
                        $array[$x][$row][7] = fetchid("User", "userId", "name", $array[$x][$row][7]);
                    }
                    if (!empty($array[$x][$row][8])) {
                        $array[$x][$row][8] =  retrieveFile($array[$x][$row][8]);
                    }
                    migratetable($table_name, $columns, $array[$x][$row]);
                } else {
                    if (!empty($array[$x][$row][6])) {
                        $array[$x][$row][6] = fetchid("Category", "categoryId", "name", $array[$x][$row][6]);
                    }
                    if (!empty($array[$x][$row][7])) {
                        $array[$x][$row][7] =  retrieveFile($array[$x][$row][7]);
                    }
                    migratetable($table_name, $columns, $array[$x][$row]);
                }
            }

        }

        echo "Migration completed!";
    }
}

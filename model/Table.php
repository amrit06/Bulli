<?php
class Table
{

    private $connection;

    //construct to allow all function to get access to database. 
    //the connection is proveded by other pages using this class
    public function __construct($conn)
    {
        $this->connection = $conn;
    }

    // getting yearly data whenever balance changes 
    public function getYBalances($startDate, $endDate)
    {

        $bendigo = $this->connection->query('Select balance, date FROM Bendigo ');
        $card = $this->connection->query('Select balance, date FROM Card');
        $cash = $this->connection->query('Select balance, date FROM Cash');
        $dgr = $this->connection->query('Select balance, date FROM DGR');
        $deposit = $this->connection->query('Select balance, date FROM Deposit');
        $social = $this->connection->query('Select balance, date FROM Social');

        while ($bendigorow = $bendigo->fetchArray(SQLITE3_ASSOC)) {
            $bendigoArray[] = $bendigorow;
        }

        while ($cardrow = $card->fetchArray(SQLITE3_ASSOC)) {
            $cardArray[] = $cardrow;
        }

        while ($cashrow = $cash->fetchArray(SQLITE3_ASSOC)) {
            $cashArray[] = $cashrow;
        }

        while ($dgrrow = $dgr->fetchArray(SQLITE3_ASSOC)) {
            $dgrArray[] = $dgrrow;
        }

        while ($depositrow = $deposit->fetchArray(SQLITE3_ASSOC)) {
            $depositArray[] = $depositrow;
        }

        while ($socialrow = $social->fetchArray(SQLITE3_ASSOC)) {
            $socialArray[] = $socialrow;
        }

        $returnBendigo = array();
        $returnCard = array();
        $returnCash = array();
        $returnDgr = array();
        $returnDeposit = array();
        $returnSocial = array();

        $sDate =  date('Y-m-d', strtotime($startDate));
        $eDate =  date('Y-m-d', strtotime($endDate));

        $LastBendigo = "There wasnt any record added during the year";
        $LastCard = "There wasnt any record added during the year";
        $LastCash = "There wasnt any record added during the year";
        $LastDgr = "There wasnt any record added during the year";
        $LastDeposit = "There wasnt any record added during the year";
        $LastSocial = "There wasnt any record added during the year";

        if (!empty($bendigoArray)) {

            foreach ($bendigoArray as $bendigorow) {
                $bendigotempDateHolder = str_replace('/', '-', $bendigorow['date']);
                $bendigotempDate = date('Y-m-d', strtotime($bendigotempDateHolder));

                if (($bendigotempDate >= $sDate) && ($bendigotempDate <= $eDate)) {
                    $returnBendigo[] = $bendigorow;
                }
            }
        }

        if (!empty($cardArray)) {

            foreach ($cardArray as $cardrow) {
                $cardtempDateHolder = str_replace('/', '-', $cardrow['date']);
                $cardtempDate = date('Y-m-d', strtotime($cardtempDateHolder));

                if (($cardtempDate >= $sDate) && ($cardtempDate <= $eDate)) {
                    $returnCard[] = $cardrow;
                }
            }
        }

        if (!empty($cashArray)) {

            foreach ($cashArray as $cashrow) {
                $cashtempDateHolder = str_replace('/', '-', $cashrow['date']);
                $cashtempDate = date('Y-m-d', strtotime($cashtempDateHolder));

                if (($cashtempDate >= $sDate) && ($cashtempDate <= $eDate)) {
                    $returnCash[] = $cashrow;
                }
            }
        }

        if (!empty($dgrArray)) {

            foreach ($dgrArray as $dgrrow) {
                $dgrtempDateHolder = str_replace('/', '-', $dgrrow['date']);
                $dgrtempDate = date('Y-m-d', strtotime($dgrtempDateHolder));

                if (($dgrtempDate >= $sDate) && ($dgrtempDate <= $eDate)) {
                    $returnDgr[] = $dgrrow;
                }
            }
        }

        if (!empty($depositArray)) {
            foreach ($depositArray as $depositrow) {
                $deposittempDateHolder = str_replace('/', '-', $depositrow['date']);
                $deposittempDate = date('Y-m-d', strtotime($deposittempDateHolder));

                if (($deposittempDate >= $sDate) && ($deposittempDate <= $eDate)) {
                    $returnDeposit[] = $depositrow;
                }
            }
        }

        if (!empty($socialArray)) {
            foreach ($socialArray as $socialrow) {
                $socialtempDateHolder = str_replace('/', '-', $socialrow['date']);
                $socialtempDate = date('Y-m-d', strtotime($socialtempDateHolder));

                if (($socialtempDate >= $sDate) && ($socialtempDate <= $eDate)) {
                    $returnSocial[] = $socialrow;
                }
            }
        }


        $All = array(
            0 => $returnBendigo, 1 => $returnCard, 2 =>  $returnCash, 3 =>  $returnDgr,
            4 =>  $returnDeposit, 5 =>  $returnSocial
        );

        /*$All = array("Bendigo" => $returnBendigo, "Card" => $returnCard, "Cash" =>  $returnCard, "DGR" =>  $returnDgr,   
            "Deposit" =>  $returnDeposit, "Social" =>  $returnSocial);*/



        return $All;
    }

    //get last balance based on table
    public function getLastBalance($tablename)
    {
        $sql = "Select balance from $tablename order by Id DESC limit 1";
        $result = $this->connection->query($sql);

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $value = $row['balance'];
        }

        return $value;
    }

    // jsut like getalstbalce this gets id used in different function
    public function getLastId($tablename)
    {
        $sql = "Select Id from $tablename order by Id DESC limit 1";
        $result = $this->connection->query($sql);

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $value = $row['Id'];
        }

        return $value;
    }

    // gets opening balance for the year for every table
    public function getOpeningBalances($startDate)
    {
        $bendigo = $this->connection->query('Select balance, date FROM Bendigo ');
        $card = $this->connection->query('Select balance, date FROM Card');
        $cash = $this->connection->query('Select balance, date FROM Cash');
        $dgr = $this->connection->query('Select balance, date FROM DGR');
        $deposit = $this->connection->query('Select balance, date FROM Deposit');
        $social = $this->connection->query('Select balance, date FROM Social');

        while ($bendigorow = $bendigo->fetchArray(SQLITE3_ASSOC)) {
            $bendigoArray[] = $bendigorow;
        }

        while ($cardrow = $card->fetchArray(SQLITE3_ASSOC)) {
            $cardArray[] = $cardrow;
        }

        while ($cashrow = $cash->fetchArray(SQLITE3_ASSOC)) {
            $cashArray[] = $cashrow;
        }

        while ($dgrrow = $dgr->fetchArray(SQLITE3_ASSOC)) {
            $dgrArray[] = $dgrrow;
        }

        while ($depositrow = $deposit->fetchArray(SQLITE3_ASSOC)) {
            $depositArray[] = $depositrow;
        }

        while ($socialrow = $social->fetchArray(SQLITE3_ASSOC)) {
            $socialArray[] = $socialrow;
        }

        $returnBendigo = array();
        $returnCard = array();
        $returnCash = array();
        $returnDgr = array();
        $returnDeposit = array();
        $returnSocial = array();

        $sDate =  date('Y-m-d', strtotime($startDate));

        $LastBendigo = "There wasnt any record added during the year";
        $LastCard = "There wasnt any record added during the year";
        $LastCash = "There wasnt any record added during the year";
        $LastDgr = "There wasnt any record added during the year";
        $LastDeposit = "There wasnt any record added during the year";
        $LastSocial = "There wasnt any record added during the year";

        if (!empty($bendigoArray)) {

            foreach ($bendigoArray as $bendigorow) {
                $bendigotempDateHolder = str_replace('/', '-', $bendigorow['date']);
                $bendigotempDate = date('Y-m-d', strtotime($bendigotempDateHolder));

                if ($bendigotempDate < $sDate) {
                    $returnBendigo[] = $bendigorow;
                    $LastBendigo = end($returnBendigo);
                }
            }
        }

        if (!empty($cardArray)) {

            foreach ($cardArray as $cardrow) {
                $cardtempDateHolder = str_replace('/', '-', $cardrow['date']);
                $cardtempDate = date('Y-m-d', strtotime($cardtempDateHolder));

                if ($cardtempDate < $sDate) {
                    $returnCard[] = $cardrow;
                    $LastCard = end($returnCard);
                }
            }
        }

        if (!empty($cashArray)) {

            foreach ($cashArray as $cashrow) {
                $cashtempDateHolder = str_replace('/', '-', $cashrow['date']);
                $cashtempDate = date('Y-m-d', strtotime($cashtempDateHolder));

                if ($cashtempDate < $sDate) {
                    $returnCash[] = $cashrow;
                    $LastCash = end($returnCash);
                }
            }
        }

        if (!empty($dgrArray)) {

            foreach ($dgrArray as $dgrrow) {
                $dgrtempDateHolder = str_replace('/', '-', $dgrrow['date']);
                $dgrtempDate = date('Y-m-d', strtotime($dgrtempDateHolder));

                if ($dgrtempDate < $sDate) {
                    $returnDgr[] = $dgrrow;
                    $LastDgr = end($returnDgr);
                }
            }
        }

        if (!empty($depositArray)) {
            foreach ($depositArray as $depositrow) {
                $deposittempDateHolder = str_replace('/', '-', $depositrow['date']);
                $deposittempDate = date('Y-m-d', strtotime($deposittempDateHolder));

                if ($deposittempDate < $sDate) {
                    $returnDeposit[] = $depositrow;
                    $LastDeposit = end($returnDeposit);
                }
            }
        }

        if (!empty($socialArray)) {
            foreach ($socialArray as $socialrow) {
                $socialtempDateHolder = str_replace('/', '-', $socialrow['date']);
                $socialtempDate = date('Y-m-d', strtotime($socialtempDateHolder));

                if ($socialtempDate < $sDate) {
                    $returnSocial[] = $socialrow;
                    $LastSocial = end($returnSocial);
                }
            }
        }

        $All = array(
            0 => $LastBendigo, 1 => $LastCard, 2 => $LastCash, 3 => $LastDgr,
            4 => $LastDeposit, 5 => $LastSocial
        );

        return $All;
    }

    //get opening and closing monthly balance if no data it tries get data from previous month
    // or it return no data for that month
    public function GetOpeningClosingMonthlyBalance($tablename, $startDate, $endofMonth)
    {
       
        $sql = "Select income, expense, date, balance from $tablename";
        $result = $this->connection->query($sql);

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $array[] = $row;
        }

        if (!empty($array)) {
            //retrive dates inbetween;
            $returnValue = array();

            $startDate = str_replace('/', '-', $startDate);
            $startDate = date('Y-m-d', strtotime($startDate));
            
            $endofMonth = str_replace('/', '-', $endofMonth);
            $endofMonth = date('Y-m-d', strtotime($endofMonth));
            
            $previousBalance = array();

        
            foreach ($array as $row) {
                $tempDateHolder = str_replace('/', '-', $row['date']);
                $tempDate = date('Y-m-d', strtotime($tempDateHolder));


                if (($tempDate >= $startDate) && ($tempDate < $endofMonth)) {
                    $returnValue[] = $row;
                }

                if ($tempDate < $startDate) {
                    $previousBalance[] = $row;
                }
            }

            if (empty($returnValue)) {

                if (!empty($previousBalance)) {
                    $final = array(
                        "Opening" => "NO DATA WITHIN THAT RANGE",
                        "Closing" => "NO DATA WITHIN THAT RANGE",
                    );
                } else {
                    $final = array(
                        "Opening" => "NO DATA WITHIN THAT RANGE",
                        "Closing" => "NO DATA WITHIN THAT RANGE"
                    );
                }

                return $final;
            } else {

                $final = array(
                    "Opening" => $returnValue[0]['balance'],
                    "Closing" => $returnValue[sizeof($returnValue) - 1]['balance'],
                    "income" => $returnValue,
                    "expense" => $returnValue
                );

                return $final;
            }
        } else {
            $final = array(
                "Opening" => "NO DATA WITHIN THAT RANGE",
                "Closing" => "NO DATA WITHIN THAT RANGE"
            );
            return $final;
        }
    }

    // using get openingand closing monthly balance this gets data for eah table
    public function getMonthlyReport($month, $year)
    {
        
        if($month < 10){
            $month = '0'.$month;
        }
        $startDate = '01/'.$month.'/'.$year.'';

        if($month < 12){
            $month++;
            if($month < 10){
                $month = '0'.$month;
            }
        }

        $endDate = '01/'.$month.'/'.$year.'';

        echo $endDate;

        $result = array();
        $tables = array('Bendigo', 'Card', 'Cash', 'DGR', 'Deposit', 'Social');
        for ($i = 0; $i < sizeof($tables); $i++) {
            $arr = array(
                $tables[$i] => $this->GetOpeningClosingMonthlyBalance($tables[$i], $startDate, $endDate)
            );
            array_push($result, $arr);
        }

        return $result;
    }


    // baed on id and table get invoices
    public function getInvoices($table_name, $id)
    {
        $result = $this->connection->query('Select invoice from ' . $table_name . ' where Id = ' . $id);

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $array[] = $row;
        }
        return $array;
    }


    //given array add all the expenses
    function addExpense($array)
    {
        $total = 0;
        if (!empty($array)) {
            foreach ($array as $row) {
                if (!empty($row['expense'])) {
                    $total += $row['expense'];
                }
            }
        }
        return $total;
    }


    // for search and filter return rows within provided time frame  and gst stated
    public function search($table, $category, $startDate, $endDate, $gst)
    {
        if ($gst == 1) {
            $sql = '
        Select C.date, C.description, C.income, C.expense, C.balance, C.gst,
        Ca.name as category
        from ' . $table . ' C, Category Ca
        where C.categoryId = Ca.categoryId AND C.gst = ' . $gst . ' AND C.categoryId = "' . $category . '"';
        } else {
            $sql = '
        Select C.date, C.description, C.income, C.expense, C.balance, C.gst,
        Ca.name as category
        from ' . $table . ' C,Category Ca
        where C.categoryId = Ca.categoryId AND C.categoryId = "' . $category . '" ';
        }

        $result = $this->connection->query($sql);
        if (!$result) {
            return;
        }

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $array[] = $row;
        }

        if (!empty($array)) {
            //retrive dates inbetween;
            $returnValue = array();

            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));

            foreach ($array as $row) {
                $tempDateHolder = str_replace('/', '-', $row['date']);
                $tempDate = date('Y-m-d', strtotime($tempDateHolder));

                if (($tempDate >= $startDate) && ($tempDate <= $endDate)) {
                    $returnValue[] = $row;
                }
            }

            if (empty($returnValue)) {
                return;
            } else {
                return $returnValue;
            }
        } else {
            return;
        }
    }


    // for search and filter if user select all category. again this only 
    // return rows within time frame
    public function searchAllCategory($table, $startDate, $endDate, $gst)
    {
        $result = array();
        if ($gst == 1) {
            $sql = 'Select ' . $table . '.Id, ' . $table . '.date, ' . $table .
                '.description, ' . $table . '.income, ' . $table . '.expense, ' . $table . '.balance, ' . $table .
                '.gst, Category.name as category from ' . $table .
                ' LEFT JOIN Category ON ' . $table . '.categoryId = Category.categoryId where ' . $table . '.gst = ' . $gst;
        } else {
            $sql = 'Select ' . $table . '.Id, ' . $table . '.date, ' . $table .
                '.description, ' . $table . '.income, ' . $table . '.expense, ' . $table . '.balance, ' . $table .
                '.gst, Category.name as category from ' . $table .
                ' LEFT JOIN Category ON ' . $table . '.categoryId = Category.categoryId';
        }

        $result = $this->connection->query($sql);
        if (!$result) {
            echo "Error code: 100";
            return;
        }


        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $array[] = $row;
        }


        if (!empty($array)) {
            //retrive dates inbetween;
            $returnValue = array();
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));

            foreach ($array as $row) {
                $tempDateHolder = str_replace('/', '-', $row['date']);
                $tempDate = date('Y-m-d', strtotime($tempDateHolder));

                if (($tempDate >= $startDate) && ($tempDate <= $endDate)) {
                    $returnValue[] = $row;
                }
            }

            if (empty($returnValue)) {
                return;
            } else {
                return $returnValue;
            }
        } else {
            return;
        }
    }


    //based on user input this function calls above two fucntion and combines them 
    // together and return the result 
    public function SearchFilter($tablename, $category, $startDate, $endDate, $gst)
    {

        $result = array();
        if (($tablename == "All") && ($category == "All")) {
            $result = array(
                "Bendigo" => $this->searchAllCategory("Bendigo", $startDate, $endDate, $gst),
                "Card" => $this->searchAllCategory("Card", $startDate, $endDate, $gst),
                "Cash" =>  $this->searchAllCategory("Cash", $startDate, $endDate, $gst),
                "DGR" =>  $this->searchAllCategory("DGR", $startDate, $endDate, $gst),
                "Deposit" =>  $this->searchAllCategory("Deposit", $startDate, $endDate, $gst),
                "Social" =>  $this->searchAllCategory("Social", $startDate, $endDate, $gst)
            );
        } else if (($tablename == "All") && ($category != "All")) {
            $result = array(
                "Bendigo" => $this->search("Bendigo", $category, $startDate, $endDate, $gst),
                "Card" => $this->search("Card", $category, $startDate, $endDate, $gst),
                "Cash" =>  $this->search("Cash", $category, $startDate, $endDate, $gst),
                "DGR" =>  $this->search("DGR", $category, $startDate, $endDate, $gst),
                "Deposit" =>  $this->search("Deposit", $category, $startDate, $endDate, $gst),
                "Social" =>  $this->search("Social", $category, $startDate, $endDate, $gst)
            );
        } else if (($tablename != "All") && ($category == "All")) {
            $result = array(
                $tablename => $this->searchAllCategory($tablename, $startDate, $endDate, $gst)
            );
        } else if (($tablename != "All") && ($category != "All")) {
            $result = array(
                $tablename => $this->search($tablename, $category, $startDate, $endDate, $gst)
            );
        } else {
            echo "Error code: Search Filter got invalid parameters";
        }


        $totalexpense = 0;
        $gst = 0;

        foreach ($result as $row) {
            $totalexpense += $this->addExpense($row);
        }
        if ($totalexpense != 0) {
            $gst = ($totalexpense) - ($totalexpense / 1.1);
        }

        array_push($result, array("totalexpense" => $totalexpense), array("gst" => $gst));
        //print_r($result);
        return $result;
    }




    //similar to add fucntion this ones updates
    public function updateTable($table_name, $id, $args)
    {
        $updateString = "";
        array_shift($args); // remove table
        array_shift($args); // remove id
        $size = sizeof($args);
        $counter = 0;
        foreach ($args as $k => $v) {

            if ($counter >= $size - 1) {
                $updateString = $updateString . "$k = :$k";
            } else {
                $updateString = $updateString . "$k = :$k" . ",";
            }
            $counter++;
        }

        $table = $table_name;


        if ($table == "Cash" || $table == "Bendigo" || $table == "Social" || $table == "DGR" || $table == "Deposit" || $table == "Member" || $table == "User" || $table == "Category" || $table == "Card") {
            $sql = "UPDATE $table_name SET $updateString WHERE Id = $id";
        } else {
            echo "Invalid Table Name";
            return false;
        }

        //echo $sql;
        //dont change lines below, these would be same
        $stmt = $this->connection->prepare($sql);
        foreach ($args as $k => $v) {
            //required to insert pdf file from migration
            if ($k == "invoice" && (strpos($v, '.pdf') !== false)) {
                $file = file_get_contents($v);
                $stmt->bindValue(":$k", $file, SQLITE3_BLOB);
            } else {
                $stmt->bindValue(":$k", $v);
            }
        }
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



    /* public function getBalances($table)
    {
        $sql = "Select Id,balance from $table";
        $result = $this->connection->query($sql);

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $array[] = [$row['Id'] => $row['balance'], "table" => $table];
        }

        return $array;
    } */

    // this is used by update and add to dynamically get inforamtion 
    // about previou row and modfy new row accordingly  
    public function getBalance($tablename, $id)
    {
        $sql = "Select income, expense, balance from $tablename where Id = " . $id;
        $result = $this->connection->query($sql);

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $value = $row;
        }

        return $value;
    }


    // adding data based on table and args provided. similar to update
    public function insertIntoTable($table_name, $args)
    {
        array_shift($args);
        foreach ($args as $k => $v) {
            $keys[] = "$k";
            $keys2[] = ":$k";
        }

        $keys =  implode(',', $keys);
        $keys2 = implode(',', $keys2);
        $table = $table_name;

        if ($table == "Cash" || $table == "Bendigo" || $table == "Social" || $table == "DGR" || $table == "Deposit" || $table == "Member" || $table == "User" || $table == "Category" || $table == "Card") {
            $sql = "INSERT INTO  $table_name ($keys) VALUES($keys2)";
        } else {
            return array("result" => "Invalid Table Name");
        }

        //echo $sql;
        //dont change lines below, these would be same
        $stmt = $this->connection->prepare($sql);

        foreach ($args as $k => $v) {
            if ($k == "invoice" && (strpos($v, '.pdf') !== false)) {
                //echo ".pdf detected <br/>";
                $file = file_get_contents($v);
                //echo $file;
                $stmt->bindValue(":$k", $file, SQLITE3_BLOB);
            } else {
                $stmt->bindValue(":$k", $v);
            }
        }

        if ($stmt->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // retrive all data for specific table
    public function retrieveall($table)
    {

        // Selecting tables with Invoices

        if ($table == "Cash" || $table == "Bendigo" || $table == "Social") {

            $result = $this->connection->query('Select ' . $table . '.Id, ' . $table . '.date, ' . $table .
                '.description, ' . $table . '.income, ' . $table . '.expense, ' . $table . '.balance, ' . $table .
                '.gst, Category.name as Category, ' . $table . '.invoice from ' . $table .
                ' LEFT JOIN Category ON ' . $table . '.categoryId = Category.categoryId order by Id desc');

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $array[] = $row;
            }

            return $array;
        }

        // Selecting tables with no invoices

        else if ($table == "DGR" || $table == "Deposit") {

            $result = $this->connection->query('Select ' . $table . '.Id, ' . $table . '.date, ' . $table .
                '.description, ' . $table . '.income, ' . $table . '.expense, ' . $table . '.balance, ' . $table .
                '.gst, Category.name as Category from ' . $table . ' LEFT JOIN Category ON ' . $table . '.categoryId = 
        Category.categoryId order by Id desc');

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $array[] = $row;
            }

            return $array;
        }

        // Selecting Everyting from tables with no financial records

        else if ($table == "Member" || $table == "User" || $table == "Category") {

            $result = $this->connection->query('Select * from  ' . $table);

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $array[] = $row;
            }

            return $array;
        }

        // Selecting tables with users 

        else if ($table == "Card") {

            $result = $this->connection->query('Select ' . $table . '.Id, Card.date, Card.description, 
            Card.income, Card.expense, Card.expense, Card.balance, Card.gst, Category.name as Category,
            User.name as User, Card.invoice FROM Card LEFT JOIN Category ON Card.categoryId = 
            Category.categoryId LEFT JOIN User ON Card.userId = User.userId ORDER BY Id desc');

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $array[] = $row;
            }

            return $array;
        }
    }


    // based on category get all income and expense from all table within provided time frame
    public function getCategoryIncoExpe($cat, $startDate, $endDate)
    {

        $bendigo = $this->connection->query('Select COALESCE(Bendigo.income, 0) AS Income, 
        COALESCE(Bendigo.expense, 0) AS Expense, Bendigo.date AS date FROM Category LEFT JOIN Bendigo
        ON Category.categoryId = Bendigo.categoryId WHERE Category.name = "' . $cat . '"');

        $card = $this->connection->query('Select COALESCE(Card.income, 0) AS Income, 
        COALESCE(Card.expense, 0) AS Expense, Card.date AS date FROM Category LEFT JOIN Card
        ON Category.categoryId = Card.categoryId WHERE Category.name = "' . $cat . '"');

        $cash = $this->connection->query('Select COALESCE(Cash.income, 0) AS Income, 
        COALESCE(Cash.expense, 0) AS Expense, Cash.date AS date FROM Category LEFT JOIN Cash
        ON Category.categoryId = Cash.categoryId WHERE Category.name = "' . $cat . '"');

        $dgr = $this->connection->query('Select COALESCE(DGR.income, 0) AS Income, 
        COALESCE(DGR.expense, 0) AS Expense, DGR.date AS date FROM Category LEFT JOIN DGR
        ON Category.categoryId = DGR.categoryId WHERE Category.name = "' . $cat . '"');

        $deposit = $this->connection->query('Select COALESCE(Deposit.income, 0) AS Income, 
        COALESCE(Deposit.expense, 0) AS Expense, Deposit.date AS date FROM Category LEFT JOIN Deposit
        ON Category.categoryId = Deposit.categoryId WHERE Category.name = "' . $cat . '"');

        $social = $this->connection->query('Select COALESCE(Social.income, 0) AS Income, 
        COALESCE(Social.expense, 0) AS Expense, Social.date AS date FROM Category LEFT JOIN Social
        ON Category.categoryId = Social.categoryId WHERE Category.name = "' . $cat . '"');

        while ($bendigorow = $bendigo->fetchArray(SQLITE3_ASSOC)) {
            $bendigoArray[] = $bendigorow;
        }

        while ($cardrow = $card->fetchArray(SQLITE3_ASSOC)) {
            $cardArray[] = $cardrow;
        }

        while ($cashrow = $cash->fetchArray(SQLITE3_ASSOC)) {
            $cashArray[] = $cashrow;
        }

        while ($dgrrow = $dgr->fetchArray(SQLITE3_ASSOC)) {
            $dgrArray[] = $dgrrow;
        }

        while ($depositrow = $deposit->fetchArray(SQLITE3_ASSOC)) {
            $depositArray[] = $depositrow;
        }

        while ($socialrow = $social->fetchArray(SQLITE3_ASSOC)) {
            $socialArray[] = $socialrow;
        }

        $returnBendigo = array();
        $returnCard = array();
        $returnCash = array();
        $returnDgr = array();
        $returnDeposit = array();
        $returnSocial = array();

        $sDate =  date('Y-m-d', strtotime($startDate));
        $eDate =  date('Y-m-d', strtotime($endDate));

        $bendigoIncome = 0;
        $bendigoExpense = 0;
        $cardIncome = 0;
        $cardExpense = 0;
        $cashIncome = 0;
        $cashExpense = 0;
        $dgrIncome = 0;
        $dgrExpense = 0;
        $depositIncome = 0;
        $depositExpense = 0;
        $socialIncome = 0;
        $socialExpense = 0;

        if (!empty($bendigoArray)) {

            foreach ($bendigoArray as $bendigorow) {
                $bendigotempDateHolder = str_replace('/', '-', $bendigorow['date']);
                $bendigotempDate = date('Y-m-d', strtotime($bendigotempDateHolder));

                if (($bendigotempDate >= $sDate) && ($bendigotempDate <= $eDate)) {
                    $returnBendigo[] = $bendigorow;
                    $bendigoIncome = array_sum(array_column($returnBendigo, 'Income'));
                    $bendigoExpense = array_sum(array_column($returnBendigo, 'Expense'));
                }
            }
        }

        if (!empty($cardArray)) {

            foreach ($cardArray as $cardrow) {
                $cardtempDateHolder = str_replace('/', '-', $cardrow['date']);
                $cardtempDate = date('Y-m-d', strtotime($cardtempDateHolder));

                if (($cardtempDate >= $sDate) && ($cardtempDate <= $eDate)) {
                    $returnCard[] = $cardrow;
                    $cardIncome = array_sum(array_column($returnCard, 'Income'));
                    $cardExpense = array_sum(array_column($returnCard, 'Expense'));
                }
            }
        }

        if (!empty($cashArray)) {

            foreach ($cashArray as $cashrow) {
                $cashtempDateHolder = str_replace('/', '-', $cashrow['date']);
                $cashtempDate = date('Y-m-d', strtotime($cashtempDateHolder));

                if (($cashtempDate >= $sDate) && ($cashtempDate <= $eDate)) {
                    $returnCash[] = $cashrow;
                    $cashIncome = array_sum(array_column($returnCash, 'Income'));
                    $cashExpense = array_sum(array_column($returnCash, 'Expense'));
                }
            }
        }

        if (!empty($dgrArray)) {

            foreach ($dgrArray as $dgrrow) {
                $dgrtempDateHolder = str_replace('/', '-', $dgrrow['date']);
                $dgrtempDate = date('Y-m-d', strtotime($dgrtempDateHolder));

                if (($dgrtempDate >= $sDate) && ($dgrtempDate <= $eDate)) {
                    $returnDgr[] = $dgrrow;
                    $dgrIncome = array_sum(array_column($returnDgr, 'Income'));
                    $dgrExpense = array_sum(array_column($returnDgr, 'Expense'));
                }
            }
        }

        if (!empty($depositArray)) {
            foreach ($depositArray as $depositrow) {
                $deposittempDateHolder = str_replace('/', '-', $depositrow['date']);
                $deposittempDate = date('Y-m-d', strtotime($deposittempDateHolder));

                if (($deposittempDate >= $sDate) && ($deposittempDate <= $eDate)) {
                    $returnDeposit[] = $depositrow;
                    $depositIncome = array_sum(array_column($returnDeposit, 'Income'));
                    $depositExpense = array_sum(array_column($returnDeposit, 'Expense'));
                }
            }
        }

        if (!empty($socialArray)) {
            foreach ($socialArray as $socialrow) {
                $socialtempDateHolder = str_replace('/', '-', $socialrow['date']);
                $socialtempDate = date('Y-m-d', strtotime($socialtempDateHolder));

                if (($socialtempDate >= $sDate) && ($socialtempDate <= $eDate)) {
                    $returnSocial[] = $socialrow;
                    $socialIncome = array_sum(array_column($returnSocial, 'Income'));
                    $socialExpense = array_sum(array_column($returnSocial, 'Expense'));
                }
            }
        }

        $All = array("Income" => $bendigoIncome + $cardIncome + $cashIncome + $dgrIncome + $depositIncome  +
            $socialIncome, "Expense" => $bendigoExpense + $cardExpense + $cashExpense + $dgrExpense + $depositExpense
            + $socialExpense);

        return $All;
    }



    // gets all income and expesne and add them for all table within provided time frame
    public function GrandTotalIncoExpe($startDate, $endDate)
    {

        $bendigo = $this->connection->query('Select COALESCE(income, 0) AS Income, COALESCE(expense, 0) AS Expense,
        date FROM Bendigo');

        $card = $this->connection->query('Select COALESCE(income, 0) AS Income, COALESCE(expense, 0) AS Expense,
        date FROM Card');

        $cash = $this->connection->query('Select COALESCE(income, 0) AS Income, COALESCE(expense, 0) AS Expense,
        date FROM Cash');

        $dgr = $this->connection->query('Select COALESCE(income, 0) AS Income, COALESCE(expense, 0) AS Expense,
        date FROM DGR');

        $deposit = $this->connection->query('Select COALESCE(income, 0) AS Income, COALESCE(expense, 0) AS Expense,
        date FROM Deposit');

        $social = $this->connection->query('Select COALESCE(income, 0) AS Income, COALESCE(expense, 0) AS Expense,
        date FROM Social');

        while ($bendigorow = $bendigo->fetchArray(SQLITE3_ASSOC)) {
            $bendigoArray[] = $bendigorow;
        }

        while ($cardrow = $card->fetchArray(SQLITE3_ASSOC)) {
            $cardArray[] = $cardrow;
        }

        while ($cashrow = $cash->fetchArray(SQLITE3_ASSOC)) {
            $cashArray[] = $cashrow;
        }

        while ($dgrrow = $dgr->fetchArray(SQLITE3_ASSOC)) {
            $dgrArray[] = $dgrrow;
        }

        while ($depositrow = $deposit->fetchArray(SQLITE3_ASSOC)) {
            $depositArray[] = $depositrow;
        }

        while ($socialrow = $social->fetchArray(SQLITE3_ASSOC)) {
            $socialArray[] = $socialrow;
        }

        $returnBendigo = array();
        $returnCard = array();
        $returnCash = array();
        $returnDgr = array();
        $returnDeposit = array();
        $returnSocial = array();

        $sDate =  date('Y-m-d', strtotime($startDate));
        $eDate =  date('Y-m-d', strtotime($endDate));

        $bendigoIncome = 0;
        $bendigoExpense = 0;
        $cardIncome = 0;
        $cardExpense = 0;
        $cashIncome = 0;
        $cashExpense = 0;
        $dgrIncome = 0;
        $dgrExpense = 0;
        $depositIncome = 0;
        $depositExpense = 0;
        $socialIncome = 0;
        $socialExpense = 0;


        if (!empty($bendigoArray)) {

            foreach ($bendigoArray as $bendigorow) {
                $bendigotempDateHolder = str_replace('/', '-', $bendigorow['date']);
                $bendigotempDate = date('Y-m-d', strtotime($bendigotempDateHolder));

                if (($bendigotempDate >= $sDate) && ($bendigotempDate <= $eDate)) {
                    $returnBendigo[] = $bendigorow;
                    $bendigoIncome = array_sum(array_column($returnBendigo, 'Income'));
                    $bendigoExpense = array_sum(array_column($returnBendigo, 'Expense'));
                }
            }
        }

        if (!empty($cardArray)) {

            foreach ($cardArray as $cardrow) {
                $cardtempDateHolder = str_replace('/', '-', $cardrow['date']);
                $cardtempDate = date('Y-m-d', strtotime($cardtempDateHolder));

                if (($cardtempDate >= $sDate) && ($cardtempDate <= $eDate)) {
                    $returnCard[] = $cardrow;
                    $cardIncome = array_sum(array_column($returnCard, 'Income'));
                    $cardExpense = array_sum(array_column($returnCard, 'Expense'));
                }
            }
        }

        if (!empty($cashArray)) {

            foreach ($cashArray as $cashrow) {
                $cashtempDateHolder = str_replace('/', '-', $cashrow['date']);
                $cashtempDate = date('Y-m-d', strtotime($cashtempDateHolder));

                if (($cashtempDate >= $sDate) && ($cashtempDate <= $eDate)) {
                    $returnCash[] = $cashrow;
                    $cashIncome = array_sum(array_column($returnCash, 'Income'));
                    $cashExpense = array_sum(array_column($returnCash, 'Expense'));
                }
            }
        }

        if (!empty($dgrArray)) {

            foreach ($dgrArray as $dgrrow) {
                $dgrtempDateHolder = str_replace('/', '-', $dgrrow['date']);
                $dgrtempDate = date('Y-m-d', strtotime($dgrtempDateHolder));

                if (($dgrtempDate >= $sDate) && ($dgrtempDate <= $eDate)) {
                    $returnDgr[] = $dgrrow;
                    $dgrIncome = array_sum(array_column($returnDgr, 'Income'));
                    $dgrExpense = array_sum(array_column($returnDgr, 'Expense'));
                }
            }
        }

        if (!empty($depositArray)) {
            foreach ($depositArray as $depositrow) {
                $deposittempDateHolder = str_replace('/', '-', $depositrow['date']);
                $deposittempDate = date('Y-m-d', strtotime($deposittempDateHolder));

                if (($deposittempDate >= $sDate) && ($deposittempDate <= $eDate)) {
                    $returnDeposit[] = $depositrow;
                    $depositIncome = array_sum(array_column($returnDeposit, 'Income'));
                    $depositExpense = array_sum(array_column($returnDeposit, 'Expense'));
                }
            }
        }

        if (!empty($socialArray)) {
            foreach ($socialArray as $socialrow) {
                $socialtempDateHolder = str_replace('/', '-', $socialrow['date']);
                $socialtempDate = date('Y-m-d', strtotime($socialtempDateHolder));

                if (($socialtempDate >= $sDate) && ($socialtempDate <= $eDate)) {
                    $returnSocial[] = $socialrow;
                    $socialIncome = array_sum(array_column($returnSocial, 'Income'));
                    $socialExpense = array_sum(array_column($returnSocial, 'Expense'));
                }
            }
        }

        $All = array("Income" => $bendigoIncome + $cardIncome + $cashIncome + $dgrIncome + $depositIncome +
            $socialIncome, "Expense" => $bendigoExpense + $cardExpense + $cashExpense + $dgrExpense +
            $depositExpense + $socialExpense);

        return $All;
    }



    // get last balance from all tables
    public function getCurrentBalance()
    {

        $result = $this->connection->query('Select B.balance As Bendigo, C.balance AS Card,
      Ca.balance AS Cash, D.balance AS DGR, De.balance AS Deposit, S.balance AS Social

      FROM Bendigo B, Card C, Cash Ca, DGR D, Deposit De, Social S
      ORDER BY B.Id DESC, C.Id DESC, Ca.Id DESC, D.Id DESC, De.Id DESC, S.Id DESC LIMIT 1 ');

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $array[] = $row;
        }

        $All = array(
            "Bendigo" => $array[0]['Bendigo'],
            "Card" => $array[0]['Card'], "Cash" => $array[0]['Cash'], "DGR" => $array[0]['DGR'],
            "Deposit" => $array[0]['Deposit'], "Social" => $array[0]['Social']
        );

        return $All;
    }

    // gets closing yearly balance from all tables.
    public function getYearlyClosingBalances($endDate)
    {

        $bendigo = $this->connection->query('Select balance, date FROM Bendigo ');
        $card = $this->connection->query('Select balance, date FROM Card');
        $cash = $this->connection->query('Select balance, date FROM Cash');
        $dgr = $this->connection->query('Select balance, date FROM DGR');
        $deposit = $this->connection->query('Select balance, date FROM Deposit');
        $social = $this->connection->query('Select balance, date FROM Social');

        while ($bendigorow = $bendigo->fetchArray(SQLITE3_ASSOC)) {
            $bendigoArray[] = $bendigorow;
        }

        while ($cardrow = $card->fetchArray(SQLITE3_ASSOC)) {
            $cardArray[] = $cardrow;
        }

        while ($cashrow = $cash->fetchArray(SQLITE3_ASSOC)) {
            $cashArray[] = $cashrow;
        }

        while ($dgrrow = $dgr->fetchArray(SQLITE3_ASSOC)) {
            $dgrArray[] = $dgrrow;
        }

        while ($depositrow = $deposit->fetchArray(SQLITE3_ASSOC)) {
            $depositArray[] = $depositrow;
        }

        while ($socialrow = $social->fetchArray(SQLITE3_ASSOC)) {
            $socialArray[] = $socialrow;
        }

        $returnBendigo = array();
        $returnCard = array();
        $returnCash = array();
        $returnDgr = array();
        $returnDeposit = array();
        $returnSocial = array();

        $eDate =  date('Y-m-d', strtotime($endDate));

        $LastBendigo = "There wasnt any record added during the year";
        $LastCard = "There wasnt any record added during the year";
        $LastCash = "There wasnt any record added during the year";
        $LastDgr = "There wasnt any record added during the year";
        $LastDeposit = "There wasnt any record added during the year";
        $LastSocial = "There wasnt any record added during the year";

        if (!empty($bendigoArray)) {

            foreach ($bendigoArray as $bendigorow) {
                $bendigotempDateHolder = str_replace('/', '-', $bendigorow['date']);
                $bendigotempDate = date('Y-m-d', strtotime($bendigotempDateHolder));

                if ($bendigotempDate <= $eDate) {
                    $returnBendigo[] = $bendigorow;
                    $LastBendigo = end($returnBendigo);
                }
            }
        }

        if (!empty($cardArray)) {

            foreach ($cardArray as $cardrow) {
                $cardtempDateHolder = str_replace('/', '-', $cardrow['date']);
                $cardtempDate = date('Y-m-d', strtotime($cardtempDateHolder));

                if ($cardtempDate <= $eDate) {
                    $returnCard[] = $cardrow;
                    $LastCard = end($returnCard);
                }
            }
        }

        if (!empty($cashArray)) {

            foreach ($cashArray as $cashrow) {
                $cashtempDateHolder = str_replace('/', '-', $cashrow['date']);
                $cashtempDate = date('Y-m-d', strtotime($cashtempDateHolder));

                if ($cashtempDate <= $eDate) {
                    $returnCash[] = $cashrow;
                    $LastCash = end($returnCash);
                }
            }
        }

        if (!empty($dgrArray)) {

            foreach ($dgrArray as $dgrrow) {
                $dgrtempDateHolder = str_replace('/', '-', $dgrrow['date']);
                $dgrtempDate = date('Y-m-d', strtotime($dgrtempDateHolder));

                if ($dgrtempDate <= $eDate) {
                    $returnDgr[] = $dgrrow;
                    $LastDgr = end($returnDgr);
                }
            }
        }

        if (!empty($depositArray)) {
            foreach ($depositArray as $depositrow) {
                $deposittempDateHolder = str_replace('/', '-', $depositrow['date']);
                $deposittempDate = date('Y-m-d', strtotime($deposittempDateHolder));

                if ($deposittempDate <= $eDate) {
                    $returnDeposit[] = $depositrow;
                    $LastDeposit = end($returnDeposit);
                }
            }
        }

        if (!empty($socialArray)) {
            foreach ($socialArray as $socialrow) {
                $socialtempDateHolder = str_replace('/', '-', $socialrow['date']);
                $socialtempDate = date('Y-m-d', strtotime($socialtempDateHolder));

                if ($socialtempDate <= $eDate) {
                    $returnSocial[] = $socialrow;
                    $LastSocial = end($returnSocial);
                }
            }
        }

        $All = array(
            0 => $LastBendigo, 1 => $LastCard, 2 => $LastCash, 3 => $LastDgr,
            4 => $LastDeposit, 5 => $LastSocial
        );

        return $All;
    }
}

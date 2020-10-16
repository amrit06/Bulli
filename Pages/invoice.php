<?php

include_once '../config/Database.php';
include_once '../model/Table.php';
header("Content-type: application/pdf");


if( isset($_GET['invoice']) ){
    $id = $_GET['invoice'];
    $tableName = $_GET['table'];
    echo $id;
}
$conn = new Database();
$db = $conn->connect('NewBulli.db');
$table = new Table($db);
$result = $table->getInvoices($tableName, $id);
echo $result[0]['invoice'];
print_r($result);
echo $tableName;
echo $id;
?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

<object data="data:application/pdf;base64,' . <?php echo base64_encode($result[0]['invoice']) ?> . '" type="application/pdf" style="height:200px;width:60%"></object>

</body>
</html>

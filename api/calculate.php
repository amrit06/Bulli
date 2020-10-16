<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';


$table = "";
if(isset($_GET['table'])){
    
    $Message= $_GET['table'];
    $conn = new Database();
    $db = $conn->connect();
    $table = new Table($db);
    $result = $table->calculate($Message);

    echo json_encode($result, JSON_PRETTY_PRINT);
}

?>



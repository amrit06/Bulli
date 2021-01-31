<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';

$table = "";
if(isset($_GET['table'])){
    
    $Message= $_GET['table'];
    $conn = new Database();
    $db = $conn->connect('New_Bulli.db');
    $table = new Table($db);
    $result = $table->retrieveall($Message);

    print_r($result);
}

?>



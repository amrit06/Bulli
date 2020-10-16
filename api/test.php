<?php

header('Access-Control-Allow-Origin: *');
//header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';



    echo "Hello";
    $conn = new Database();
    $db = $conn->connect("NewBulli.db");
    $table = new Table($db);
    $result = $table->getMonthlyBalances('Cash');
    print_r($result);
    $result = $table->getBalances('Cash');
    print_r($result);
    $result = $table->calculate('Cash');
    print_r($result);

?>



<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';

if(isset($_GET['category'])){
    
    $Message= $_GET['category'];
    $conn = new Database();
    $db = $conn->connect();
    $table = new Table($db);
    $array = $table->getCategoryIncoExpe($Message);

    $total = array();

    $total[0] = $array[0]['Income'] + $array[1]['Income'] + $array[2]['Income']  + $array[3]['Income'] 
    + $array[4]['Income'] + $array[5]['Income'];

    $total[1] = $array[0]['Expense'] + $array[1]['Expense'] + $array[2]['Expense']  + $array[3]['Expense'] 
   + $array[4]['Expense'] + $array[5]['Expense'];

    print_r($total);
}

?>

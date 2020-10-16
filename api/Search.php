<?php

header('Access-Control-Allow-Origin: *');
//header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new Database();
    $db = $conn->connect("NewBulli.db");echo "Unsuccess";
    $table = new Table($db);


    // "DGR", 11, "2017-06-10", "2018-01-10", ""
    $result = $table->search( $_POST['table'], $_POST['category'], $_POST['startdate'], $_POST['enddate'], $_POST['gst']);

    if($result == false){
        echo "NO DATA";
    }else{
        print_r($result);
    }

}

?>

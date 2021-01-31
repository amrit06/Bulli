<?php

header('Access-Control-Allow-Origin: *');
//header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';

$table = "";

//http://px.com/pages/cashaccount.php?date=2020-10-07&item=sdf+sfsdf+ds&income=12.90&expense=&category=cat3

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $args = [];
    foreach($_GET as $k=>$v){
        if(!empty($v)){
            $args[$k] = $v;
        }
    }

    print_r($args);
    $conn = new Database();
    $db = $conn->connect("NewBulli.db");
    $table = new Table($db);
    $table_name = $args['table'];
    $args['balance'] = $table->getLastBalance($table_name);
    if( !empty($_['income']) && !empty($_GET['expense'])  ){
        $args['balance'] = ($args['balance'] + $_GET['income']) - $_GET['expense'];
    }else if( !empty($_GET['income']) && empty($_GET['expense']) ){
        $args['balance'] = $args['balance'] + $_GET['income'];
    }else if( !empty($_GET['expense']) && empty($_GET['income']) ){
        $args['balance'] = $args['balance'] - $_GET['expense'];   
    }


    $result = $table->insertIntoTable($table_name,$args);

    if($result == true){
        echo "Success";
    }else{
        echo "Unsuccess";
    }

}


?>

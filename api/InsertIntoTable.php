<?php

header('Access-Control-Allow-Origin: *');
//header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';

$table = "";

//http://px.com/pages/cashaccount.php?date=2020-10-07&item=sdf+sfsdf+ds&income=12.90&expense=&category=cat3

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $args = [];
    foreach($_POST as $k=>$v){
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
    if( !empty($_POST['income']) && !empty($_POST['expense'])  ){
        $args['balance'] = ($args['balance'] + $_POST['income']) - $_POST['expense'];
    }else if( !empty($_POST['income']) && empty($_POST['expense']) ){
        $args['balance'] = $args['balance'] + $_POST['income'];
    }else if( !empty($_POST['expense']) && empty($_POST['income']) ){
        $args['balance'] = $args['balance'] - $_POST['expense'];   
    }


    $result = $table->insertIntoTable($table_name,$args);

    if($result == true){
        echo "Success";
    }else{
        echo "Unsuccess";
    }

}


?>

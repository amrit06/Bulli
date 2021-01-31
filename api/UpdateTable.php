<?php

header('Access-Control-Allow-Origin: *');
//header('Content-Type: JSON');

include_once '../config/Database.php';
include_once '../model/Table.php';

$table = "";

//http://px.com/pages/cashaccount.php?date=2020-10-07&item=sdf+sfsdf+ds&income=12.90&expense=&category=cat3

//update table not only updates the row but it also captures waht was the last balance and perform 
// arithmetic on that row and updates it. and it gets all the rows that comes afterward and changes their balance according 
// to new balance including calculating their row absed on their income and expenses

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $args = [];
    foreach($_POST as $k=>$v){
        if(!empty($v)){
            $args[$k] = $v;
        }
    }

    $conn = new Database();
    $db = $conn->connect("NewBulli.db");
    $table = new Table($db);
    $table_name = $args['table'];
    $id = $args['id'];
    
    $currentdetail =  $table->getBalance($table_name, $id);
    empty($currentdetail['income']) ? $currentdetail['income'] = 0:'';
    empty($currentdetail['expense']) ? $currentdetail['expense'] = 0:'';
    empty($currentdetail['balance']) ? $currentdetail['balance'] = 0:'';

    if( empty($_POST['income']) && empty($_POST['expense']) ){
        $args['income'] = $currentdetail['income'];
        $args['expense'] = $currentdetail['expense'];
        $args['balance'] = $currentdetail['balance'];

    }else if( !empty($_POST['income']) && empty($_POST['expense']) ){
        $args['balance'] = ($currentdetail['balance'] - $currentdetail['income']) + $_POST['income'] ;
        $args['income'] = $_POST['income'];
        $args['expense'] = $currentdetail['expense'];
    }else if( empty($_POST['income']) && !empty($_POST['expense']) ){
        $args['balance'] = ($currentdetail['balance'] + $currentdetail['expense']) - $_POST['expense'];
        $args['income'] = $currentdetail['income'];
        $args['expense'] = $_POST['expense'];
    }else{
        $args['balance'] = ($currentdetail['balance'] - $currentdetail['income'] + $currentdetail['expense']) + $_POST['income'] - $_POST['expense'];
        $args['income'] = $_POST['income'];
        $args['expense'] = $_POST['expense'];
    }

    $result = $table->updateTable($table_name, $id, $args);

    if($result == true){
        echo "Success";
        // change value onward!
        $last = $table->getLastId($table_name);
        for($i = $id+1; $i <= $last; $i++){
            
            $lastdetail = $table->getBalance($table_name, ($i - 1));
            $lastbalance = $lastdetail['balance'];
            
            $current = $table->getBalance($table_name, $i);
            empty($current['income']) ? $current['income'] = 0:'';
            empty($current['expense']) ? $current['expense'] = 0:'';
            empty($current['balance']) ? $current['balance'] = 0:'';

            $args2 = array();
            $args2['income'] = $current['income'];
            $args2['expense'] = $current['expense'];
            $args2['balance'] = $lastbalance + $current['income'] - $current['expense']; 

            $result2 = $table->updateTable($table_name, $i, $args2);
            if($result2 == false){
                echo "exit code: 200";
                exit;
            }
        }
        if($table_name == "Cash"){
            header("Location:../Pages/cashAccount/cashaccount.php");
        }
        if($table_name == "Bendigo"){
            header("Location:../Pages/bendigoAccount/bendigoaccount.php");
        }
        if($table_name == "DGR"){
            header("Location:../Pages/DGRAccount/DGRaccount.php");
        }
        if($table_name == "Card"){
            header("Location:../Pages/cardsAccount/cardsaccount.php");
        }
        if($table_name == "Deposit"){
            header("Location:../Pages/depositAccount/depositaccount.php");
        }
        if($table_name == "Social"){
            header("Location:../Pages/socialAccount/socialaccount.php");
        }

    }else{
        echo "Unsuccess";
    }

}

?>

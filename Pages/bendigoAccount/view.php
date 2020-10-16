<?php
    if(isset($_GET['id'])){
       
        $id = $_GET['id'];
        $conn = new Database();
        $db = $conn->connect("NewBulli.db");
        $result = $db->query('Select invoice from Bendigo where Id='.$id);
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $array[] = $row;
        }
        header('Conteent-Type: application/pdf');
        echo $array[0]['invoice'];
    }
?>
<?php

class Database {

  private $db;


    public function connect($dbname)
    {
        //if conn success return connection else catch error
        try{
            $this->db = new SQLite3('/opt/lampp/htdocs/New_Bulli/resources/db/NewBulli.db');
        }catch(Exception $e){
            echo $e->getMessage();
        }

        return $this->db;
    }


}

?>

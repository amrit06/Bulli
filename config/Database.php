<?php

class Database {

  private $db;

    // connecting database if wanna use different db just use parameter and change file path 
    public function connect($dbname)
    {
        //if conn success return connection else catch error
        try{
            $this->db = new SQLite3('/var/www/project/final/resources/db/NewBulli.db');
        }catch(Exception $e){
            echo $e->getMessage();
        }

        return $this->db;
    }


}

?>

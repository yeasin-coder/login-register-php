<?php

class Database{

    private $host_db = "localhost";
    private $user_db = "root";
    private $password_db = "";
    private $db_name = "db_login";

    public $pdo;

    public function __construct(){
        // check and create database connection
        if(!isset($this->pdo)){
            try{
            
                $link = new PDO("mysql:host=".$this->host_db.";dbname=".$this->db_name, $this->user_db, $this->password_db);

                $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $link->exec("SET CHARACTER SET utf8");
                $this->pdo = $link;

            }catch(PDOException $e){
                die("Failed to connect with database. ". $e->getMessage());
            }
        }
    }

}

?>
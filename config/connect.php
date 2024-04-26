<?php

class dataBase
{
    private $host = "153.92.13.204";
    private $user = "u462981871_pondok";
    private $pass = "Norali12";
    private $database = "u462981871_pondokku";
    private $conn;

    public function __construct(){
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->database);
    }
    public function query($sql){
        $result = $this->conn->query($sql);
        if(!$result){
            die("Connection Failed:" . mysqli_connect_error());
        }
        return $result;
    }

    public function execute($sql){
        $result = $this->conn->query($sql);
        if(!$result){
            die("Query gagal: " . $this->conn->error);
        }
        return $result;
    }
    public function getRow($sql){
        $result = $this->execute($sql);
        return $result->fetch_assoc();
    }

    public function getAllRows($sql){
        $result = $this->execute($sql);
        $output = array();
        while($row = $result->fetch_assoc()){
            $output[] = $row;
        }
        return $output;
    }

    public function getlimit($sql, $start, $length){
        $sql .= " LIMIT $start, $length";
        $result = $this->execute($sql);
        $output = array();
        while($row = $result->fetch_assoc()){
            $output[] = $row;
        }
        return $output;
    }


    public function cleanStr($str){
        return $this->conn->real_escape_string($str);
    }

    public function __destruct(){
        $this->conn->close();
    }
}

$db = new dataBase();



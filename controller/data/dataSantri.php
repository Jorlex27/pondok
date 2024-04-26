<?php

require_once("../../config/connect.php");
class DataSantri{
    private $db;
    public function __construct(){
        $this->db = new dataBase;
    }

    public function getData() {
        $query = "SELECT * FROM santri WHERE status = 'AKTIF'";
        $result = $this->db->getAllRows($query);
        return $result;
    }
    
}

$c = new DataSantri;
$data = $c->getData();

// $db = new dataBase;
// $query = "SELECT * FROM santri WHERE status = 'AKTIF'";
// $result = $db->getlimit($query, 1000, 10);

// print_r($result);

foreach($data as $row){
    print_r($row);
}
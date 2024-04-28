<?php

require_once("../../config/connect.php");
require_once("../../controller/data/dataSantri.php");

$c = new DataSantri;
$data = $c->getData();

foreach($data as $row){
    print_r($row);
}
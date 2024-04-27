<?php

require __DIR__ . '/../../config/connect.php';

$db = new dataBase();

$id = $_GET['id'];
$sql = "SELECT ids, nama, dusun, desa, kecamatan, kabupaten, ayah, tanggal, bulan, tahun FROM santri WHERE ids = '$id'";

$result = $db->getRow($sql);

print_r($result);
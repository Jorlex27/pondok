<?php
require __DIR__ . '/../../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_c = $_POST['id_c'];
    $Apdata = $_POST['Apdata'];

    $xd = $conn->query("SELECT nama, jenjang_din FROM santri WHERE ids = '$id_c'");
    if ($xd->num_rows > 0) {
        $r = $xd->fetch_assoc();
        if(strtolower($r['jenjang_din']) === strtolower($Apdata)){
            echo $id_c;
        }else{
            die("Jenjang " . $r['nama']. " bukan " . $Apdata);
        }
    } else {
        die("Data tidak ditemukan");
    }

}
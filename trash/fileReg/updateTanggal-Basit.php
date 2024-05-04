<?php
require "conn.php";

function updateDate($id, $tanggal, $conn2){
    try {
        
        $pay = $conn2->prepare("SELECT id_pay FROM payments1 WHERE ids = ?");
        $pay->bind_param("i", $id);
        $pay->execute();
        $pay_result = $pay->get_result();

        if ($pay_result->num_rows === 0) {
            throw new Exception('No payment found for the given id.');
        }

        $row = $pay_result->fetch_assoc();
        $id_pay = $row['id_pay'];

        // Update payments1 table
        $payUpdate = $conn2->prepare("UPDATE payments1 SET tanggal = ? WHERE ids = ?");
        $payUpdate->bind_param("si", $tanggal, $id);
        $payUpdate->execute();

        // Update history_pay table
        $hist = $conn2->prepare("UPDATE history_pay SET tanggal = ? WHERE id_pay1 = ?");
        $hist->bind_param("si", $tanggal, $id_pay);
        $hist->execute();

        echo "$id Mareh update tanggalnya: $tanggal";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$id = 2024042;
$tanggal = '2024-01-13 21:02:25';

updateDate($id, $tanggal, $conn2);

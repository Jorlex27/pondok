<?php

require "conn.php";

function cekDataSantri($id, $conn2)
{
    $data = $conn2->query("SELECT * FROM santri WHERE ids = '$id'");
    if (!$data) {
        return $conn2->error;
    }
    $out = $data->num_rows > 0 ? $data : "tidak ada data";
    return $out;
}

$dataS = cekDataSantri("202305158", $conn2)->fetch_assoc();

// echo '<pre>';
// print_r($dataS);
// echo '</pre>';


// echo json_encode($dataS);
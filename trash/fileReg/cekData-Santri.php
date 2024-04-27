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


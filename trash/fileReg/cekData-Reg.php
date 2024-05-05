<?php

require "conn.php";

function cekDataReg($id, $conn2)
{
    $data = $conn2->query("SELECT * FROM registrasi WHERE id = '$id'");
    if (!$data) {
        return $conn2->error;
    }
    return $data;
}

$dataR = cekDataReg("1798024922808239", $conn2)->fetch_assoc();

echo '<pre>';
print_r($dataR);
echo '</pre>';
<?php

require "conn.php";

function deleteDataReg($id, $conn2)
{
    $d = $conn2->query("DELETE FROM registrasi WHERE id = '$id'");
    if (!$d) {
        return $conn2->error;
    }
    return "ok";
}

echo deleteDataReg("1587945649854645", $conn2);
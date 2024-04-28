<?php

require "conn.php";


hapus('202404327', $conn2);


function hapus($ids, $conn2)
{
    try {
        // payments1
        $d = $conn2->query("DELETE FROM payments1 WHERE ids = '$ids'");
        if (!$d) {
            throw new Exception("Payments1");
        }

        // nota
        $f = $conn2->query("DELETE FROM nota WHERE ids = '$ids'");
        if (!$f) {
            throw new Exception("nota");
        }

        // history_pay
        $c = $conn2->query("DELETE FROM history_pay WHERE ids = '$ids'");
        if (!$c) {
            throw new Exception("history");
        }

        echo "Yap";

    } catch (\Exception $e) {
        echo "NO" . $e->getMessage();
    }
}

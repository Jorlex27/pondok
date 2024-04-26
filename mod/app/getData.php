<?php
require __DIR__ . '/../../config/conn.php';

$selectedValue = $_GET['selectedValue'];

if ($selectedValue == 'Sekretariat') {
    $sql = "SELECT
    SUM(CASE WHEN dom <> 'lppk' THEN 1 ELSE 0 END) AS ppk,
    SUM(CASE WHEN dom LIKE '%lppk%' THEN 1 ELSE 0 END) AS lppk
    FROM santri WHERE status = 'Aktif'";
} else {
    $sql = "SELECT
    SUM(CASE WHEN dom <> 'lppk' THEN 1 ELSE 0 END) AS ppk,
    SUM(CASE WHEN dom LIKE '%lppk%' THEN 1 ELSE 0 END) AS lppk
    FROM santri
    WHERE (jenjang_din = '$selectedValue' OR jenjang_am = '$selectedValue') AND status = 'Aktif'";
}

$result = $conn->query($sql);

if ($result) {
    $data = $result->fetch_assoc();

    $response = array(
        'ppk' => $data['ppk'],
        'lppk' => $data['lppk']
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo "Kesalahan dalam mengambil data dari database.";
}


$conn->close();

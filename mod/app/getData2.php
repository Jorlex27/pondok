<?php
require __DIR__ . '/../../config/conn.php';

$selectedValue = $_GET['selectedValue'];

if ($selectedValue == 'Sekretariat') {
    $sql = "SELECT
    SUM(CASE WHEN gender like '%pria%' THEN 1 ELSE 0 END) AS banin,
    SUM(CASE WHEN gender LIKE '%wanita%' THEN 1 ELSE 0 END) AS banat
    FROM santri WHERE status = 'Aktif'";
} else {
    $sql = "SELECT
    SUM(CASE WHEN gender like '%pria%' THEN 1 ELSE 0 END) AS banin,
    SUM(CASE WHEN gender LIKE '%wanita%' THEN 1 ELSE 0 END) AS banat
    FROM santri
    WHERE (jenjang_din = '$selectedValue' OR jenjang_am = '$selectedValue') AND status = 'Aktif'";
}

$result = $conn->query($sql);

if ($result) {
    $data = $result->fetch_assoc();

    $response = array(
        'banin' => $data['banin'],
        'banat' => $data['banat']
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo "Kesalahan dalam mengambil data dari database.";
}


$conn->close();

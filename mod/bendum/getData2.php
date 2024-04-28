<?php
require __DIR__ . '/../../config/conn.php';

$selectedValue = $_GET['selectedValue'];
$thn = $_GET['thn'];
$response = array();

try {
    $sql = "";
    if ($selectedValue == 'Sekretariat') {
        $sql = "SELECT
                    (SELECT COUNT(*) FROM santri WHERE ids IN (SELECT ids FROM nota WHERE thn_ajaran = '$thn' AND ket = 1)) AS sudah,
                    (SELECT COUNT(*) FROM santri WHERE ids NOT IN (SELECT ids FROM nota WHERE thn_ajaran = '$thn')) AS tidak,
                    (SELECT COUNT(*) FROM santri WHERE ids IN (SELECT ids FROM nota WHERE thn_ajaran = '$thn' AND ket = 0)) AS belum";

    } elseif ($selectedValue == 'TK') {
        $sql = "SELECT
                    (SELECT COUNT(*) FROM santri WHERE jenjang_am LIKE '%$selectedValue%' AND ids IN (SELECT ids FROM nota WHERE thn_ajaran = '$thn' AND ket = 1)) AS sudah,
                    (SELECT COUNT(*) FROM santri WHERE jenjang_am LIKE '%$selectedValue%' AND ids NOT IN (SELECT ids FROM nota WHERE thn_ajaran = '$thn')) AS tidak,
                    (SELECT COUNT(*) FROM santri WHERE jenjang_am LIKE '%$selectedValue%' AND ids IN (SELECT ids FROM nota WHERE thn_ajaran = '$thn' AND ket = 0)) AS belum";

    } else {
        $sql = "SELECT
                    (SELECT COUNT(*) FROM santri WHERE jenjang_din LIKE '%$selectedValue%' AND ids IN (SELECT ids FROM nota WHERE thn_ajaran = '$thn' AND ket = 1)) AS sudah,
                    (SELECT COUNT(*) FROM santri WHERE jenjang_din LIKE '%$selectedValue%' AND ids NOT IN (SELECT ids FROM nota WHERE thn_ajaran = '$thn')) AS tidak,
                    (SELECT COUNT(*) FROM santri WHERE jenjang_din LIKE '%$selectedValue%' AND ids IN (SELECT ids FROM nota WHERE thn_ajaran = '$thn' AND ket = 0)) AS belum";
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        $response = array(
            'sudah' => $row['sudah'],
            'tidak' => $row['tidak'],
            'belum' => $row['belum']
        );
    } else {
        $response = array('error' => "Kesalahan dalam mengambil data dari database.");
    }
} catch (Exception $e) {
    $response = array('error' => "Terjadi kesalahan: " . $e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>

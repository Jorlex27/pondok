<?php
require __DIR__ . '/../../config/conn.php';

$Apdata = $_GET['Apdata'] ?? '';
$lnk = $_GET['link'] ?? '';
$kelas = $_GET['kelas'] ?? '';
$n_id = $_GET['n_id'] ?? '';
$id = $_GET['id'] ?? '';
$choice = $_GET['choice'] ?? '';
$act = $_GET['act'] ?? '';

$date = date("Y-m-d H:i:s");

if ($kelas != '') {
    $link = '../../' . $lnk . '?Apdata=' . $Apdata . '&kelas=' . $kelas;
} else {
    $link = '../../' . $lnk . '?Apdata=' . $Apdata;
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id_u = $_SESSION['id'];

try {
    $conn->begin_transaction();

    $selectStmt = $conn->prepare("SELECT * FROM santri WHERE $n_id = ?");
    $selectStmt->bind_param("i", $id);
    $selectStmt->execute();
    $result = $selectStmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];
        $kolomSantri = ['nama', 'dusun', 'desa', 'kecamatan', 'kabupaten'];

        $oldSantriStatus = [];
        $santriValues = [];

        foreach ($kolomSantri as $col) {
            if ($col === $status) {
                $oldSantriStatus[$col] = $row[$col];
            } else {
                $santriValues[$col] = $row[$col];
            }
        }
    } else {
        throw new Exception("Data tidak ditemukan");
    }

    $dataSJSON = json_encode($santriValues);
    $oldDataJSON = json_encode(['status' => $status]);
    $newDataJSON = json_encode(['status' => $choice]);

    $insertStmt = $conn->prepare("INSERT INTO history (n_id, id_hs, data_s, old_data, new_data, act, tanggal, perubahan, id_u) VALUES (?, ?, ?, ?, ?, 'update', NOW(), 'Update status', ?)");
    $insertStmt->bind_param("sisssi", $n_id, $id, $dataSJSON, $oldDataJSON, $newDataJSON, $id_u);
    $insertStmt->execute();

    $updateStmt = $conn->prepare("UPDATE santri SET status = ? WHERE $n_id = ?");
    $updateStmt->bind_param("si", $choice, $id);
    $updateStmt->execute();

    $conn->commit();
    header('Location: ' . $link . '&status=delete');
    exit;
} catch (Exception $e) {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->rollback();
    }

    header('Location: ' . $link . '&status=nodelete&error=' . urlencode($e->getMessage()));
    exit;
} finally {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>

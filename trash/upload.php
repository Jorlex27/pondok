<?php
$targetDir = "uploads/";
$uploadedFile = $targetDir . basename($_FILES["file"]["name"]);
$namaFile = $_FILES["file"]["name"];

$nama_ID = pathinfo($namaFile, PATHINFO_FILENAME); // Ambil nama berkas tanpa ekstensi

if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadedFile)) {
    require '../config/conn.php';

    $sql = $conn->query("UPDATE santri SET foto = '$nama_ID' WHERE ids = '$nama_ID'");

    if ($sql === TRUE) {
        $response = array("status" => "success", "url" => $uploadedFile, "message" => "Update basis data berhasil.");
    } else {
        $response = array("status" => "error", "message" => "Update basis data gagal: " . $conn->error);
    }

    $conn->close();
} else {
    $response = array("status" => "error", "message" => "Gagal mengunggah berkas.");
}

echo json_encode($response);
?>

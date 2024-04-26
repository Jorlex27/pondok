<?php
$biasa = "../assets/uploads/sans/";
$targetDirWebP = "../assets/uploads/sans2/";
$namaFileBaru = $_FILES["file"]["name"];
$nama_ID = pathinfo($namaFileBaru, PATHINFO_FILENAME);

require '../config/conn.php';

$query = $conn->query("SELECT foto FROM santri WHERE ids = '$nama_ID'");
if ($query->num_rows > 0) {
    $row = $query->fetch_assoc();
    $oldPhotoName = $row["foto"];

    if (!empty($oldPhotoName)) {
        $oldPhotoPath = $targetDirWebP . $oldPhotoName;
        if (file_exists($oldPhotoPath)) {
            unlink($oldPhotoPath);
        }
    }

    if (!empty($oldPhotoName)) {
        $oldPhotoPath2 = $biasa . $oldPhotoName;
        if (file_exists($oldPhotoPath2)) {
            unlink($oldPhotoPath2);
        }
    }

    $jpegImage = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
    
    $webpImage1 = imagecreatetruecolor(imagesx($jpegImage), imagesy($jpegImage));
    imagecopy($webpImage1, $jpegImage, 0, 0, 0, 0, imagesx($jpegImage), imagesy($jpegImage));
    $outputWebP1 = $targetDirWebP . $nama_ID . '.webp';
    imagewebp($webpImage1, $outputWebP1, 80);
    
    $webpImage2 = imagecreatetruecolor(imagesx($jpegImage), imagesy($jpegImage));
    imagecopy($webpImage2, $jpegImage, 0, 0, 0, 0, imagesx($jpegImage), imagesy($jpegImage));
    $outputWebP2 = $biasa . $nama_ID . '.webp';
    imagewebp($webpImage2, $outputWebP2, 40);

    imagedestroy($jpegImage);
    imagedestroy($webpImage1);
    imagedestroy($webpImage2);

    $sql = $conn->query("UPDATE santri SET foto = '$nama_ID.webp' WHERE ids = '$nama_ID'");
    
    if ($sql === TRUE) {
        $response = array("status" => "success", "url1" => $outputWebP1, "url2" => $outputWebP2, "message" => "Update basis data berhasil.");
    } else {
        $response = array("status" => "error", "message" => "Update basis data gagal: " . $conn->error);
    }
} else {
    $response = array("status" => "error", "message" => "Gagal mengunggah berkas.");
}

$conn->close();

echo json_encode($response);
?>

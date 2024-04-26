<?php
require '../config/conn.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
$i_name = isset($_GET['i_name']) ? $_GET['i_name'] : '';
if (isset($_POST['submit'])) {
    if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK && $_FILES['excelFile']['size'] > 0) {
        $file = $_FILES['excelFile']['tmp_name'];
        $name = $_FILES['excelFile']['name'];
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $newName = $i_name . '-' . date('Y.m.d') . '.' . $extension;
        $target = "../import/file/" . $newName;
        move_uploaded_file($file, $target);
        error_reporting(0);
        ini_set('display_errors', 0);

        $spreadsheet = IOFactory::load($target);
        $worksheet = $spreadsheet->getActiveSheet();

        $highestRow = $worksheet->getHighestRow();

        for ($row = 2; $row <= $highestRow; $row++) {
            $nama = $conn->real_escape_string($worksheet->getCell('B' . $row)->getValue());

            $stmt = $conn->prepare("SELECT name FROM role WHERE name = ?");
            $stmt->bind_param("s", $nama);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                continue;
            } else {
                $stmt = $conn->prepare("INSERT INTO role (name) VALUES (?)");
                $stmt->bind_param("s", $nama);
                $stmt->execute();
            }

        }
        if ($conn->error) {
            header("Location: ../setting/setAdmin.php?status=noimport1");
            // echo $conn->error;
            exit;
        } else {
            session_start();
            $sid = $_SESSION['id'];
            $u = $conn->query("UPDATE master_data SET status = 'Imported', by_id = '$sid' WHERE name = '$i_name'");
            if($u){
                header("Location: ../setting/setAdmin.php?status=import");
                exit;
            }else{
                header("Location: ../setting/setAdmin.php?status=noimport");
                exit;
            }
        }
    } else {
        header("Location: ../setting/setAdmin.php?status=noimport");
        exit;
    }
}

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
        $newName = $i_name . ' ' . date('Y m d') . '.' . $extension;
        $target = "../import/file/" . $newName;
        move_uploaded_file($file, $target);
        error_reporting(0);
        ini_set('display_errors', 0);

        $spreadsheet = IOFactory::load($target);
        $worksheet = $spreadsheet->getActiveSheet();

        $highestRow = $worksheet->getHighestRow();

        for ($row = 2; $row <= $highestRow; $row++) {
            $ids = $conn->real_escape_string($worksheet->getCell('B' . $row)->getValue());
            $id = $conn->real_escape_string($worksheet->getCell('C' . $row)->getValue());
            $id_d = $conn->real_escape_string($worksheet->getCell('D' . $row)->getValue());
            $nik = $conn->real_escape_string($worksheet->getCell('E' . $row)->getValue());
            $nama = $conn->real_escape_string($worksheet->getCell('F' . $row)->getValue());
            $gender = $conn->real_escape_string($worksheet->getCell('G' . $row)->getValue());
            $wali = $conn->real_escape_string($worksheet->getCell('H' . $row)->getValue());
            $kls = $conn->real_escape_string($worksheet->getCell('I' . $row)->getValue());
            $jenjang = $conn->real_escape_string($worksheet->getCell('J' . $row)->getValue());
            $tempat = $conn->real_escape_string($worksheet->getCell('K' . $row)->getValue());
            $tgl = $conn->real_escape_string($worksheet->getCell('L' . $row)->getValue());
            $bln = $conn->real_escape_string($worksheet->getCell('M' . $row)->getValue());
            $thn = $conn->real_escape_string($worksheet->getCell('N' . $row)->getValue());
            $dusun = $conn->real_escape_string($worksheet->getCell('O' . $row)->getValue());
            $desa = $conn->real_escape_string($worksheet->getCell('P' . $row)->getValue());
            $kecamatan = $conn->real_escape_string($worksheet->getCell('Q' . $row)->getValue());
            $kabupaten = $conn->real_escape_string($worksheet->getCell('R' . $row)->getValue());
            $masuk = $conn->real_escape_string($worksheet->getCell('S' . $row)->getValue());
            $status = $conn->real_escape_string($worksheet->getCell('T' . $row)->getValue());

            $cek = $conn->query("SELECT ids FROM santri WHERE ids = '$ids'");
            if ($cek->num_rows > 0) {
                $up = $conn->query("UPDATE santri SET id_d = '$id_d', id_d1 = '$id', nik = '$nik', nama = '$nama', gender = '$gender', ayah = '$wali', kls_din = '$kls',
                jenjang_din = '$jenjang', tempat_lahir = '$tempat', tanggal = '$tgl', bulan = '$bln', tahun = '$thn', dusun = '$dusun',
                desa = '$desa', kecamatan = '$kecamatan', kabupaten = '$kabupaten', thn_masuk_d = '$masuk', status = '$status' WHERE ids = '$ids'");
            } else {
                $insert = $conn->query("INSERT INTO santri (ids, id_d, id_d1, nik, nama, gender, ayah, kls_din, jenjang_din, tempat_lahir, tanggal, bulan, tahun,
                dusun, desa, kecamatan, kabupaten, thn_masuk_d, status )
                VALUES ('$ids', '$id_d', '$id', '$nik', '$nama', '$gender', '$wali', '$kls', '$jenjang', '$tempat', '$tgl', '$bln', '$thn', '$dusun', '$desa', '$kecamatan', '$kabupaten', '$masuk', '$status')");
            }

        }
        if ($conn->error) {
            header("Location: ../admin/import?status=noimport1");
            // echo $conn->error;
            exit;
        } else {
            session_start();
            $sid = $_SESSION['id'];
            $u = $conn->query("UPDATE master_data SET status = 'Imported', by_id = '$sid' WHERE name = '$i_name'");
            if($u){
                header("Location: ../admin/import?status=import");
                exit;
            }else{
                header("Location: ../admin/import?status=noimport");
                exit;
            }
        }
    } else {
        header("Location: ../admin/import?status=noimport");
        exit;
    }
}
?>

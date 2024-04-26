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
            $id = $conn->real_escape_string($worksheet->getCell('c' . $row)->getValue());
            $nama = $conn->real_escape_string($worksheet->getCell('D' . $row)->getValue());
            $asal_sekolah = $conn->real_escape_string($worksheet->getCell('E' . $row)->getValue());
            $npsn = $conn->real_escape_string($worksheet->getCell('F' . $row)->getValue());
            $nsm = $conn->real_escape_string($worksheet->getCell('G' . $row)->getValue());
            $nisn = $conn->real_escape_string($worksheet->getCell('H' . $row)->getValue());
            $nik = $conn->real_escape_string($worksheet->getCell('I' . $row)->getValue());
            $tempat = $conn->real_escape_string($worksheet->getCell('J' . $row)->getValue());
            $tgl = $conn->real_escape_string($worksheet->getCell('K' . $row)->getValue());
            $bln = $conn->real_escape_string($worksheet->getCell('L' . $row)->getValue());
            $thn = $conn->real_escape_string($worksheet->getCell('M' . $row)->getValue());
            $gender = $conn->real_escape_string($worksheet->getCell('N' . $row)->getValue());
            $anak_ke = $conn->real_escape_string($worksheet->getCell('O' . $row)->getValue());
            $jml_saudara = $conn->real_escape_string($worksheet->getCell('P' . $row)->getValue());
            $dusun = $conn->real_escape_string($worksheet->getCell('Q' . $row)->getValue());
            $desa = $conn->real_escape_string($worksheet->getCell('R' . $row)->getValue());
            $kecamatan = $conn->real_escape_string($worksheet->getCell('S' . $row)->getValue());
            $kabupaten = $conn->real_escape_string($worksheet->getCell('T' . $row)->getValue());
            $provinsi = $conn->real_escape_string($worksheet->getCell('U' . $row)->getValue());
            $kode_pos = $conn->real_escape_string($worksheet->getCell('V' . $row)->getValue());
            $kk = $conn->real_escape_string($worksheet->getCell('W' . $row)->getValue());
            $ayah = $conn->real_escape_string($worksheet->getCell('X' . $row)->getValue());
            $status_a = $conn->real_escape_string($worksheet->getCell('Y' . $row)->getValue());
            $nik_a = $conn->real_escape_string($worksheet->getCell('Z' . $row)->getValue());
            $tl_a = $conn->real_escape_string($worksheet->getCell('AA' . $row)->getValue());
            $tgl_a = $conn->real_escape_string($worksheet->getCell('AB' . $row)->getValue());
            $bln_a = $conn->real_escape_string($worksheet->getCell('AC' . $row)->getValue());
            $thn_a = $conn->real_escape_string($worksheet->getCell('AD' . $row)->getValue());
            $pendidikan_a = $conn->real_escape_string($worksheet->getCell('AE' . $row)->getValue());
            $pekerjaan_a = $conn->real_escape_string($worksheet->getCell('AF' . $row)->getValue());
            $ibu = $conn->real_escape_string($worksheet->getCell('AG' . $row)->getValue());
            $status_i = $conn->real_escape_string($worksheet->getCell('AH' . $row)->getValue());
            $nik_i = $conn->real_escape_string($worksheet->getCell('AI' . $row)->getValue());
            $tl_i = $conn->real_escape_string($worksheet->getCell('AJ' . $row)->getValue());
            $tgl_i = $conn->real_escape_string($worksheet->getCell('AK' . $row)->getValue());
            $bln_i = $conn->real_escape_string($worksheet->getCell('AL' . $row)->getValue());
            $thn_i = $conn->real_escape_string($worksheet->getCell('AM' . $row)->getValue());
            $pendidikan_i = $conn->real_escape_string($worksheet->getCell('AN' . $row)->getValue());
            $pekerjaan_i = $conn->real_escape_string($worksheet->getCell('AO' . $row)->getValue());
            $nohp = $conn->real_escape_string($worksheet->getCell('AP' . $row)->getValue());
            $kls = $conn->real_escape_string($worksheet->getCell('AQ' . $row)->getValue());
            $jenjang = $conn->real_escape_string($worksheet->getCell('AR' . $row)->getValue());
            $status = $conn->real_escape_string($worksheet->getCell('AS' . $row)->getValue());

            $cek = $conn->query("SELECT ids FROM santri WHERE ids = '$ids'");
            if ($cek->num_rows > 0) {
                $up = $conn->query("UPDATE santri SET id_a = '$id', nama = '$nama', asal_sekolah = '$asal_sekolah', npsn = '$npsn', 
                nsm = '$nsm', nisn = '$nisn', nik = '$nik', tempat_lahir = '$tempat', tanggal = '$tgl', bulan = '$bln', tahun = '$thn',
                gender = '$gender', anak_ke = '$anak_ke', jumlah_saudara = '$jml_saudara', dusun = '$dusun', desa = '$desa', kecamatan = '$kecamatan', kabupaten = '$kabupaten', provinsi = '$provinsi',
                kode_pos = '$kode_pos', no_kk = '$kk', ayah = '$ayah', status_a = '$status_a', nik_a = '$nik_a', tl_a = '$tl_a', tgl_a = '$tgl_a', bulan_a = '$bln_a', tahun_a = '$thn_a',
                pendidikan_a = '$pendidikan_a', pekerjaan_a = '$pekerjaan_a', ibu = '$ibu', status_i = '$status_i', nik_i = '$nik_i', tl_i = '$tl_i', tgl_i = '$tgl_i', bulan_i = '$bln_i',
                tahun_i = '$thn_i', pendidikan_i = '$pendidikan_i', pekerjaan_i = '$pekerjaan_i', no_hp = '$nohp', kls_am = '$kls', jenjang_am = '$jenjang', status = '$status' WHERE ids = '$ids'");
            } else {
                $insert = $conn->query("INSERT INTO santri (ids, id_a, nama, asal_sekolah, npsn, nsm, nisn, nik, tempat_lahir, tanggal,
                bulan, tahun, gender, anak_ke, jumlah_saudara, dusun, desa, kecamatan, kabupaten, provinsi, kode_pos, no_kk, ayah, status_a, nik_a, tl_a, tgl_a, bulan_a, 
                tahun_a, pendidikan_a, pekerjaan_a, ibu, status_i, nik_i, tl_i, tgl_i, bulan_i, tahun_i, pendidikan_i, pekerjaan_i, no_hp, kls_am, jenjang_am, status )
                VALUES ('$ids', '$id', '$nama', '$asal_sekolah', '$npsn', '$nsm', '$nisn', '$nik', '$tempat', '$tgl', '$bln', '$thn', '$gender',
                '$anak_ke', '$jml_saudara', '$dusun', '$desa', '$kecamatan', '$kabupaten', '$provinsi', '$kode_pos', '$kk', '$ayah', '$status_a',
                '$nik_a', '$tl_a', '$tgl_a', '$bln_a', '$thn_a', '$pendidikan_a', '$pekerjaan_a', '$ibu', '$status_i', '$nik_i', '$tl_i', '$tgl_i', '$bln_i', '$thn_i', '$pendidikan_i', '$pekerjaan_i', '$nohp', '$kls', '$jenjang', '$status')");
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

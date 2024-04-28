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
        $newName = $i_name . ' ' . date('Y.m.d') . '.' . $extension;
        $target = "../import/file/" . $newName;
        move_uploaded_file($file, $target);
        error_reporting(0);
        ini_set('display_errors', 0);

        $spreadsheet = IOFactory::load($target);
        $worksheet = $spreadsheet->getActiveSheet();

        $highestRow = $worksheet->getHighestRow();

        for ($row = 2; $row <= $highestRow; $row++) {
            $id = $conn->real_escape_string($worksheet->getCell('B' . $row)->getValue());
            $nama = $conn->real_escape_string($worksheet->getCell('C' . $row)->getValue());
            $kelas = $conn->real_escape_string($worksheet->getCell('D' . $row)->getValue());
            $jenjang = $conn->real_escape_string($worksheet->getCell('E' . $row)->getValue());
            $dom = $conn->real_escape_string($worksheet->getCell('F' . $row)->getValue());
            $no_kamar = $conn->real_escape_string($worksheet->getCell('G' . $row)->getValue());
            $thn_masuk = $conn->real_escape_string($worksheet->getCell('H' . $row)->getValue());
            $kk = $conn->real_escape_string($worksheet->getCell('I' . $row)->getValue());
            $nik = $conn->real_escape_string($worksheet->getCell('J' . $row)->getValue());
            $tempat = $conn->real_escape_string($worksheet->getCell('K' . $row)->getValue());
            $tgl = $conn->real_escape_string($worksheet->getCell('L' . $row)->getValue());
            $bln = $conn->real_escape_string($worksheet->getCell('M' . $row)->getValue());
            $thn = $conn->real_escape_string($worksheet->getCell('N' . $row)->getValue());
            $gender = $conn->real_escape_string($worksheet->getCell('O' . $row)->getValue());
            $agama = $conn->real_escape_string($worksheet->getCell('P' . $row)->getValue());
            $dusun = $conn->real_escape_string($worksheet->getCell('Q' . $row)->getValue());
            $desa = $conn->real_escape_string($worksheet->getCell('R' . $row)->getValue());
            $kecamatan = $conn->real_escape_string($worksheet->getCell('S' . $row)->getValue());
            $kabupaten = $conn->real_escape_string($worksheet->getCell('T' . $row)->getValue());
            $provinsi = $conn->real_escape_string($worksheet->getCell('U' . $row)->getValue());
            $anak_ke = $conn->real_escape_string($worksheet->getCell('V' . $row)->getValue());
            $jml_saudara = $conn->real_escape_string($worksheet->getCell('W' . $row)->getValue());
            $gol_darah = $conn->real_escape_string($worksheet->getCell('X' . $row)->getValue());
            $ayah = $conn->real_escape_string($worksheet->getCell('Y' . $row)->getValue());
            $nik_a = $conn->real_escape_string($worksheet->getCell('Z' . $row)->getValue());
            $tl_a = $conn->real_escape_string($worksheet->getCell('AA' . $row)->getValue());
            $tgl_a = $conn->real_escape_string($worksheet->getCell('AB' . $row)->getValue());
            $bln_a = $conn->real_escape_string($worksheet->getCell('AC' . $row)->getValue());
            $thn_a = $conn->real_escape_string($worksheet->getCell('AD' . $row)->getValue());
            $pendidikan_a = $conn->real_escape_string($worksheet->getCell('AE' . $row)->getValue());
            $pekerjaan_a = $conn->real_escape_string($worksheet->getCell('AF' . $row)->getValue());
            $ibu = $conn->real_escape_string($worksheet->getCell('AG' . $row)->getValue());
            $nik_i = $conn->real_escape_string($worksheet->getCell('AH' . $row)->getValue());
            $tl_i = $conn->real_escape_string($worksheet->getCell('AI' . $row)->getValue());
            $tgl_i = $conn->real_escape_string($worksheet->getCell('AJ' . $row)->getValue());
            $bln_i = $conn->real_escape_string($worksheet->getCell('AK' . $row)->getValue());
            $thn_i = $conn->real_escape_string($worksheet->getCell('AL' . $row)->getValue());
            $pendidikan_i = $conn->real_escape_string($worksheet->getCell('AM' . $row)->getValue());
            $pekerjaan_i = $conn->real_escape_string($worksheet->getCell('AN' . $row)->getValue());
            $nohp = $conn->real_escape_string($worksheet->getCell('AO' . $row)->getValue());
            $status = $conn->real_escape_string($worksheet->getCell('AP' . $row)->getValue());

            $cek = $conn->query("SELECT ids FROM santri WHERE ids = '$id'");
            if ($cek->num_rows > 0) {
                $up = $conn->query("UPDATE santri SET nama ='$nama', kls_din = '$kelas', jenjang_din = '$jenjang', 
                dom = '$dom', no_kamar = '$no_kamar', tahun_masuk = '$thn_masuk', no_kk = '$kk', nik = '$nik', tempat_lahir = '$tempat', tanggal = '$tgl',
                bulan = '$bln', tahun = '$thn', gender = '$gender', agama = '$agama', dusun = '$dusun', desa = '$desa', kecamatan = '$kecamatan', kabupaten = '$kabupaten',
                provinsi = '$provinsi', anak_ke = '$anak_ke', jumlah_saudara = '$jml_saudara', gol_darah = '$gol_darah', ayah = '$ayah', nik_a = '$nik_a', tl_a = '$tl_a', tgl_a = '$tgl_a', bulan_a = '$bln_a',
                tahun_a = '$thn_a', pendidikan_a = '$pendidikan_a', pekerjaan_a = '$pekerjaan_a', ibu = '$ibu', nik_i = '$nik_i', tl_i = '$tl_i', bulan_i = '$bln_i',
                tahun_i = '$thn_i', pendidikan_i = '$pendidikan_i', pekerjaan_i = '$pekerjaan_i', no_hp = '$nohp', status = '$status' WHERE ids = '$id'");
            } else {
                $insert = $conn->query("INSERT INTO santri (ids, nama, kls_din, jenjang_din, dom, no_kamar, tahun_masuk, no_kk, nik, tempat_lahir, tanggal,
                bulan, tahun, gender, agama, dusun, desa, kecamatan, kabupaten, provinsi, anak_ke, jumlah_saudara, gol_darah, ayah, nik_a, tl_a, tgl_a, bulan_a, 
                tahun_a, pendidikan_a, pekerjaan_a, ibu, nik_i, tl_i, tgl_i, bulan_i, tahun_i, pendidikan_i, pekerjaan_i, no_hp, status)
                VALUES ('$id', '$nama', '$kelas', '$jenjang', '$dom', '$no_kamar', '$thn_masuk', '$kk', '$nik', '$tempat', '$tgl', 
                '$bln', '$thn', '$gender', '$agama', '$dusun', '$desa', '$kecamatan', '$kabupaten', '$provinsi', '$anak_ke', '$jml_saudara', '$gol_darah', '$ayah', '$nik_a', '$tl_a', '$tgl_a', '$bln_a', 
                '$thn_a', '$pendidikan_a', '$pekerjaan_a', '$ibu', '$nik_i', '$tl_i', '$tgl_i', '$bln_i', '$thn_i', '$pendidikan_i', '$pekerjaan_i', '$nohp', '$status')");
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
            // echo $sid;
        }
    } else {
        header("Location: ../admin/import?status=noimport");
        exit;
    }
}
?>

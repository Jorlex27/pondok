<?php

use Respect\Validation\Rules\No;

require __DIR__ . '../../../config/conn.php';
$Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
if($kelas != ''){
    $link = '../../data/diniyah?Apdata='. $Apdata .'&kelas=' . $kelas;
}else{
    $link = '../../data/diniyah?Apdata='. $Apdata;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids= mysqli_real_escape_string($conn, $_POST['ids']);
    $id_d1= mysqli_real_escape_string($conn, $_POST['id_d1']);
    $id_d= mysqli_real_escape_string($conn, $_POST['id_d']);
    $nik= mysqli_real_escape_string($conn, $_POST['nik']);
    $nama= mysqli_real_escape_string($conn, $_POST['nama']);
    $gender= mysqli_real_escape_string($conn, $_POST['gender']);
    $ayah= mysqli_real_escape_string($conn, $_POST['ayah']);
    $kls= mysqli_real_escape_string($conn, $_POST['kls_din']);
    $jenjang= mysqli_real_escape_string($conn, $_POST['jenjang_din']);
    $tempat= mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tgl= mysqli_real_escape_string($conn, $_POST['tanggal']);
    $bln= mysqli_real_escape_string($conn, $_POST['bulan']);
    $thn= mysqli_real_escape_string($conn, $_POST['tahun']);
    $dusun= mysqli_real_escape_string($conn, $_POST['dusun']);
    $desa= mysqli_real_escape_string($conn, $_POST['desa']);
    $kecamatan= mysqli_real_escape_string($conn, $_POST['kecamatan']);
    $kabupaten= mysqli_real_escape_string($conn, $_POST['kabupaten']);
    $masuk= mysqli_real_escape_string($conn, $_POST['thn_masuk_d']);
    $status= mysqli_real_escape_string($conn, $_POST['status']);
    $foto_lama= mysqli_real_escape_string($conn, $_POST['foto_lama']);

    $changes = array();
    $beforeChanges = array();
    $dataS = array();
    $postData = array(
        'id_d1' => $id_d1,
        'id_d' => $id_d,
        'nik' => $nik,
        'nama' => $nama,
        'gender' => $gender,
        'ayah' => $ayah,
        'kls_din' => $kls,
        'jenjang_din' => $jenjang,
        'tempat_lahir' => $tempat,
        'tanggal' => $tgl,
        'bulan' => $bln,
        'tahun' => $thn,
        'dusun' => $dusun,
        'desa' => $desa,
        'kecamatan' => $kecamatan,
        'kabupaten' => $kabupaten,
        'thn_masuk_d' => $masuk,
        'status' => $status,
    );

    try{
        $query = "SELECT * FROM santri WHERE id_d1 = $id_d1";
        $result = mysqli_query($conn, $query);
        if(!$result){
            throw new Exception('no_data');
        }
        $row = mysqli_fetch_assoc($result);
        $santriData = $row;
        foreach ($postData as $columnName => $postValue) {
            if ($postValue != $santriData[$columnName]) {
                $changes[$columnName] = $postValue;
                $beforeChanges[$columnName] = $santriData[$columnName];
            }
            if ($columnName === 'nama' || $columnName === 'dusun' || $columnName === 'desa' || $columnName === 'kecamatan') {
                $dataS[$columnName] = $santriData[$columnName];
            }
        }

        $changeDescription = json_encode($changes);
        $beforeChangesD = json_encode($beforeChanges);
        $dataSJson = json_encode($dataS);
        session_start();
        $id_u = $_SESSION['id'];

        if (!empty($changes)) {
            $sql = "INSERT INTO history (n_id, id_hs, data_s, old_data, new_data, act, tanggal, perubahan, id_u)
            VALUES ('id_d1', '$id_d1', '$dataSJson', '$beforeChangesD', '$changeDescription', 'update', NOW(), 'Update Data', '$id_u')";
            $ff = $conn->query($sql);
            if(!$ff){
                throw new Exception('no_record');
            }
        }

        if ($_FILES['foto']['error'] === 0) {
            $foto = $_FILES['foto'];
        
            $nama_file = $_FILES["foto"]["name"];
            $ukuran_file = $_FILES["foto"]["size"];
            $tipe_file = $_FILES["foto"]["type"];
            $tmp_file = $_FILES["foto"]["tmp_name"];
            $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
            $nama_baru = $ids . ".webp";
            $folder = "../../assets/uploads/sans2/";
            $tujuan = $folder . $nama_baru;
            $cekF = $folder . $foto_lama;
        
            $batas_ukuran = 2 * 1024 * 1024; // 2 MB
            $jenis = array("jpg", "jpeg", "png");
        
            if ($ukuran_file > $batas_ukuran) {
                throw new Exception('ukuran');
            } elseif (!in_array(strtolower($ekstensi_file), $jenis)) {
                throw new Exception('type');
            } 
        
            $image = imagecreatefromjpeg($tmp_file);
            $webpFile = $folder . $ids . ".webp";
            $quality = 80;
        
            imagewebp($image, $webpFile, $quality);
            unlink($tmp_file);
        
            if (file_exists($cekF)) {
                unlink($cekF);
            }
        
            $uf = "UPDATE santri SET foto = '$nama_baru' WHERE id_d1 = '$id_d1'";
            $up = $conn->query($uf);
            if (!$up) {
                throw new Exception("foto_error");
            }
            
            $fotoLama = json_encode(['foto' => $foto_lama]);
            $fotoBaru = json_encode(['foto' => $nama_file]);
            $h = "INSERT INTO history (n_id, id_hs, data_s, old_data, new_data, act, tanggal, perubahan, id_u)
            VALUES ('ids', '$ids', '$dataSJson', '$fotoLama', '$fotoBaru', 'update', NOW(), 'Update Foto', '$id_u')";
            $fff = $conn->query($h);
            if(!$fff){
                throw new Exception('no_record');
            }
        }
        $sql = "UPDATE santri SET id_d1 = ?, id_d = ?, nik = ?, nama = ?, gender = ?, ayah = ?, kls_din = ?, jenjang_din = ?, tempat_lahir = ?, tanggal = ?, bulan = ?, tahun = ?, dusun = ?, desa = ?, kecamatan = ?, kabupaten = ?, thn_masuk_d = ?, status = ? WHERE ids = ?";
        $u = $conn->prepare($sql);
        
        if ($u) {
            $u->bind_param("iisssssssiiissssssi", $id_d1, $id_d, $nik, $nama, $gender, $ayah, $kls, $jenjang, $tempat, $tgl, $bln, $thn, $dusun, $desa, $kecamatan, $kabupaten, $masuk, $status, $ids);
            $ssu = $u->execute();
            if(!$ssu){
                throw new Exception("noupdate");
            }
        } else {
            throw new Exception("noupdate");
        }
        $conn->commit();
        header('location:'.$link.'&status=update');
            exit();
    }catch(Exception $e){
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->rollback();
        }
        header('location:'.$link.'&status=noupdate&err='. urlencode($e->getMessage()) .'');
        exit();
    } finally {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->close();
        }
    }
}

?>
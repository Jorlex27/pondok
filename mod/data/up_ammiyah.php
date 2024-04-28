<?php
require __DIR__ . '../../../config/conn.php';

$Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
if($kelas != ''){
    $link = '../../data/ammiyah?Apdata='. $Apdata .'&kelas=' . $kelas;
}else{
    $link = '../../data/ammiyah?Apdata='. $Apdata;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = mysqli_real_escape_string($conn, $_POST['ids']);
    $id_a = mysqli_real_escape_string($conn, $_POST['id_a']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kls_am = mysqli_real_escape_string($conn, $_POST['kls_am']);
    $jenjang_am = mysqli_real_escape_string($conn, $_POST['jenjang_am']);
    $asal_sekolah = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
    $npsn = mysqli_real_escape_string($conn, $_POST['npsn']);
    $nsm = mysqli_real_escape_string($conn, $_POST['nsm']);
    $nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $bulan = mysqli_real_escape_string($conn, $_POST['bulan']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $anak_ke = mysqli_real_escape_string($conn, $_POST['anak_ke']);
    $jumlah_saudara = mysqli_real_escape_string($conn, $_POST['jumlah_saudara']);
    $dusun = mysqli_real_escape_string($conn, $_POST['dusun']);
    $desa = mysqli_real_escape_string($conn, $_POST['desa']);
    $kecamatan = mysqli_real_escape_string($conn, $_POST['kecamatan']);
    $kabupaten = mysqli_real_escape_string($conn, $_POST['kabupaten']);
    $provinsi = mysqli_real_escape_string($conn, $_POST['provinsi']);
    $kode_pos = mysqli_real_escape_string($conn, $_POST['kode_pos']);
    $thn_masuk_a = mysqli_real_escape_string($conn, $_POST['thn_masuk_a']);
    $no_kk = mysqli_real_escape_string($conn, $_POST['no_kk']);
    $ayah = mysqli_real_escape_string($conn, $_POST['ayah']);
    $status_a = mysqli_real_escape_string($conn, $_POST['status_a']);
    $nik_a = mysqli_real_escape_string($conn, $_POST['nik_a']);
    $tl_a = mysqli_real_escape_string($conn, $_POST['tl_a']);
    $tgl_a = mysqli_real_escape_string($conn, $_POST['tgl_a']);
    $bulan_a = mysqli_real_escape_string($conn, $_POST['bulan_a']);
    $tahun_a = mysqli_real_escape_string($conn, $_POST['tahun_a']);
    $pendidikan_a = mysqli_real_escape_string($conn, $_POST['pendidikan_a']);
    $pekerjaan_a = mysqli_real_escape_string($conn, $_POST['pekerjaan_a']);
    $ibu = mysqli_real_escape_string($conn, $_POST['ibu']);
    $status_i = mysqli_real_escape_string($conn, $_POST['status_i']);
    $nik_i = mysqli_real_escape_string($conn, $_POST['nik_i']);
    $tl_i = mysqli_real_escape_string($conn, $_POST['tl_i']);
    $tgl_i = mysqli_real_escape_string($conn, $_POST['tgl_i']);
    $bulan_i = mysqli_real_escape_string($conn, $_POST['bulan_i']);
    $tahun_i = mysqli_real_escape_string($conn, $_POST['tahun_i']);
    $pendidikan_i = mysqli_real_escape_string($conn, $_POST['pendidikan_i']);
    $pekerjaan_i = mysqli_real_escape_string($conn, $_POST['pekerjaan_i']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $foto_lama = mysqli_real_escape_string($conn, $_POST['foto_lama']);

    $changes = array();
    $beforeChanges = array();
    $dataS = array();
    $postData = array(
    'id_a' => $id_a,
    'nama' => $nama,
    'kls_am' => $kls_am,
    'jenjang_am' => $jenjang_am,
    'asal_sekolah' => $asal_sekolah,
    'npsn' => $npsn,
    'nsm' => $nsm,
    'nisn' => $nisn,
    'nik' => $nik,
    'tempat_lahir' => $tempat_lahir,
    'tanggal' => $tanggal,
    'bulan' => $bulan,
    'tahun' => $tahun,
    'gender' => $gender,
    'anak_ke' => $anak_ke,
    'jumlah_saudara' => $jumlah_saudara,
    'dusun' => $dusun,
    'desa' => $desa,
    'kecamatan' => $kecamatan,
    'kabupaten' => $kabupaten,
    'provinsi' => $provinsi,
    'kode_pos' => $kode_pos,
    'thn_masuk_a' => $thn_masuk_a,
    'no_kk' => $no_kk,
    'ayah' => $ayah,
    'status_a' => $status_a,
    'nik_a' => $nik_a,
    'tl_a' => $tl_a,
    'tgl_a' => $tgl_a,
    'bulan_a' => $bulan_a,
    'tahun_a' => $tahun_a,
    'pendidikan_a' => $pendidikan_a,
    'pekerjaan_a' => $pekerjaan_a,
    'ibu' => $ibu,
    'status_i' => $status_i,
    'nik_i' => $nik_i,
    'tl_i' => $tl_i,
    'tgl_i' => $tgl_i,
    'bulan_i' => $bulan_i,
    'tahun_i' => $tahun_i,
    'pendidikan_i' => $pendidikan_i,
    'pekerjaan_i' => $pekerjaan_i,
    'no_hp' => $no_hp,
    'status' => $status
    );
    
    try{
        $query = "SELECT * FROM santri WHERE id_a = $id_a";
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
            VALUES ('id_a', '$id_a', '$dataSJson', '$beforeChangesD', '$changeDescription', 'update', NOW(), 'Update Data', '$id_u')";
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
        
            $uf = "UPDATE santri SET foto = '$nama_baru' WHERE id_a = '$id_a'";
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
        $sql = "UPDATE santri SET id_a = ?, nama = ?, kls_am = ?, jenjang_am = ?, asal_sekolah = ?, npsn = ?, nsm = ?, nisn = ?, nik = ?, tempat_lahir = ?, tanggal = ?, bulan = ?, tahun = ?, gender = ?, anak_ke = ?, jumlah_saudara = ?, dusun = ?, desa = ?, kecamatan = ?, kabupaten = ?, provinsi = ?, kode_pos = ?, thn_masuk_a = ?, no_kk = ?, ayah = ?, status_a = ?, nik_a = ?, tl_a = ?, tgl_a = ?, bulan_a = ?, tahun_a = ?, pendidikan_a = ?, pekerjaan_a = ?, ibu = ?, status_i = ?, nik_i = ?, tl_i = ?, tgl_i = ?, bulan_i = ?, tahun_i = ?, pendidikan_i = ?, pekerjaan_i = ?, no_hp = ?, status = ? WHERE ids = ?";
        $u = $conn->prepare($sql);
        
        if ($u) {
            $u->bind_param("isssssssssiiisiisssssiissssiiiisssssiiiissssi", $id_a, $nama, $kls_am, $jenjang_am, $asal_sekolah, $npsn, $nsm, $nisn, $nik, $tempat_lahir, $tanggal, $bulan, $tahun, $gender, $anak_ke, $jumlah_saudara, $dusun, $desa, $kecamatan, $kabupaten, $provinsi, $kode_pos, $thn_masuk_a, $no_kk, $ayah, $status_a, $nik_a, $tl_a, $tgl_a, $bulan_a, $tahun_a, $pendidikan_a, $pekerjaan_a, $ibu, $status_i, $nik_i, $tl_i, $tgl_i, $bulan_i, $tahun_i, $pendidikan_i, $pekerjaan_i, $no_hp, $status, $ids);
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

<?php
require __DIR__ . '../../../config/conn.php';
$Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
if($kelas != ''){
    $link = '../../sekretariat/sekretariat?Apdata='. $Apdata .'&kelas=' . $kelas;
}else{
    $link = '../../sekretariat/sekretariat?Apdata='. $Apdata;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foto_lama = mysqli_real_escape_string($conn, $_POST['foto_lama']);
    $ids = mysqli_real_escape_string($conn, $_POST['ids']);
    $id_d1 = mysqli_real_escape_string($conn, $_POST['id_d1']);
    $id_d = mysqli_real_escape_string($conn, $_POST['id_d']);
    $id_a = mysqli_real_escape_string($conn, $_POST['id_a']);
    $id_m = mysqli_real_escape_string($conn, $_POST['id_m']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kls_din = mysqli_real_escape_string($conn, $_POST['kls_din']); 
    $jenjang_din = mysqli_real_escape_string($conn, $_POST['jenjang_din']); 
    $kls_am = mysqli_real_escape_string($conn, $_POST['kls_am']);
    $jenjang_am = mysqli_real_escape_string($conn, $_POST['jenjang_am']); 
    $dom = mysqli_real_escape_string($conn, $_POST['dom']);
    $no_kamar = mysqli_real_escape_string($conn, $_POST['no_kamar']); 
    $tahun_masuk = mysqli_real_escape_string($conn, $_POST['tahun_masuk']); 
    $no_kk = mysqli_real_escape_string($conn, $_POST['no_kk']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']); 
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $bulan = mysqli_real_escape_string($conn, $_POST['bulan']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']); 
    $agama = mysqli_real_escape_string($conn, $_POST['agama']);
    $dusun = mysqli_real_escape_string($conn, $_POST['dusun']); 
    $desa = mysqli_real_escape_string($conn, $_POST['desa']); 
    $kecamatan = mysqli_real_escape_string($conn, $_POST['kecamatan']); 
    $kabupaten = mysqli_real_escape_string($conn, $_POST['kabupaten']); 
    $provinsi = mysqli_real_escape_string($conn, $_POST['provinsi']); 
    $kode_pos = mysqli_real_escape_string($conn, $_POST['kode_pos']);
    $anak_ke = mysqli_real_escape_string($conn, $_POST['anak_ke']);
    $jumlah_saudara = mysqli_real_escape_string($conn, $_POST['jumlah_saudara']);
    $gol_darah = mysqli_real_escape_string($conn, $_POST['gol_darah']); 
    $ayah = mysqli_real_escape_string($conn, $_POST['ayah']);
    $nik_a = mysqli_real_escape_string($conn, $_POST['nik_a']);
    $tl_a = mysqli_real_escape_string($conn, $_POST['tl_a']); 
    $tgl_a = mysqli_real_escape_string($conn, $_POST['tgl_a']); 
    $bulan_a = mysqli_real_escape_string($conn, $_POST['bulan_a']); 
    $tahun_a = mysqli_real_escape_string($conn, $_POST['tahun_a']);
    $pendidikan_a = mysqli_real_escape_string($conn, $_POST['pendidikan_a']); 
    $pekerjaan_a = mysqli_real_escape_string($conn, $_POST['pekerjaan_a']); 
    $ibu = mysqli_real_escape_string($conn, $_POST['ibu']); 
    $nik_i = mysqli_real_escape_string($conn, $_POST['nik_i']); 
    $tl_i = mysqli_real_escape_string($conn, $_POST['tl_i']);
    $tgl_i = mysqli_real_escape_string($conn, $_POST['tgl_i']); 
    $bulan_i = mysqli_real_escape_string($conn, $_POST['bulan_i']); 
    $tahun_i = mysqli_real_escape_string($conn, $_POST['tahun_i']); 
    $pendidikan_i = mysqli_real_escape_string($conn, $_POST['pendidikan_i']);
    $pekerjaan_i = mysqli_real_escape_string($conn, $_POST['pekerjaan_i']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $changes = array();
    $beforeChanges = array();
    $dataS = array();
    $postData = array(
        'id_d1' => $id_d1,
        'id_d' => $id_d,
        'id_a' => $id_a,
        'id_m' => $id_m,
        'nama' => $nama,
        'kls_din' => $kls_din,
        'jenjang_din' => $jenjang_din,
        'kls_am' => $kls_am,
        'jenjang_am' => $jenjang_am,
        'dom' => $dom,
        'no_kamar' => $no_kamar,
        'tahun_masuk' => $tahun_masuk,
        'no_kk' => $no_kk,
        'nik' => $nik,
        'tempat_lahir' => $tempat_lahir,
        'tanggal' => $tanggal,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'gender' => $gender,
        'agama' => $agama,
        'dusun' => $dusun,
        'desa' => $desa,
        'kecamatan' => $kecamatan,
        'kabupaten' => $kabupaten,
        'provinsi' => $provinsi,
        'kode_pos' => $kode_pos,
        'anak_ke' => $anak_ke,
        'jumlah_saudara' => $jumlah_saudara,
        'gol_darah' => $gol_darah,
        'ayah' => $ayah,
        'nik_a' => $nik_a,
        'tl_a' => $tl_a,
        'tgl_a' => $tgl_a,
        'bulan_a' => $bulan_a,
        'tahun_a' => $tahun_a,
        'pendidikan_a' => $pendidikan_a,
        'pekerjaan_a' => $pekerjaan_a,
        'ibu' => $ibu,
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
        $query = "SELECT * FROM santri WHERE ids = $ids";
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
            VALUES (?, ?, ?, ?, ?, 'update', NOW(), 'Update Data', ?)";

            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sssssi", $ids, $ids, $dataSJson, $beforeChangesD, $changeDescription, $id_u);
                $stmt->execute();

                if ($stmt->errno) {
                    throw new Exception('no_record: ' . $stmt->error);
                }

                $stmt->close();
            } else {
                throw new Exception('Failed to prepare statement');
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
        
            $uf = "UPDATE santri SET foto = '$nama_baru' WHERE ids = '$ids'";
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
        
        $sql = "UPDATE santri SET ids = ?, id_d1 = ?, id_d = ?, id_a = ?, id_m = ?, nama = ?, kls_din = ?, jenjang_din = ?, kls_am = ?, jenjang_am = ?, dom = ?, no_kamar = ?, tahun_masuk = ?, no_kk = ?, nik = ?, tempat_lahir = ?, tanggal = ?, bulan = ?, tahun = ?, gender = ?, agama = ?, dusun = ?, desa = ?, kecamatan = ?, kabupaten = ?, provinsi = ?, kode_pos = ?, anak_ke = ?, jumlah_saudara = ?, gol_darah = ?, ayah = ?, nik_a = ?, tl_a = ?, tgl_a = ?, bulan_a = ?, tahun_a = ?, pendidikan_a = ?, pekerjaan_a = ?, ibu = ?, nik_i = ?, tl_i = ?, tgl_i = ?, bulan_i = ?, tahun_i = ?, pendidikan_i = ?, pekerjaan_i = ?, no_hp = ?, status = ? WHERE ids = ?";
        $u = $conn->prepare($sql);
        
        if ($u) {
            $u->bind_param("iiisisssssssssssiiissssssssiissssiiisssssiiissssi", $ids, $id_d1, $id_d, $id_a, $id_m, $nama, $kls_din, $jenjang_din, $kls_am, $jenjang_am, $dom, $no_kamar, $tahun_masuk, $no_kk, $nik, $tempat_lahir, $tanggal, $bulan, $tahun, $gender, $agama, $dusun, $desa, $kecamatan, $kabupaten, $provinsi, $kode_pos, $anak_ke, $jumlah_saudara, $gol_darah, $ayah, $nik_a, $tl_a, $tgl_a, $bulan_a, $tahun_a, $pendidikan_a, $pekerjaan_a, $ibu, $nik_i, $tl_i, $tgl_i, $bulan_i, $tahun_i, $pendidikan_i, $pekerjaan_i, $no_hp, $status, $ids);
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
        header('location:'.$link.'&status='. urlencode($e->getMessage()) .'');
        exit();
    } finally {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->close();
        }
    }
}

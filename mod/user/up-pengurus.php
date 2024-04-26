<?php

require __DIR__ . '/../../config/conn.php';
$link = '../../login/profile?Apdata=Profil';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_p = $_POST['id_p'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $name_user = mysqli_real_escape_string($conn, $_POST['name_user']);
    $name = $name_user;
    $tahun_masuk = mysqli_real_escape_string($conn, $_POST['tahun_masuk']);
    $no_kk = mysqli_real_escape_string($conn, $_POST['no_kk']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tgl_lahir = mysqli_real_escape_string($conn, $_POST['tgl_lahir']);
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? mysqli_real_escape_string($conn, $_POST['jenis_kelamin']) : '';
    $dusun = mysqli_real_escape_string($conn, $_POST['dusun']);
    $desa = mysqli_real_escape_string($conn, $_POST['desa']);
    $kecamatan = mysqli_real_escape_string($conn, $_POST['kecamatan']);
    $kabupaten = mysqli_real_escape_string($conn, $_POST['kabupaten']);
    $provinsi = mysqli_real_escape_string($conn, $_POST['provinsi']);
    $anak_ke = mysqli_real_escape_string($conn, $_POST['anak_ke']);
    $jumlah_saudara = mysqli_real_escape_string($conn, $_POST['jumlah_saudara']);
    $gol_darah = mysqli_real_escape_string($conn, $_POST['gol_darah']);
    $kls_am = mysqli_real_escape_string($conn, $_POST['kls_am']);
    $jenjang_am = mysqli_real_escape_string($conn, $_POST['jenjang_am']);
    $dom = mysqli_real_escape_string($conn, $_POST['dom']);
    $no_kamar = mysqli_real_escape_string($conn, $_POST['no_kamar']);
    $ayah = mysqli_real_escape_string($conn, $_POST['ayah']);
    $nik_ayah = mysqli_real_escape_string($conn, $_POST['nik_ayah']);
    $tl_a = mysqli_real_escape_string($conn, $_POST['tl_a']);
    $tgl_a = mysqli_real_escape_string($conn, $_POST['tgl_lahir_ayah']);
    $pendidikan_a = mysqli_real_escape_string($conn, $_POST['pendidikan_a']);
    $pekerjaan_a = mysqli_real_escape_string($conn, $_POST['pekerjaan_a']);
    $ibu = mysqli_real_escape_string($conn, $_POST['ibu']);
    $nik_ibu = mysqli_real_escape_string($conn, $_POST['nik_ibu']);
    $tl_i = mysqli_real_escape_string($conn, $_POST['tl_i']);
    $tgl_i = mysqli_real_escape_string($conn, $_POST['tgl_lahir_ibu']);
    $pendidikan_i = mysqli_real_escape_string($conn, $_POST['pendidikan_i']);
    $pekerjaan_i = mysqli_real_escape_string($conn, $_POST['pekerjaan_i']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $twitter = mysqli_real_escape_string($conn, $_POST['twitter']);
    $fb = mysqli_real_escape_string($conn, $_POST['fb']);
    $google = mysqli_real_escape_string($conn, $_POST['google']);
    $instagram = mysqli_real_escape_string($conn, $_POST['instagram']);
    
    $pw_lama = mysqli_real_escape_string($conn, $_POST['pw_lama']);
    $pw_baru = mysqli_real_escape_string($conn, $_POST['pw_baru']);
    $pw_baru_lagi = mysqli_real_escape_string($conn, $_POST['pw_baru_lagi']);
    
    try {
        session_start();
        $id_u = $_SESSION['id'];
        $query = $conn->prepare("SELECT * FROM pengurus WHERE id_p = ?");
        $query->bind_param("s", $id_p);
        $query->execute();
        $result = $query->get_result();
        
        $cek = false;
        if ($result->num_rows > 0) {
            $cek = true;
            if ($tahun_masuk != null && $tahun_masuk != '') {
                $updateQuery = $conn->prepare("UPDATE pengurus SET 
                    nama = ?, tahun_masuk = ?, no_kk = ?, nik = ?, tempat_lahir = ?, 
                    tgl = ?, gender = ?, dusun = ?, desa = ?, 
                    kecamatan = ?, kabupaten = ?, provinsi = ?, anak_ke = ?, jumlah_saudara = ?, 
                    gol_darah = ?, kls_am = ?, jenjang_am = ?, dom = ?, no_kamar = ?, ayah = ?, 
                    nik_ayah = ?, tl_a = ?, tgl_a = ?, 
                    pendidikan_a = ?, pekerjaan_a = ?, ibu = ?, nik_ibu = ?, tl_i = ?, 
                    tgl_i = ?, pendidikan_i = ?, pekerjaan_i = ?, 
                    no_hp = ?, twitter = ?, fb = ?, google = ?, instagram = ?
                WHERE id_p = ?");
    
                $updateQuery->bind_param("ssssssssssssssssssssssssssssssssssssi",
                    $name, $tahun_masuk, $no_kk, $nik, $tempat_lahir, $tgl_lahir, $jenis_kelamin, $dusun, $desa, $kecamatan,
                    $kabupaten, $provinsi, $anak_ke, $jumlah_saudara, $gol_darah, $kls_am, $jenjang_am, $dom, $no_kamar, $ayah,
                    $nik_ayah, $tl_a, $tgl_a, $pendidikan_a, $pekerjaan_a, $ibu, $nik_ibu, $tl_i, $tgl_i, $pendidikan_i, $pekerjaan_i, $no_hp, $twitter, $fb, $google, $instagram, $id_p);
    
                if ($updateQuery->execute()) {
                    // Pembaruan berhasil
                } else {
                    throw new Exception("noupdate_p");
                }
            }
        } else {
            $id_pp = date("Ymd") . mt_rand(1, 99);
            $insertQuery = $conn->query("INSERT INTO pengurus (id_p, nama, tahun_masuk, no_kk, nik, tempat_lahir, tgl,
            gender, dusun, desa, kecamatan, kabupaten, provinsi, anak_ke, jumlah_saudara, gol_darah, kls_am, jenjang_am,
            dom, no_kamar, ayah, nik_ayah, tl_a, tgl_a, pendidikan_a, pekerjaan_a, ibu, nik_ibu, tl_i, tgl_i,
            pendidikan_i, pekerjaan_i, no_hp, twitter, fb, google, instagram)
            VALUES ('$id_pp', '$name', '$tahun_masuk', '$no_kk', '$nik', '$tempat_lahir', '$tgl_lahir', '$jenis_kelamin', '$dusun', '$desa', '$kecamatan',
            '$kabupaten', '$provinsi', '$anak_ke', '$jumlah_saudara', '$gol_darah', '$kls_am', '$jenjang_am', '$dom', '$no_kamar', '$ayah',
            '$nik_ayah', '$tl_a', '$tgl_a', '$pendidikan_a', '$pekerjaan_a', '$ibu', '$nik_ibu', '$tl_i', '$tgl_i', '$pendidikan_i', '$pekerjaan_i', '$no_hp', '$twitter', '$fb', '$google', '$instagram')");

            if(!$insertQuery){
            die("Kesalahan dalam pernyataan persiapan: " . $conn->error);
            }

            if ($insertQuery) {
                $updateUserQuery = $conn->prepare("UPDATE user SET id_p = ?, username = ?, name = ? WHERE id = ?");
                $updateUserQuery->bind_param("issi", $id_pp, $username, $name_user, $id_u);
                if ($updateUserQuery->execute()) {
                    // Data pengguna telah diperbarui
                } else {
                    throw new Exception("no_upu");
                }
            } else {
                throw new Exception("noin_p");
            }
        }

        if ($pw_lama !== null && $pw_lama !== '') {
            $query = $conn->prepare("SELECT password FROM user WHERE id = ?");
            $query->bind_param("i", $id_u);
            $query->execute();
            $query->bind_result($password_db);
            $query->fetch();
            $query->close();
    
            if (password_verify($pw_lama, $password_db)) {
                if ($pw_baru === $pw_baru_lagi) {
                    $password_hash = password_hash($pw_baru, PASSWORD_BCRYPT);
                    $updatePasswordQuery = $conn->prepare("UPDATE user SET id_p = ?, username = ?, name = ?, password = ? WHERE id = ?");
                    $updatePasswordQuery->bind_param("isssi", $id_p, $username, $name_user, $password_hash, $id_u);
                    if ($updatePasswordQuery->execute()) {
                        // Kata sandi telah diperbarui
                    } else {
                        throw new Exception("no_uppw");
                    }
                } else {
                    throw new Exception("Konfirmasi password baru tidak cocok");
                }
            } else {
                throw new Exception("inv_pw");
            }
        }
    
        if ($_FILES['foto']['error'] === 0) {
            $foto = $_FILES['foto'];
            $nama_file = $_FILES["foto"]["name"];
            $ukuran_file = $_FILES["foto"]["size"];
            $tipe_file = $_FILES["foto"]["type"];
            $tmp_file = $_FILES["foto"]["tmp_name"];
            $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
            $nama_baru = $id_p . ".webp";
            $folder = "../../assets/uploads/pengurus/";
            $tujuan = $folder . $nama_baru;
            $cekF = $folder . $foto_lama;
            
            $batas_ukuran = 2 * 1024 * 1024; // 2 MB
            $jenis = array("jpg", "jpeg");
            
            if ($ukuran_file > $batas_ukuran) {
                throw new Exception('ukuran');
            } elseif (!in_array(strtolower($ekstensi_file), $jenis)) {
                throw new Exception('type');
            }
    
            if ($cek == true) {
                if (file_exists($cekF)) {
                    unlink($cekF);
                }
    
                $image = imagecreatefromjpeg($tmp_file);
                $webpFile = $folder .  $nama_baru;
                $quality = 80;
    
                imagewebp($image, $webpFile, $quality);
                unlink($tmp_file);
    
                $uf = $conn->prepare("UPDATE pengurus SET foto = ? WHERE id_p = ?");
                $uf->bind_param("si", $nama_baru, $id_p);
                if ($uf->execute()) {
                    // Foto telah diperbarui
                } else {
                    throw new Exception("foto_error");
                }
            } else {
                throw new Exception("no_data");
            }
        }
    
        $conn->commit();
        header('location:' . $link . '&status=update');
        exit();
    } catch (Exception $e) {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->rollback();
        }
        header('location:' . $link . '&status=' . $e->getMessage());
        exit();
    }
}
?>

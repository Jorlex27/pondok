<?php
require __DIR__ . '/../../config/conn.php';
$Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';
$lnk = isset($_GET['link']) ? $_GET['link'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$act = isset($_GET['act']) ? $_GET['act'] : '';
$n_id = isset($_GET['n_id']) ? $_GET['n_id'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';

$date = date("Y-m-d H:i:s");
if($kelas != ''){
    $link = '../../'. $lnk .'?Apdata='. $Apdata .'&kelas=' . $kelas;
}else{
    $link = '../../'. $lnk .'?Apdata='. $Apdata;
}
if($act == "del"){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $conn->begin_transaction();
    try{
        $result = $conn->query("SELECT * FROM $dari WHERE $n_id = '$id'");
        if(!$result){
            throw new Exception("data tak ning kalak");
        }
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $kolomSantri = [
                'ids', 'id_d', 'id_d1', 'id_a', 'id_m', 'nama', 'asal_sekolah', 'jurusan_sekolah_asal', 'npsn', 'nsm', 'nisn', 'tahun_masuk', 'thn_masuk_d', 'thn_masuk_a', 'thn_masuk_m', 'no_kk', 'nik', 'tempat_lahir', 'tanggal',
                'bulan', 'tahun', 'gender', 'agama', 'dusun', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'anak_ke', 'jumlah_saudara', 'gol_darah', 'ayah', 'status_a', 'nik_a', 'tl_a', 'tgl_a', 'bulan_a', 'tahun_a', 'pendidikan_a',
                'pekerjaan_a', 'ibu', 'nik_i', 'tl_i', 'tgl_i', 'bulan_i', 'tahun_i', 'pendidikan_i', 'pekerjaan_i', 'kls_din', 'jenjang_din', 'kls_am', 'jenjang_am', 'dom', 'no_kamar', 'tlpn', 'no_hp', 'status_nikah', 'email', 'foto', 'status'
            ];

            $santriValues = [];
            $santriData = [];

            foreach ($kolomSantri as $col) {
                $santriValues[$col] = $row[$col];
                if($col === 'nama' || $col === 'dusun' || $col === 'desa' || $col === 'kecamatan') {
                    $santriData[$col] = $row[$col];
                }
            }
        } else {
            throw new Exception("Ga ada data");
        }
        
        $sourceTable = $dari;
        $destinationTable = $ke;
        $columns = implode(', ', $kolomSantri);

        $sql = "INSERT INTO $destinationTable ($columns) SELECT $columns FROM $sourceTable WHERE $n_id = '$id'";
        $q = $conn->query($sql);

        if (!$q) {
            throw new Exception("tak ning pindah $conn->error");
        }

        $deleteSql = "DELETE FROM $sourceTable WHERE $n_id = '$id'";
        $qq = $conn->query($deleteSql);

        if (!$qq) {
            throw new Exception("tak ning hapus");
        }

        // $d = $conn->prepare("DELETE FROM santri WHERE $n_id = ?");
        // $d->bind_param("i", $id);
        // if(!$d->execute()){
        //     throw new Exception("tak ning hapus");
        // }
        // log
        $id_u = $_SESSION['id'];
        $oldDataJSON = json_encode($santriValues);
        $dataSJSON = json_encode($santriData);
        $sql = "INSERT INTO history (n_id, id_hs, data_s, old_data, act, tanggal, perubahan, id_u)
        VALUES ('$n_id', '$id', '$dataSJSON', '$oldDataJSON', 'back', NOW(), 'Delete from $sourceTable', '$id_u')";
        $ff = $conn->query($sql);
        if (!$ff) {
            throw new Exception("History tak masok $conn->error");
        }
        $conn->commit();
        header('Location: '. $link .'&status=delete');
        exit;
    }catch(Exception $e){
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->rollback();
        }
    
        header('Location: ' . $link . '&status=nodelete&error=' . urlencode($e->getMessage()));
        exit;
    } finally {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->close();
        }
    }
}else{
    header('Location: '. $link .'&status=nodelete');
    exit;
}
?>
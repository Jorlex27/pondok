<?php
require __DIR__ . '/../../config/conn.php';
$Apdata = $_GET['Apdata'];
$n_id = $_GET['n_id'];
$kolom = $_GET['kolom'];
$data = $_GET['data'];
$kelas = $_GET['kelas'];
if($n_id === 'id_d1'){
    $jenjang = "jenjang_din";
}else{
    $jenjang = "jenjang_am";
}

// start
$actionType = $_GET['actionType'];
if($kelas != ''){
    $link = '../../data/'. strtolower($data) .'?Apdata='. $Apdata .'&kelas=' . $kelas;
}else{
    $link = '../../data/'. strtolower($data) .'?Apdata='. $Apdata;
    // '&item='. $item .
}
if (isset($_GET['actionType'])) {
    $item = $_POST['items'];
    $kls_input = $_POST['kelas-input'];
    $kelas_input = strtoupper($kls_input);
    $actionType = $_GET['actionType'];

    if (isset($_POST['selectedItems']) && is_array($_POST['selectedItems']) && count($_POST['selectedItems']) > 0) {
        $itemIds = array_map('intval', $_POST['selectedItems']);
        $itemIdsString = implode(',', $itemIds);

        $selectedKlsDin = array();
        foreach ($itemIds as $itemId) { 
            $klsDin = $_POST['kls_din'][$itemId];
            $selectedKlsDin[] = $klsDin;
        }

        if ($actionType === 'delete') {
            // $conn->begin_transaction();
            // try{
            //     session_start();
            //     $id_u = $_SESSION['id'];
            //     foreach ($itemIds as $id_hs){
            //         $sql = "INSERT INTO history_data (n_id, id_hs, tanggal, act, `change`, kolom, from_c, by_id)
            //         VALUES ('id_d1', '$id_hs', '$date', 'noupdate', 'Dihapus', 'all', '$klsDin', '$id_u')";
            //         $f = $conn->query($sql);
            //         if (!$f) {
            //             throw new Exception("History tak masok $conn->error");
            //         }
            //     }
            //     $sql = "DELETE FROM santri WHERE id_d1 IN ($itemIdsString)";
            //     $ex = $conn->query($sql);
            //     if (!$ex) {
            //         throw new Exception("Tak ning hapus");
            //     }
            //     $conn->commit();
            //     header('Location: ' . $link . '&status=update');
            //     exit;
            // }catch(Exception $e){
            //     if (isset($conn) && $conn instanceof mysqli) {
            //         $conn->rollback();
            //     }
            
            //     header('Location: ' . $link . '&status=noupdate&error=' . urlencode($e->getMessage()));
            //     exit;
            // } finally {
            //     if (isset($conn) && $conn instanceof mysqli) {
            //         $conn->close();
            //     }
            // }
        } elseif ($actionType === 'move') {
            $conn->begin_transaction();
            try{
                session_start();
                $id_u = $_SESSION['id'];
                foreach ($itemIds as $id_hs){
                    $result = $conn->query("SELECT * FROM santri WHERE $n_id = '$id_hs'");
                    if(!$result){
                        throw new Exception("data tak ning kalak");
                    }
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $kolomSantri = [
                            $kolom, 'nama', $jenjang,'dusun', 'desa', 'kecamatan', 'kabupaten'
                        ];
            
                        $oldSantriKls = [];
                        $santriValues = [];
            
                        foreach ($kolomSantri as $col) {
                            if ($col === $kolom || $col === $jenjang) {
                                $oldSantriKls[$col] = $row[$col];
                            } else {
                                $santriValues[$col] = $row[$col];
                            }
                        }
                    } else {
                        throw new Exception("Data sudah dikembalikan");
                    }
                    $id_u = $_SESSION['id'];
                    $dataSJSON = json_encode($santriValues);
                    $oldDataJSON = json_encode($oldSantriKls);
                    $newDataJSON = json_encode([$kolom => $kelas_input, $jenjang => strtoupper($Apdata)]);
                    $sql = "INSERT INTO history (n_id, id_hs, data_s, old_data, new_data, act, tanggal, perubahan, id_u)
                    VALUES ('$n_id', '$id_hs', '$dataSJSON', '$oldDataJSON', '$newDataJSON', 'kls', NOW(), 'Naik Kelas', '$id_u')";
                    $ff = $conn->query($sql);
                    if (!$ff) {
                        throw new Exception("History tak masok $conn->error");
                    }
                }
                $u = "UPDATE santri SET $kolom = '$kelas_input' WHERE $n_id IN ($itemIdsString)";
                $up = $conn->query($u);
                if (!$up) {
                    throw new Exception("Tak ning panaik $conn->error");
                }
                $conn->commit();
                header('Location: ' . $link . '&status=update');
                exit;
            }catch(Exception $e){
                if (isset($conn) && $conn instanceof mysqli) {
                    $conn->rollback();
                }
            
                header('Location: ' . $link . '&status=noupdate&error=' . urlencode($e->getMessage()));
                exit;
            } finally {
                if (isset($conn) && $conn instanceof mysqli) {
                    $conn->close();
                }
            }
        } elseif ($actionType === 'lulus') {
            
        }
    }
}
header('Location: '.$link.'');
exit;

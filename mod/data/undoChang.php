<?php
require __DIR__ . '/../../config/conn.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function cleanI($conn, $input)
{
    return mysqli_real_escape_string($conn, $input);
}

function redirect($link, $status, $error = null)
{
    $url = $link . "&status=" . $status;
    if ($error !== null) {
        $url .= "&error=" . urlencode($error);
    }
    header('Location: ' . $url);
    exit;
}

$pesan = isset($_GET["pesan"]) ? $_GET["pesan"] : '';
$log_id = isset($_GET["log_id"]) ? $_GET["log_id"] : '';
$act = isset($_GET["act"]) ? $_GET["act"] : '';
$n_id = isset($_GET["n_id"]) ? $_GET["n_id"] : '';
$id_hs = isset($_GET["id_hs"]) ? $_GET["id_hs"] : '';

if ($n_id === 'id_d1') {
    $jenjang = "jenjang_din";
} else {
    $jenjang = "jenjang_am";
}

$link = "../../history/history?Apdata=History";
$id_u = $_SESSION['id'];

if ($pesan == "undo" && ($act == 'kls' || $act == 'update')) {
    $conn->begin_transaction();
    try {
        $log_id = cleanI($conn, $log_id);
        $act = cleanI($conn, $act);
        $n_id = cleanI($conn, $n_id);
        $id_hs = cleanI($conn, $id_hs);

        $result = $conn->query("SELECT data_s, old_data, new_data FROM history WHERE log_id = '$log_id'");

        if (!$result) {
            throw new Exception("Data tidak ditemukan");
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data = json_decode($row['data_s'], true);
            $oldData = json_decode($row['old_data'], true);
            $newData = json_decode($row['new_data'], true);
        }

        foreach ($oldData as $key => $value) {
            $u = $conn->prepare("UPDATE santri SET $key = ? WHERE $n_id = ?");
            $u->bind_param("si", $value, $id_hs);

            if (!$u->execute()) {
                throw new Exception("Gagal rollback data santri");
            }
        }

        $dataSJSON = json_encode($data);
        $oldDataJSON = json_encode($oldData);
        $newDataJSON = json_encode($newData);

        $sql = "INSERT INTO history (n_id, id_hs, data_s, old_data, new_data, act, tanggal, perubahan, id_u)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), 'Rollback', ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $n_id, $id_hs, $dataSJSON, $newDataJSON, $oldDataJSON, $act, $id_u);

        if ($stmt->execute()) {
            $conn->commit();
            redirect($link, 'update');
        } else {
            throw new Exception("History tak masuk " . $conn->error);
        }
    } catch (Exception $e) {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->rollback();
        }
        redirect($link, 'noupdate', $e->getMessage());
    } finally {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->close();
        }
    }
} elseif ($pesan == "undo" && $act == 'back') {
    $conn->begin_transaction();
    try {
        $id_hs = cleanI($conn, $id_hs);
        $result = $conn->query("SELECT data_s, old_data, new_data FROM history WHERE log_id = '$log_id'");

        if (!$result) {
            throw new Exception("Data tidak ditemukan");
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data_s = json_decode($row['data_s'], true);
            $newDataJSON = json_decode($row['new_data'], true);
            $oldDataJSON = json_decode($row['old_data'], true);

            $kolomSantri = [
                'ids', 'id_d', 'id_d1', 'id_a', 'id_m', 'nama', 'kls_din', 'jenjang_din', 'kls_am', 'jenjang_am', 'dom', 'no_kamar', 'tahun_masuk', 'no_kk', 'nik', 'tempat_lahir', 'tanggal', 'bulan', 'tahun', 'gender', 'agama', 'dusun', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'anak_ke', 'jumlah_saudara', 'gol_darah', 'ayah', 'nik_a', 'tl_a', 'tgl_a', 'bulan_a', 'tahun_a', 'pendidikan_a', 'pekerjaan_a', 'ibu', 'nik_i', 'tl_i', 'tgl_i', 'bulan_i', 'tahun_i', 'pendidikan_i', 'pekerjaan_i', 'no_hp', 'asal_sekolah', 'npsn', 'nsm', 'nisn', 'jurusan_sekolah_asal', 'status_nikah', 'email', 'status'
            ];

            $santriValues = [];
            foreach ($kolomSantri as $col) {
                $santriValues[] = isset($oldDataJSON[$col]) ? $oldDataJSON[$col] : null;
            }

            $query = "INSERT INTO santri (" . implode(", ", $kolomSantri) . ") VALUES (" . rtrim(str_repeat("?, ", count($kolomSantri)), ", ") . ")";
            $stmt = $conn->prepare($query);
            $stmt->bind_param(str_repeat("s", count($kolomSantri)), ...$santriValues);

            if ($stmt->execute()) {
                $id_u = $_SESSION['id'];
                $dataSJSON_encode = json_encode($data_s);
                $oldDataJSON_encode = json_encode($oldDataJSON);
                $newDataJSON_encode = json_encode($newDataJSON);
                $sql = "INSERT INTO history (n_id, id_hs, data_s, old_data, new_data, act, tanggal, perubahan, id_u) VALUES (?, ?, ?, ?, ?, ?, NOW(), 'Rollback Data', ?)";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    throw new Exception("Gagal merekam history " . $conn->error);
                }

                $stmt->bind_param("ssssssi", $n_id, $id_hs, $dataSJSON_encode, $newDataJSON_encode, $oldDataJSON_encode, $act, $id_u);

                if (!$stmt->execute()) {
                    throw new Exception("Tak bisa merekam history " . $conn->error);
                }

                $conn->commit();
                redirect($link, 'back');
            } else {
                throw new Exception("Data tidak dapat disalin ke tabel santri: " . $conn->error);
            }
        } else {
            throw new Exception("Ga ada data " . $conn->error);
        }
    } catch (Exception $e) {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->rollback();
        }
        redirect($link, 'noback', $e->getMessage());
    } finally {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->close();
        }
    }
} elseif ($pesan == "remove") {
    $r = $conn->prepare("DELETE FROM history WHERE log_id = ?");
    $r->bind_param("i", $log_id);

    if ($r->execute()) {
        redirect($link, 'delete');
    } else {
        redirect($link, 'nodelete');
    }
} else {
    
}
?>

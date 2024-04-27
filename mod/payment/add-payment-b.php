<?php
require __DIR__ . '/../../config/conn.php';

$link = "../../bendahara/paybaru?Apdata=Pembayaran";
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id_spp = $_POST['id_spp'];
    $id_pay = $_POST['id_pay'];
    $total = $_POST['total'];
    $sisa = $_POST['sisa'];
    $kembali = $_POST['kembali'];
    $diskon = $_POST['diskon-input'];
    $pembayaran = (float) str_replace(['Rp. ', ',', '.'], '', $_POST['pembayaran']);

    try {
        $santriData = fetchSantriData($conn, $id);
        $sppData = fetchSppData($conn, $id_spp);

        $kelas = ($sppData['jenjang'] === "TK") ? $sppData['jenjang'] : $santriData['kls_din'] . " " . $santriData['jenjang_din'];

        $id_p = '';
        $ket = false;

        if (($diskon !== null && $diskon !== '') ? ($pembayaran >= $total - ($total * ($diskon / 100))) : ($pembayaran >= $total)) {
            $ket = true;
        }

        session_start();
        $id_u = $_SESSION['id'];
        $thn = $_SESSION['thn_ajaran'];

        // ids baru
        $sql = "SELECT MAX(SUBSTRING(ids, 7)) AS max_nomor_urut 
        FROM santri ";
        $result = $conn->query($sql);
        
        if(!$result){
            throw new Exception("no_insert");
        }

        $row = $result->fetch_assoc();
        $max_nomor_urut = $row['max_nomor_urut'];
        $ids = date("Ym"). $max_nomor_urut + 1;

        $sb = $conn->query("INSERT INTO santri (ids, nama, nik, nisn, gender, anak_ke, jumlah_saudara, gol_darah, dom, tempat_lahir, tanggal, bulan, tahun, jenjang_din, kls_din, jenjang_am, kls_am, no_kk, nik_a, ayah, tl_a, tgl_a, bulan_a, tahun_a, pekerjaan_a, pendidikan_a, nik_i, ibu, tl_i, tgl_i, bulan_i, tahun_i, pekerjaan_i, pendidikan_i, dusun, desa, kecamatan, kabupaten, provinsi, no_hp)
        SELECT '$ids', nama, nik, nisn, gender, anak_ke, jumlah_saudara, gol_darah, dom, tempat_lahir, tanggal, bulan, tahun, jenjang_din, kls_din, jenjang_am, kls_am, no_kk, nik_a, ayah, tl_a, tgl_a, bulan_a, tahun_a, pekerjaan_a, pendidikan_a, nik_i, ibu, tl_i, tgl_i, bulan_i, tahun_i, pekerjaan_i, pendidikan_i, dusun, desa, kecamatan, kabupaten, provinsi, no_hp FROM registrasi WHERE id = '$id'");
        if (!$sb){
            throw new Exception("Terjadi error pada data calon santri");
        }
        // 

        $payment = min($pembayaran, $total);
        $id_p = mt_rand(1, 9999);

        $stmt = $conn->prepare("INSERT INTO payments1 (id_pay, ids, tanggal, id_spp, payment, diskon, sisa, thn_ajaran) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidids", $id_p, $ids, $id_spp, $payment, $diskon, $sisa, $thn);
        $ex = $stmt->execute();

        if (!$stmt) {
            throw new Exception("no_insert");
        }
        if (!$ex) {
            throw new Exception("no_insert");
        }

        $h = $conn->prepare("INSERT INTO history_pay (tanggal, jenis, id_pay1, id_u, ids, thn_ajaran) VALUES (NOW(), 'Pertama', ?, ?, ?, ?)");
        $h->bind_param("iiis", $id_p, $id_u, $ids, $thn);
        $hh = $h->execute();

        if (!$h) {
            throw new Exception("no_insert");
        }
        if (!$hh) {
            throw new Exception("no_insert");
        }

        $cek = $conn->query("SELECT id_not FROM nota WHERE ids = $ids");
        if (!$cek) {
            throw new Exception("no_insert");
        }
        $id_not = '';
        if ($cek->num_rows > 0) {
            $dataNot = $cek->fetch_assoc();
            $id_not = $dataNot['id_not'];
            $not = $conn->prepare("UPDATE nota SET id_pay2 = ?, ket = ? WHERE ids = ? ");
            $not->bind_param("iii", $id_p2, $ket, $ids);
            $y = $not->execute();

            if (!$not) {
                throw new Exception("no_insert");
            }
            if (!$y) {
                throw new Exception("no_insert");
            }
        } else {
            $id_not = mt_rand(1, 9999999);
            $not = $conn->prepare("INSERT INTO nota (id_not, ids, id_pay1, id_spp, ket, thn_ajaran) VALUES ( ?, ?, ?, ?, ?, ?)");
            $not->bind_param("iiiiis", $id_not, $ids, $id_p, $id_spp, $ket, $thn);
            $y = $not->execute();

            if (!$not) {
                throw new Exception("no_insert");
            }

            if (!$y) {
                throw new Exception("no_insert");
            }
        }

        $hapusReg = $conn->query("DELETE from registrasi WHERE id = '$id'");
        if(!$hapusReg){
            throw new Exception('no_insert');
        }

        $conn->commit();

        header('Location: ' . $link . '&status=pay_masok&id_not=' . $id_not . '&id='. $id);
        exit;
    } catch (Exception $e) {
        $conn->rollback();

        header('Location: ' . $link . '&status=' . $e->getMessage());
        exit;
    } finally {
        $conn->close();
    }
}

function fetchSantriData($conn, $id)
{
    $santri = $conn->query("SELECT nama, ayah, kls_din, jenjang_din from registrasi where id = '$id'");
    if (!$santri || $santri->num_rows === 0) {
        throw new Exception("Data santri tidak ditemukan");
    }
    return $santri->fetch_assoc();
}

function fetchSppData($conn, $id_spp)
{
    $spp = $conn->query("SELECT * FROM spp WHERE id_spp = '$id_spp'");
    if (!$spp || $spp->num_rows === 0) {
        throw new Exception("Data spp tidak ditemukan");
    }
    return $spp->fetch_assoc();
}

<?php
require __DIR__ . '/../../config/conn.php';

$link = "../../bendahara/payment?Apdata=Pembayaran";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = $_POST['ids'];
    $id_spp = $_POST['id_spp'];
    $id_pay = $_POST['id_pay'];
    $type = $_POST['type-pembayaran'];
    $total = $_POST['total'];
    $sisa = $_POST['sisa'];
    $kembali = $_POST['kembali'];
    $diskon = $_POST['diskon-input'];
    $pembayaran = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['pembayaran']);

    try {
        $santriData = fetchSantriData($conn, $ids);
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

        if ($type === 'satu') {
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


        } elseif ($type === 'dua') {
            if ($pembayaran < $sisa) {
                throw new Exception("kurang_pay");
            }

            $id_p2 = date("d") . $ids;
            $stmt = $conn->prepare("INSERT INTO payments2 (id_pay, ids, tanggal, id_spp, id_pay1, payment, thn_ajaran) VALUES (?, ?, NOW(), ?, ?, ?, ?)");
            $stmt->bind_param("iiiids", $id_p2, $ids, $id_spp, $id_pay, $total, $thn);
            $ex = $stmt->execute();
            if (!$stmt) {
                throw new Exception("no_insert");
            }
            if (!$ex) {
                throw new Exception("no_insert");
            }

            $up1 = $conn->prepare("UPDATE payments1 SET sisa = 0 WHERE ids = ?");
            $up1->bind_param("i", $ids);
            $exc = $up1->execute();

            if (!$up1) {
                throw new Exception("no_update_pay1");
            }
            if (!$exc) {
                throw new Exception("no_update_pay1");
            }

            $h = $conn->prepare("INSERT INTO history_pay (tanggal, jenis, id_pay2, id_u, ids, thn_ajaran) VALUES (NOW(), 'Kedua', ?, ?, ?, ?)");
            $h->bind_param("iiis", $id_p2, $id_u, $ids, $thn);
            $hh = $h->execute();

            if (!$h) {
                throw new Exception("no_insert");
            }
            if (!$hh) {
                throw new Exception("no_insert");
            }

        }

        $cek = $conn->query("SELECT id_not FROM nota WHERE ids = $ids");
        if(!$cek){
            throw new Exception("no_insert");
        }
        $id_not = '';
        if($cek->num_rows > 0){
            $dataNot = $cek->fetch_assoc();
            $id_not = $dataNot['id_not'];
            $not = $conn->prepare("UPDATE nota SET id_pay2 = ?, ket = ? WHERE ids = ? ");
            $not->bind_param("iii", $id_p2, $ket, $ids);
            $y = $not->execute();

            if(!$not){
                throw new Exception("no_insert");
            }
            if(!$y){
                throw new Exception("no_insert");
            }
        }else{
            $id_not = mt_rand(1, 9999999);
            $not = $conn->prepare("INSERT INTO nota (id_not, ids, id_pay1, id_spp, ket, thn_ajaran) VALUES ( ?, ?, ?, ?, ?, ?)");
            $not->bind_param("iiiiis", $id_not, $ids, $id_p, $id_spp, $ket, $thn);
            $y = $not->execute();

            if(!$not){
                throw new Exception("no_insert");
            }

            if(!$y){
                throw new Exception("no_insert");
            }
        }

        $conn->commit();

        header('Location: ' . $link . '&status=pay_masok&id_not='. $id_not);
        exit;
    } catch (Exception $e) {
        $conn->rollback();

        header('Location: ' . $link . '&status=' . $e->getMessage());
        exit;
    } finally {
        $conn->close();
    }
}

function fetchSantriData($conn, $ids) {
    $santri = $conn->query("SELECT nama, ayah, kls_din, jenjang_din from santri where ids = '$ids'");
    if (!$santri || $santri->num_rows === 0) {
        throw new Exception("Data santri tidak ditemukan");
    }
    return $santri->fetch_assoc();
}

function fetchSppData($conn, $id_spp) {
    $spp = $conn->query("SELECT * FROM spp WHERE id_spp = '$id_spp'");
    if (!$spp || $spp->num_rows === 0) {
        throw new Exception("Data spp tidak ditemukan");
    }
    return $spp->fetch_assoc();
}

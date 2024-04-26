<?php
require __DIR__ . '/../../config/conn.php';
require __DIR__. '/../../vendor/autoload.php';
date_default_timezone_set('Asia/Jakarta');
use GeniusTS\HijriDate\Date;

$link = "../../bendahara/payment?Apdata=Pembayaran";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try{

        $ids = filter_var($_POST['ids'], FILTER_VALIDATE_INT);
        $id_spp = filter_var($_POST['id_spp'], FILTER_VALIDATE_INT);
        $id_not = filter_var($_POST['id_not'], FILTER_VALIDATE_INT);
        $$id_pay = filter_var($_POST['$id_pay'], FILTER_VALIDATE_INT);

        if ($ids === false) {
            throw new Exception("id_invalid");
        }

        if ($id_not === false) {
            throw new Exception("id_invalid");
        }

        if ($id_spp === false) {
            throw new Exception("id_invalid");
        }

        if ($id_not === false) {
            throw new Exception("id_invalid");
        }

        $dis = $_POST['diskon'];
        $diskon = trim($dis);

        $payment1 = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['payment1']);

        if ($diskon < 0 || $diskon > 100) {
            throw new Exception("diskon_invalid");
        }

        if ($payment1 <= 0) {
            throw new Exception("Pay_isNull");
        }

        session_start();
        $thn = $_SESSION['thn_ajaran'];
        $id_u = $_SESSION['id'];

        $cp = $conn->query("SELECT ids FROM payments2 WHERE ids = '$ids' AND thn_ajaran = '$thn'");
        if(!$cp){
            throw new Exception("no_update_pay");
        }
        if($cp->num_rows>0){
            throw new Exception("Pay_lunas");
        }

        $sp = $conn->prepare("SELECT total FROM spp WHERE id_spp = ? AND thn_ajaran = ? ");
        $sp->bind_param("is", $id_spp, $thn);
        $cs = $sp->execute();
        if(!$cs){
            throw new Exception("no_update_pay"); 
        }
        $res = $sp->get_result();
        if($res->num_rows>0){
            $t = $res->fetch_assoc();
            $total = $t['total'];
        }

        if ($diskon !== null && $diskon !== 0 && $diskon !== '') {
            $sisa = $total - $payment1 - ($total * $diskon / 100);
        } else {
            $sisa = $total - $payment1;
        }        

        $up = $conn->prepare("UPDATE payments1 SET payment = ?, sisa = ?, diskon = ? WHERE ids = ? AND thn_ajaran = ?");
        $up->bind_param("ddiis", $payment1, $sisa, $diskon, $ids, $thn);
        $y = $up->execute();
        if (!$y) {
            throw new Exception("no_update_pay"); 
        }

        $h = $conn->prepare("INSERT INTO history_pay (tanggal, jenis, id_pay1, id_u, ids, thn_ajaran) VALUES (NOW(), 'Edit', ?, ?, ?, ?)");
        $h->bind_param("iiis", $id_pay, $id_u, $ids, $thn);
        $hh = $h->execute();
        if (!$hh) {
            throw new Exception("no_insert");
        }

    $conn->commit();

        header('Location: ' . $link . '&status=pay_update&id_not='. $id_not);
        exit;
    } catch (Exception $e) {
        $conn->rollback();

        header('Location: ' . $link . '&status=' . $e->getMessage());
        exit;
    } finally {
        $conn->close();
    }
}


?>
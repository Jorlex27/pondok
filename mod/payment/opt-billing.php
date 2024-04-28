<?php
require __DIR__ . '/../../config/conn.php';
require __DIR__. '/../../vendor/autoload.php';

$action = isset($_GET['action']) ? $_GET['action'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";
$link = "../../bendahara/billing?Apdata=Billing";

if ($action == "add" && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenjang = strtoupper($_POST['jenjang']);
    $nama_spp = $_POST['nama_spp'];
    $dom = $_POST['dom'];
    $uang_pangkal = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_pangkal']);
    $uang_gedung = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_gedung']);
    $uang_pembangunan = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_pembangunan']);
    $uang_ianah = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_ianah']);
    $uang_dansos = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_dansos']);
    $uang_hari_jadi = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_hari_jadi']);
    $total = $uang_pangkal + $uang_gedung + $uang_pembangunan + $uang_ianah + $uang_dansos + $uang_hari_jadi;
    $jenis = 'lama';
    try {
        session_start();
        $thn = $_SESSION['thn_ajaran'];

        // $c = $conn->query("SELECT id_spp FROM spp WHERE name = $nama_spp AND jenjang = '$jenjang' AND dom = '$dom' AND thn_ajaran = '$thn'");

        // if ($c->num_rows > 0) {
        //     throw new Exception("ada_data");
        // }

        $stmt = $conn->prepare("INSERT INTO spp (name, jenis, jenjang, dom, pangkal, gedung, pembangunan, ianah, dansos, hari_jadi, total, thn_ajaran) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssddddddds", $nama_spp, $jenis, $jenjang, $dom, $uang_pangkal, $uang_gedung, $uang_pembangunan, $uang_ianah, $uang_dansos, $uang_hari_jadi, $total, $thn);

        if ($stmt->execute()) {
            $conn->commit();
            header('Location: ' . $link . '&status=binsert');
            exit;
        } else {
            throw new Exception("no_insert" . $conn->error);
        }
    } catch (Exception $e) {
        $conn->rollback();
        header('Location: ' . $link . '&status=' . $e->getMessage());
        exit;
    } finally {
        $conn->close();
    }
} elseif ($action == "edit" && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenjang = strtoupper($_POST['jenjang']);
    $id_spp = $_POST['id_spp'];
    $nama_spp = $_POST['nama_spp'];
    $dom = $_POST['dom'];
    $uang_pangkal = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_pangkal']);
    $uang_gedung = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_gedung']);
    $uang_pembangunan = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_pembangunan']);
    $uang_ianah = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_ianah']);
    $uang_dansos = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_dansos']);
    $uang_hari_jadi = (float)str_replace(['Rp. ', ',', '.'], '', $_POST['uang_hari_jadi']);
    $total = $uang_pangkal + $uang_gedung + $uang_pembangunan + $uang_ianah + $uang_dansos + $uang_hari_jadi;

    try {
        session_start();
        $thn = $_SESSION['thn_ajaran'];

        $c = $conn->query("SELECT id_spp FROM spp WHERE id_spp = '$id_spp' AND thn_ajaran = '$thn' ");

        if ($c->num_rows < 0) {
            throw new Exception("no_data");
        }

        $stmt = $conn->prepare("UPDATE spp SET name = ?, jenjang = ?, dom = ?, pangkal = ?, gedung = ?, pembangunan = ?, ianah = ?, dansos = ?, hari_jadi = ?, total = ? WHERE id_spp = ? AND thn_ajaran = ?");
        $stmt->bind_param("sssdddddddis", $nama_spp, $jenjang, $dom, $uang_pangkal, $uang_gedung, $uang_pembangunan, $uang_ianah, $uang_dansos, $uang_hari_jadi, $total, $id_spp, $thn);

        if ($stmt->execute()) {
            $conn->commit();
            header('Location: ' . $link . '&status=bupdate');
            exit;
        } else {
            throw new Exception("no_update");
        }
    } catch (Exception $e) {
        $conn->rollback();
        header('Location: ' . $link . '&status=' . $e->getMessage());
        exit;
    } finally {
        $conn->close();
    }
} elseif ($action == "dell") {
    session_start();
    $thn = $_SESSION['thn_ajaran'];
    $id = $_GET['id'];
    $c = $conn->query("DELETE FROM spp WHERE id_spp = $id AND thn_ajaran = '$thn'");
    if ($c === true) {
        header('Location: ' . $link . '&status=bdelete');
        exit;
    } else {
        header('Location: ' . $link . '&status=bno_delete');
        exit;
    }
} else {
    header('Location: ' . $link . '&status=no');
    exit;
}
?>

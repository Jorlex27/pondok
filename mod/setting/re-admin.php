<?php
require __DIR__ . '/../../config/conn.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$link = "../../admin/setAdmin?Apdata=Admin&";

if ($action == 'remove') {
    try{
        $i = $conn->prepare("DELETE FROM master_data WHERE id = ?");
        $i->bind_param("i", $id);
        $im = $i->execute();

        if (!$im) {
            throw new Exception("mtakhapus");   
        }

        $a = $conn->prepare("DELETE FROM app WHERE id_md = ?");
        $a->bind_param("i", $id);
        $am = $i->execute();

        if (!$am) {
            throw new Exception("mtakhapus");   
        }
        $conn->commit();
        header('Location: ' . $link . 'status=mhapus');
        exit;

    }catch (Exception $e){
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->rollback();
        }
    
        header('Location: ' . $link . 'status=' . urlencode($e->getMessage()));
        exit;
    } finally {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->close();
        }
    }
} else {
    header('Location: ' . $link . 'status=mtakhapus');
    exit;
}
?>

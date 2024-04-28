<?php
require __DIR__ . '/../../config/conn.php';
$action = isset($_GET['action']) ? $_GET['action'] : '';
if($action == 'delete') {
    $id_us = isset($_GET['id']) ? $_GET['id'] : '';
    $conn->begin_transaction();
    try{
        $d = $conn->prepare("DELETE from user WHERE id = ?");
        $d->bind_param("i", $id_us);
        if(!$d->execute()){
            throw new Exception("Ga bisa dihapus dong");
        }
        $dA = $conn->prepare("DELETE FROM app WHERE id_u = ?");
        $dA->bind_param("i", $id_us);
        if(!$dA->execute()){
            throw new Exception("Yak pole tak ning hapus");
        }
        $rU = $conn->prepare("DELETE FROM role_u WHERE id_u = ?");
        $rU->bind_param("i", $id_us);
        if(!$rU->execute()){
            throw new Exception("Haduh arapah kah");
        }

        $conn->commit();
    
        header('Location: ../../admin/user-all?status=deleteok');
        exit;
    }catch (Exception $e) {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->rollback();
        }
    
        header('Location: ../../admin/user-all?status=nodelete&error=' . urlencode($e->getMessage()));
        exit;
    } finally {
        if (isset($conn) && $conn instanceof mysqli) {
            $conn->close();
        }
    }
}elseif($action == 'satuaja'){
    $id_md = isset($_GET['id']) ? $_GET['id'] : '';
    $re = $conn->prepare("DELETE from app Where id_md = ?");
    $re->bind_param("i", $id_md);
    if($re->execute()){
        header('Location: ../../admin/user-all?status=deleteok');
        exit; 
    }else{
        header('Location: ../../admin/user-all?status=nodelete');
        exit; 
    }
}elseif($action == 'jabatanaja'){
    $id_r = isset($_GET['id']) ? $_GET['id'] : '';
    $reJ = $conn->prepare("DELETE from role_u Where id_r = ?");
    $reJ->bind_param("i", $id_r);
    if($reJ->execute()){
        header('Location: ../../admin/user-all?status=deleteok');
        exit; 
    }else{
        header('Location: ../../admin/user-all?status=nodelete');
        exit; 
    }
}

?>
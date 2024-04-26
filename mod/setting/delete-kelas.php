<?php
require __DIR__ . '/../../config/conn.php';
$id = $_GET['id'] ? $_GET['id'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';
if($action == "byOne"){
    $del = $conn->query("DELETE FROM kelas WHERE id = '$id'");
    if($del){
        header('Location: ../../admin/import?status=delete');
        exit;
    }else{
        header('Location: ../../admin/import?status=nodelete');
        exit;
    }
}elseif($action == "all"){
    $cek= $conn->query("SELECT * FROM kelas WHERE id_md = '$id'");
    if($cek->num_rows>0){
        $del = $conn->query("DELETE FROM kelas WHERE id_md = '$id'");
        if($del){
            header('Location: ../../admin/import?status=delete');
            exit;
        }else{
            header('Location: ../../admin/import?status=nodelete');
            exit;
        }
    }else{
        header('Location: ../../admin/import?status=adek');
        exit;
    }
}

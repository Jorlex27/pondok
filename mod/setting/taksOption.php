<?php
require __DIR__ . '/../../config/conn.php';
if (isset($_GET['id']) && isset($_GET['mod'])) {
    $id = $_GET['id'];
    $mod = $_GET['mod'];
    if($mod == 'sudah'){
        $i = $conn->query("UPDATE reminders SET status = 1 WHERE id = '$id'");
        if($i){
            header('Location: ../../app/index?status=task');
            exit;
        }else{
            header('Location: ../../app/index?status=notask');
            exit;
        }
    }elseif($mod == 'hapus'){
        $i = $conn->query("DELETE FROM reminders WHERE id = '$id'");
        if($i){
            header('Location: ../../app/index?status=task2');
            exit;
        }else{
            header('Location: ../../app/index?status=notask2');
            exit;
        }
    }
}
?>

<?php
require __DIR__ . '/../../config/conn.php';
$id = $_GET['id'] ? $_GET['id'] : '';
if(!empty($id)){
    $del = $conn->query("DELETE FROM user WHERE id = '$id'");
    if($del){
        header('Location: ../../setting/setAdmin?status=delete');
        exit;
    }else{
        header('Location: ../../setting/setAdmin?status=nodelete');
    }
}

?>
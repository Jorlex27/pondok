<?php
require __DIR__ . '/../../config/conn.php';
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
    $app_name = mysqli_real_escape_string($conn, $_POST['app_name']);
    $kolom = mysqli_real_escape_string($conn, $_POST['kolom']);

    if($action == 'update') {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        
        $u = $conn->prepare("UPDATE master_data SET name = ?, jenis = ?, link = ?, app_name = ?, kolom = ? WHERE id = ?");
        $u->bind_param("sssssi", $name, $jenis, $link, $app_name, $kolom, $id);
        if($u->execute()){
            header('Location: ../../admin/setAdmin?Apdata=Admin&status=mupdate');
            exit;
        }else{
            header('Location: ../../admin/setAdmin?Apdata=Admin&status=mtakupdate');
            exit;
        }
    }elseif($action == 'add'){
        $i = $conn->prepare("INSERT INTO master_data (name, jenis, link, app_name, kolom) VALUES (?,?,?,?,?) ");
        $i->bind_param("sssss", $name, $jenis, $link, $app_name, $kolom);
        if($i->execute()){
            header('Location: ../../admin/setAdmin?Apdata=Admin&status=mmasuk');
            exit;
        }else{
            header('Location: ../../admin/setAdmin?Apdata=Admin&status=mtakmasuk');
            exit;
        }
    }

}

<?php
require __DIR__ . '/../../config/conn.php';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$kolom = isset($_GET['kolom']) ? $_GET['kolom'] : '';
$name = $conn->real_escape_string($name);
$kolom = $conn->real_escape_string($kolom);
session_start();
$id_u = $_SESSION['id'];
$cek = $conn->query("SELECT * FROM santri");
if($cek->num_rows >0){
    if($name == 'Sekretariat'){
        $all = $conn->query("DELETE FROM santri");
        if($all){
            $u = $conn->query("UPDATE master_data SET status = 'Reset', by_id = '$id_u' where name = '$name'");
            if($u){
                header("Location: ../../admin/import?status=reset");
                exit;
            }else{
                header("Location: ../../admin/import?status=noreset");
                exit;
            }
        }else{
            header("Location: ../../admin/import?status=noreset");
            exit;
        }
    }else{
        $del = $conn->query("DELETE FROM santri WHERE $kolom LIKE '%$name%'");
        if($del){
            $u = $conn->query("UPDATE master_data SET status = 'Reset', by_id = '$id_u' where name = '$name'");
            if($u){
                header("Location: ../../admin/import?status=reset");
                exit;
            }else{
                header("Location: ../../admin/import?status=noreset");
                exit;
                // echo $conn->error;
            }
        }else{
            // echo $conn->error;
            header("Location: ../../admin/import?status=noreset");
            exit;
        }
    }
}else{
    header("Location: ../../admin/import?status=nodata");
}
?>
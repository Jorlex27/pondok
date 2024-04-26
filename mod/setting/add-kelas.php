<?php
require __DIR__ . '/../../config/conn.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kelas = $_POST["kelas"];
    $c = $conn->query("SELECT * FROM kelas where id_md = '$id' AND name = '$kelas'");
    if($c->num_rows>0){
        http_response_code(404);
        echo json_encode(["error" => "la bedeh!"]);
        exit;
    }else{
        $del = $conn->query("INSERT INTO kelas (name, id_md) VALUE ('$kelas', '$id')");
        if($del){
            echo json_encode(["success" => "Data berhasil disimpan"]);
        }else{
            http_response_code(500);
            echo json_encode(["error" => "Gagal menyimpan data ke database"]);
        }
    }
}
?>
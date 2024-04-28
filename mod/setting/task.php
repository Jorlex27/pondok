<?php
require __DIR__ . '/../../config/conn.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $taskTitle = $_POST["task"];
  $taskDate = $_POST["tanggal"];
  session_start();
  $id_u = $_SESSION['id'];
  $i = $conn->query("INSERT INTO reminders (task, tanggal, id_u) VALUES ('$taskTitle', '$taskDate', '$id_u')");
  if($i){
    header('Location: ../../app/index?status=task');
    exit;
  }else{
    header('Location: ../../app/index?status=task');
    exit;
  }
}
?>

<?php
require __DIR__. '/../../config/conn.php';

$sql = "SELECT * FROM payments1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $jsonFile = '../../assets/backup/p1/payments1_backup_' . date('Y-m-d') . '.json';
    file_put_contents($jsonFile, json_encode($data));

} else {
    
}

$conn->close();
?>
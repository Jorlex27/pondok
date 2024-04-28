<?php
require __DIR__. '/../../config/conn.php';

$qu = '';
$quu = '';
$kelas = '';
if (isset($_GET['kelas'])) {
  $kelas = $_GET['kelas'];
  $kl = $conn->query("SELECT kolom FROM master_data where name = '$kelas'");
  $jj = $kl->fetch_assoc();
  $jenjang = $jj['kolom'];
  $qu = "AND $jenjang LIKE '%$kelas%'";
}

if (isset($_GET['gender'])) {
  $gender = $_GET['gender'];
  $quu = "AND gender LIKE '%$gender%'";
}

$query = "SELECT * FROM santri WHERE status = 'AKTIF' $qu $quu";
$result = $conn->query($query);
if ($result) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $json = json_encode($data);
} else {
    echo "No data";
}





?>

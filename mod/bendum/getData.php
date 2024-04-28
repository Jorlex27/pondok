<?php
require __DIR__ . '/../../config/conn.php';

$selectedValue = $_GET['selectedValue'];

$sql = "SELECT sum(p1.payment) as pay1, COALESCE(SUM(p2.payment), 0) as pay2
FROM nota as n
inner join payments1 as p1 on n.id_pay1 = p1.id_pay
LEFT join payments2 as p2 on n.id_pay2 = p2.id_pay
WHERE n.thn_ajaran = '$selectedValue'";

$result = $conn->query($sql);

if ($result) {
    $data = $result->fetch_assoc();

    $response = array(
        'pay1' => $data['pay1'],
        'pay2' => $data['pay2']
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo "Kesalahan dalam mengambil data dari database.";
}


$conn->close();

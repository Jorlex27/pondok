<?php
require __DIR__ . "/../../config/conn.php";


function checkRegistration($id, $conn)
{
    $sql = "SELECT COUNT(*) AS count FROM registrasi WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $foundId = mysqli_fetch_assoc($result);
        return $foundId['count'] > 0 ? true : false;
    } else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['input'];
    $found = checkRegistration($id, $conn);

    if ($found) {
        http_response_code(200);
        echo json_encode(array('message' => 'ok'));
    } else {
        http_response_code(400);
        echo json_encode(array('message' => 'no'));
    }
}

// Tutup koneksi database
mysqli_close($conn);
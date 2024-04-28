<?php
// $host = "localhost";
// $user = "root";
// $pass = "";
// $database = "pondok_lama";

// $conn = mysqli_connect($host, $user, $pass, $database);
// if (!$conn) {
//   die("Connection Failed:" . mysqli_connect_error());
// }

$host = "153.92.13.204";
$user = "u462981871_pondok";
$pass = "Norali12";
$database = "u462981871_pondokku";

$conn = mysqli_connect($host, $user, $pass, $database);
if (!$conn) {
    die("Connection Failed:" . mysqli_connect_error());
}


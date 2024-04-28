<?php

$host = "153.92.13.204";
$user = "u462981871_pondok";
$pass = "Norali12";
$database = "u462981871_pondokku";

$conn2 = mysqli_connect($host, $user, $pass, $database);
if (!$conn2) {
    die("Connection Failed:" . mysqli_connect_error());
}
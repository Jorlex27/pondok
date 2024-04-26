<?php

use chillerlan\QRCode\QRCode;

require '../config/conn.php';
require '../vendor/autoload.php';
$id = $_GET['id'];

$d = $conn->query("SELECT nama, ayah, dusun, desa, kecamatan, kabupaten FROM registrasi WHERE id = '$id'")->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA4Bj9Hg8haPz0qFz5G5PGJ8/0p2Or3tFgvjWbZ" crossorigin="anonymous">
    <style>
        .container {
            max-width: 800px;
            /* margin: 50px auto; */
        }

        .card {
            border-radius: 15px;
            /* box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); */
            /* border: solid 10px; */
        }

        .row {
            display: flex;
        }

        .qr-code {
            flex: 1;
            padding: 20px;
            text-align: center;
        }

        .qr-code img {
            max-width: 100%;
            height: auto;
            max-height: 300px;
            margin-bottom: 20px;
        }

        .registration-info {
            flex: 2;
            padding: 20px;
        }

        .registration-info p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="row">
                <div class="qr-code">
                    <?php echo '<img src="'.(new QRCode)->render($id).'" alt="QR Code" />'; ?>
                </div>
                <div class="registration-info">
                    <h3 class="text-center mb-4">Bukti Registrasi</h3>
                    <p><strong>Nama:</strong> <?php echo $d['nama'] ?></p>
                    <p><strong>Wali:</strong> <?php echo $d['ayah'] ?></p>
                    <p><strong>Alamat:</strong> <?php echo $d['dusun']. ' '. $d['desa']. ' '. $d['kecamatan']. ' '. $d['kabupaten'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- <script>
        window.onload = function() {
            window.print();
        };
    </script> -->
</body>

</html>

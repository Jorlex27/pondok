<?php

use chillerlan\QRCode\QRCode;

require 'config/conn.php';
require '../vendor/autoload.php';
$id = $_GET['id'];

$d = $conn->query("SELECT nama FROM registrasi WHERE id = '$id'")->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil!</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            max-width: 400px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-radius: 15px 15px 0 0;
            padding: 1px;
            text-align: center;
        }

        .card-title {
            font-size: 18px;
        }

        .card-body {
            text-align: center;
            padding: 20px;
        }

        #qr-code {
            max-width: 200px;
            margin: 20px auto;
        }

        .lead {
            font-size: 20px;
        }

        .display-6 {
            font-size: 28px;
        }

        .text-muted {
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Registrasi Berhasil!</h5>
                    </div>
                    <div class="card-body">
                        <?php echo '<img id="qr-code" src="' . (new QRCode)->render($id) . '" alt="QR Code" />'; ?>
                        <p class="lead">Nama : <?php echo $d['nama'] ?>, ID Pendaftaran:</p>
                        <p class="display-6"><?php echo $id ?></p>
                        <p class="text-muted">Harap simpan ID pendaftaran ini dengan aman.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (tidak diperlukan untuk contoh ini) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
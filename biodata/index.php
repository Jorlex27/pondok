<?php
require '../config/connect.php';
use chillerlan\QRCode\QRCode;
use GeniusTS\HijriDate\Hijri;
require '../vendor/autoload.php';
require '../helper/nb_i.php';

$db = new dataBase();

$id = $_GET['id'];
$sql = "SELECT ids, nama, dusun, desa, kecamatan, kabupaten, ayah, tempat_lahir, tanggal, bulan, tahun FROM santri WHERE ids = '$id'";

$result = $db->getRow($sql);
$now = \GeniusTS\HijriDate\Date::today();
$date = explode('-', $now);
$bulanInd = $result['bulan'] === 0 || $result['bulan'] === '0' ? $result['bulan']: $bulanIndonesia[$result['bulan']];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="b.css">
</head>

<body>
    <style>
        .atas .kanan .kts p {
            margin-top: 15px;
        }
    </style>
    <div class="container">
        <div class="atas">
            <div class="kiri"></div>
            <div class="kanan">
                <div class="kts">
                    <?php echo '<img src="' . (new QRCode)->render($id) . '" alt="QR Code" />'; ?>
                    <div class="data">
                        <span class="nama"><?php echo $result['nama'] ?></span><br>
                        <span
                            class="alamat"><?php echo ucwords(strtolower($result['dusun'])) . ' ' . ucwords(strtolower($result['desa'])) . ' ' . ucwords(strtolower($result['kecamatan'])) ?></span>
                    </div>
                    <p><?php echo $result['ayah'] ?><br>
                        <?php echo $result['tempat_lahir'] . ', ' . $result['tanggal'] . ' ' . $bulanInd . ' ' . $result['tahun'] ?>
                    </p>
                    <p class="tanggal"><?php echo substr($date[2], 0, 2) . ' ' . $bulan[$date[1]]. ' ' . $date[0] ?> H.</p>
                </div>
            </div>
        </div>
        <div class="bawah">
            <div class="item">
                <div class="bio">
                    <span><?php echo $result['nama'] ?><br><?php echo ucwords(strtolower($result['dusun'])) . ' ' . ucwords(strtolower($result['desa'])) . ' ' . ucwords(strtolower($result['kecamatan'])) ?><br><?php echo $result['ayah'] ?><br><?php echo $result['ids'] ?></span>
                </div>
                <p>Karangdurin, <?php echo substr($date[2], 0, 2) . ' ' . $bulan[$date[1]]. ' ' . $date[0] ?> H.</p>
            </div>
        </div>
    </div>
</body>

</html>
<?php
require '../../config/conn.php';
$id_not = $_GET['id_not'];

$d = $conn->prepare("SELECT s.ids, s.nama, s.ayah, s.kls_din, s.jenjang_din, p1.payment as pay_p1, p1.diskon, p1.sisa, p2.payment as pay_p2, sp.*, n.ket
FROM nota as n
INNER JOIN santri as s ON n.ids = s.ids
INNER JOIN payments1 as p1 ON p1.id_pay = n.id_pay1
LEFT JOIN payments2 as p2 ON p2.id_pay = n.id_pay2
INNER JOIN spp as sp ON sp.id_spp = n.id_spp
WHERE n.id_not = ?");
$d->bind_param("i", $id_not);
$ex = $d->execute();
if(!$ex){
    echo $conn->error;
}
$result = $d->get_result();
$n = $result->fetch_assoc();

if($n['ket'] === 1){
    $catatan = 'Lunas';
}else{
    $catatan = 'Belum Lunas';
}

if($n['jenjang'] === 'TK'){
    $jenjang = $n['jenjang'];
}else{
    $jenjang = $n['kls_din'] . ' ' . $n['jenjang_din'];
}

$no_nota = $id_not;
$date = date('d M Y');
require __DIR__. '/../../vendor/autoload.php';
date_default_timezone_set('Asia/Jakarta');
use GeniusTS\HijriDate\Translations\Arabic;
use GeniusTS\HijriDate\Date;
\GeniusTS\HijriDate\Date::setTranslation(new Arabic);
$tanggal = \GeniusTS\HijriDate\Hijri::convertToHijri($date);
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran</title>
    <link rel="stylesheet" href="../../assets/css/nota.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="../../assets/images/Picture1.png" alt="Logo Perusahaan" class="logo">
            <div class="pembayaran">
                <span>Nota Pembayaran</span>
            </div>
        </div>
        <div class="detail-nota">
            <div class="left">
                <div class="nota">
                    <span>No. Nota</span>
                    <span><?php echo $no_nota ?></span>
                </div>
                <div class="nota">
                    <span>NIS</span>
                    <span><?php echo $n['ids'] ?></span>
                </div>
                <div class="nota">
                    <span>Santri</span>
                    <span><?php echo $n['nama'] ?></span>
                </div>
            </div>
            <div class="right">
                <div class="nota">
                    <span>Pembayaran</span>
                    <span>Cash</span>
                </div>
                <div class="nota">
                    <span>Wali Santri</span>
                    <span><?php echo $n['ayah'] ?></span>
                </div>
                <div class="nota">
                    <span>Kelas</span>
                    <span><?php echo $jenjang ?></span>
                </div>
            </div>
        </div>
        <div class="detail-pembayaran">
            <div class="header-pembayaran">
                <div class="jenis">
                    <span>Jenis Pembayaran</span>
                </div>
                <div class="jenis">
                    <span>Nominal</span>
                </div>
            </div>
            <div class="data-pembayaran">
                <div class="data">
                    <span>Uang Pendaftaran</span>
                    <span>Uang Gedung</span>
                    <span>Infaq Gedung Al-Ittihad</span>
                    <span>Bapenta</span>
                    <span>Dana Sosial</span>
                    <span>Uang Hari Jadi</span>
                </div>
                <div class="data">
                    <span>Rp. <?php echo number_format($n['pangkal'], 0, ',', '.') ?></span>
                    <span>Rp. <?php echo number_format($n['gedung'], 0, ',', '.') ?></span>
                    <span>Rp. <?php echo number_format($n['pembangunan'], 0, ',', '.') ?></span>
                    <span>Rp. <?php echo number_format($n['ianah'], 0, ',', '.') ?></span>
                    <span>Rp. <?php echo number_format($n['dansos'], 0, ',', '.') ?></span>
                    <span>Rp. <?php echo number_format($n['hari_jadi'], 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="header-pembayaran">
                <div class="data">
                    <span>Total</span>
                    <?php
                    if ($n['diskon'] != '') {
                    ?>
                        <span>Diskon</span>
                    <?php
                    }
                    ?>
                    <span>Pembayaran Ke 1</span>
                    <?php
                    if ($n['pay_p2'] != '') {
                    ?>
                        <span>Pembayaran Ke 2</span>
                    <?php
                    }
                    ?>
                    <span>sisa</span>
                </div>
                <div class="data">
                    <span>Rp. <?php echo number_format($n['total'], 0, ',', '.') ?></span>
                    <?php
                    if ($n['diskon'] != '') {
                    ?>  
                        <span><?php echo $n['diskon']. " %" ?></span>
                    <?php
                    }
                    ?>
                    <span>Rp. <?php echo number_format($n['pay_p1'], 0, ',', '.') ?></span>
                    <?php
                    if ($n['pay_p2'] != '') {
                    ?>  
                        <span>Rp. <?php echo number_format($n['pay_p2'], 0, ',', '.') ?></span>
                    <?php
                    }
                    ?>
                    <span>Rp. <?php echo number_format($n['sisa'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
        <div class="end-nota">
            <div class="end">
                <div class="catatan">
                    <span>Catatan :</span>
                    <span><?php echo $catatan; ?></span>
                </div>
                <div class="tanggal">
                    <span>Karangdurin, <?php echo $tanggal->format('d F o', Date::INDIAN_NUMBERS); ?></span>
                    <div class="ttd">
                    <span>Bendahara</span>
                    <span><?php echo $_SESSION['name']; ?></span>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
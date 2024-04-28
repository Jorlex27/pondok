<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
}
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';
require '../config/conn.php';
require '../helper/nb_i.php';
require '../helper/alert.php';
$Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';
$ids = $_GET['id'];
$xd = $conn->query("SELECT * FROM santri WHERE ids = '$ids'")->fetch_assoc();

?>
<link rel="stylesheet" href="../assets/css/penerimaan-i.css">

<div class="container-3">
    <div class="form-container-3">
        <h2>Data <?php echo $xd['nama'] ?></h2>
        <form method="POST" class="form-flex" action="../mod/data/up_diniyah?Apdata=Ibtidaiyah"
            enctype="multipart/form-data" id="myForm">
            <div class="input-group left">
                <div class="image-upload">
                    <label for="file-input">
                        <img src="../assets/images/user2.png" alt="Profile Picture" class="profile-pic">
                    </label>
                    <input id="file-input" type="file" name="foto" accept="image/*" />
                </div>
                <div class="input-left">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" placeholder="Nama Lengkap"
                        value="<?php echo $xd['nama'] ?>" required>
                    <label for="id_d1">ID Induk</label>
                    <input type="text" name="id_d1" id="id_d1" value="<?php echo $xd['id_d1'] ?>">
                    <input type="hidden" name="ids" id="ids" value="<?php echo $xd['ids'] ?>">
                    <input type="hidden" name="foto_lama" id="foto_lama" value="<?php echo $xd['foto'] ?>">
                    <label for="id_d">No Induk</label>
                    <input type="text" name="id_d" id="id_d" value="<?php echo $xd['id_d'] ?>">
                    <label for="kls_din">Kelas</label>
                    <input type="text" value="<?php echo $xd['kls_din'] ?>" name="kls_din" id="kls_din">
                    <label for="jenjang_din">Jenjang</label>
                    <input type="text" value="<?php echo $xd['jenjang_din'] ?>" name="jenjang_din" id="jenjang_din">
                    <label for="thn_masuk_d">Tahun Masuk</label>
                    <input type="text" name="thn_masuk_d" id="thn_masuk_d" value="<?php echo $xd['thn_masuk_d'] ?>">
                    <label for="dusun">Dusun</label>
                    <input type="text" name="dusun" id="dusun" value="<?php echo $xd['dusun'] ?>">
                    <label for="desa">Desa</label>
                    <input type="text" name="desa" id="desa" value="<?php echo $xd['desa'] ?>">
                </div>
            </div>
            <div class="input-group right">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" value="<?php echo $xd['kecamatan'] ?>">
                <label for="kabupaten">Kabupaten</label>
                <input type="text" name="kabupaten" id="kabupaten" value="<?php echo $xd['kabupaten'] ?>">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" value="<?php echo $xd['tempat_lahir'] ?>">
                <label for="tanggal">Tanggal Lahir</label>
                <input type="text" value="<?php echo $xd['tanggal'] ?>" name="tanggal" id="tanggal">
                <label for="bulan">Bulan Lahir</label>
                <input type="text" value="<?php echo $xd['bulan'] ?>" name="bulan" id="bulan">
                <label for="tahun">Tahun Lahir</label>
                <input type="text" value="<?php echo $xd['tahun'] ?>" name="tahun" id="tahun">
                <label for="nik">NIK</label>
                <input type="text" name="nik" id="nik" value="<?php echo $xd['nik'] ?>">
                <label for="gender">Jenis Kelamin</label>
                <input type="text" name="gender" id="gender" value="<?php echo $xd['gender'] ?>">
                <label for="ayah">Wali</label>
                <input type="text" name="ayah" id="ayah" value="<?php echo $xd['ayah'] ?>">
                <label for="status">Status</label>
                <input type="text" name="status" id="status" value="Aktif" readonly>
                <button type="submit">Kirim</button>
            </div>
        </form>
    </div>
</div>

<script src="../assets/js/hed.js"></script>
<script src="../assets/js/script2.js"></script>

</body>

</html>
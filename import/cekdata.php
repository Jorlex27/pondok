<?php
session_start();
$judul = "Cek Data Sekretariat";
require '../config/conn.php';
require '../vendor/autoload.php';
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$missingData = array();

if (isset($_POST['submit'])) {
    if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK && $_FILES['excelFile']['size'] > 0) {
        $file = $_FILES['excelFile']['tmp_name'];
        $name = $_FILES['excelFile']['name'];
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $newName = 'DataCek' . '-' . date('Y.m.d') . '.' . $extension;
        $target = "../import/file/" . $newName;
        move_uploaded_file($file, $target);
        error_reporting(0);
        ini_set('display_errors', 0);

        $spreadsheet = IOFactory::load($target);
        $worksheet = $spreadsheet->getActiveSheet();

        $highestRow = $worksheet->getHighestRow(); ?>


<div class="container1">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th>No Induk</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jenjang</th>
                <th>Domisili</th>
                <th>No Kamar</th>
                <th>Tahun Masuk</th>
                <th>NO. KK</th>
                <th>NIK Santri</th>
                <th>Tempat Lahir</th>
                <th>TGL</th>
                <th>BLN</th>
                <th>THN</th>
                <th>Gender</th>
                <th>Agama</th>
                <th>Dusun</th>
                <th>Desa</th>
                <th>Kecamatan</th>
                <th>Kabupaten</th>
                <th>Provinsi</th>
                <th>Anak Ke</th>
                <th>Jmlh Saudara</th>
                <th>Gol. Darah</th>
                <th>Ayah</th>
                <th>NIK Ayah</th>
                <th>Tempat Lahir</th>
                <th>TGL</th>
                <th>BLN</th>
                <th>THN</th>
                <th>Pendidikan Terakhir</th>
                <th>Pekerjaan</th>
                <th>Ibu</th>
                <th>NIK Ayah</th>
                <th>Tempat Lahir</th>
                <th>TGL</th>
                <th>BLN</th>
                <th>THN</th>
                <th>Pendidikan Terakhir</th>
                <th>Pekerjaan</th>
                <th>No HP</th>
            </tr>
        </thead>
        <tbody>
    <?php
        $nomer = 1;
        for ($row = 2; $row <= $highestRow; $row++) {
            $id = $worksheet->getCell('B' . $row)->getValue();
            $nama = $worksheet->getCell('C' . $row)->getValue();
            $kelas = $worksheet->getCell('D' . $row)->getValue();
            $jenjang = $worksheet->getCell('E' . $row)->getValue();
            $dom = $worksheet->getCell('F' . $row)->getValue();
            $no_kamar = $worksheet->getCell('G' . $row)->getValue();
            $thn_masuk = $worksheet->getCell('H' . $row)->getValue();
            $kk = $worksheet->getCell('I' . $row)->getValue();
            $nik = $worksheet->getCell('J' . $row)->getValue();
            $tempat = $worksheet->getCell('K' . $row)->getValue();
            $tgl = $worksheet->getCell('L' . $row)->getValue();
            $bln = $worksheet->getCell('M' . $row)->getValue();
            $thn = $worksheet->getCell('N' . $row)->getValue();
            $gender = $worksheet->getCell('O' . $row)->getValue();
            $agama = $worksheet->getCell('P' . $row)->getValue();
            $dusun = $worksheet->getCell('Q' . $row)->getValue();
            $desa = $worksheet->getCell('R' . $row)->getValue();
            $kecamatan = $worksheet->getCell('S' . $row)->getValue();
            $kabupaten = $worksheet->getCell('T' . $row)->getValue();
            $provinsi = $worksheet->getCell('U' . $row)->getValue();
            $anak_ke = $worksheet->getCell('V' . $row)->getValue();
            $jml_saudara = $worksheet->getCell('W' . $row)->getValue();
            $gol_darah = $worksheet->getCell('X' . $row)->getValue();
            $ayah = $worksheet->getCell('Y' . $row)->getValue();
            $nik_a = $worksheet->getCell('Z' . $row)->getValue();
            $tl_a = $worksheet->getCell('AA' . $row)->getValue();
            $tgl_a = $worksheet->getCell('AB' . $row)->getValue();
            $bln_a = $worksheet->getCell('AC' . $row)->getValue();
            $thn_a = $worksheet->getCell('AD' . $row)->getValue();
            $pendidikan_a = $worksheet->getCell('AE' . $row)->getValue();
            $pekerjaan_a = $worksheet->getCell('AF' . $row)->getValue();
            $ibu = $worksheet->getCell('AG' . $row)->getValue();
            $nik_i = $worksheet->getCell('AH' . $row)->getValue();
            $tl_i = $worksheet->getCell('AI' . $row)->getValue();
            $tgl_i = $worksheet->getCell('AJ' . $row)->getValue();
            $bln_i = $worksheet->getCell('AK' . $row)->getValue();
            $thn_i = $worksheet->getCell('AL' . $row)->getValue();
            $pendidikan_i = $worksheet->getCell('AM' . $row)->getValue();
            $pekerjaan_i = $worksheet->getCell('AN' . $row)->getValue();
            $nohp = $worksheet->getCell('AO' . $row)->getValue();

            $cek = $conn->query("SELECT * FROM santri WHERE ids = '$id'");
            if ($cek->num_rows == 0) {?>
            <tr>
            <td><?php echo $nomer++; ?></td>
            <td><?php echo $id ?> </td>
            <td><?php echo $nama ?> </td>
            <td><?php echo $kelas ?> </td>
            <td><?php echo $jenjang  ?> </td>
            <td><?php echo $dom ?> </td>
            <td><?php echo $no_kamar ?> </td>
            <td><?php echo $thn_masuk ?> </td>
            <td><?php echo $kk ?> </td>
            <td><?php echo $nik ?> </td>
            <td><?php echo $tempat ?> </td>
            <td><?php echo $tgl ?> </td>
            <td><?php echo $bln ?> </td>
            <td><?php echo $thn ?> </td>
            <td><?php echo $gender ?> </td>
            <td><?php echo $agama ?> </td>
            <td><?php echo $dusun ?> </td>
            <td><?php echo $desa ?> </td>
            <td><?php echo $kecamatan ?> </td>
            <td><?php echo $kabupaten ?> </td>
            <td><?php echo $provinsi ?> </td>
            <td><?php echo $anak_ke ?> </td>
            <td><?php echo $jml_saudara ?> </td>
            <td><?php echo $gol_darah ?> </td>
            <td><?php echo $ayah ?> </td>
            <td><?php echo $nik_a ?> </td>
            <td><?php echo $tl_a ?> </td>
            <td><?php echo $tgl_a ?> </td>
            <td><?php echo $bln_a ?> </td>
            <td><?php echo $thn_a ?> </td>
            <td><?php echo $pendidikan_a ?> </td>
            <td><?php echo $pekerjaan_a ?> </td>
            <td><?php echo $ibu ?> </td>
            <td><?php echo $nik_i ?> </td>
            <td><?php echo $tl_i ?> </td>
            <td><?php echo $tgl_i ?> </td>
            <td><?php echo $bln_i ?> </td>
            <td><?php echo $thn_i ?> </td>
            <td><?php echo $pendidikan_i ?> </td>
            <td><?php echo $pekerjaan_i ?> </td>
            <td><?php echo $nohp ?> </td>

            </tr>

           <?php     
            }
        } ?>

            </tbody>
    </table>
</div>

        <?php
    }
}
?>


<?php
require '../tem/foot.php';
?>
<script src="../assets/js/table.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/script2.js"></script>
<!-- <script src="../assets/js/chekbox.js"></script> -->

</body>
</html>
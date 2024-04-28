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
$pesan = isset($_GET['status']) ? $_GET['status'] : '';
$Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';

$a = $conn->query("SELECT h.*, u.name
FROM history AS h
INNER JOIN user AS u ON h.id_u = u.id ORDER BY h.tanggal desc");
$namaBaru = array(
  'ids' => 'IDS',
  'id_d' => 'ID DIN',
  'id_d1' => 'IND DIN',
  'id_a' => 'IND AM',
  'id_m' => 'IND M',
  'nama' => 'Nama',
  'kls_din' => 'Kelas',
  'jenjang_din' => 'Jenjang',
  'kls_am' => 'Kelas',
  'jenjang_am' => 'Jenjang',
  'dom' => 'DOM',
  'no_kamar' => 'NO',
  'tahun_masuk' => 'THN Masuk',
  'no_kk' => 'KK',
  'nik' => 'NIK',
  'tempat_lahir' => 'Tempat Lahir',
  'tanggal' => 'Tanggal',
  'bulan' => 'Bulan',
  'tahun' => 'Tahun',
  'gender' => 'Gender',
  'agama' => 'Agama',
  'dusun' => 'Dusun',
  'desa' => 'Desa',
  'kecamatan' => 'Kecamatan',
  'kabupaten' => 'Kabupaten',
  'provinsi' => 'Provensi',
  'anak_ke' => 'Anak Ke',
  'jumlah_saudara' => 'J. Saudara',
  'gol_darah' => 'Gol. Darah',
  'ayah' => 'Ayah',
  'nik_a' => 'NIK',
  'tl_a' => 'Tl Ayah',
  'tgl_a' => 'Tgl Ayah',
  'bulan_a' => 'Bln Ayah',
  'tahun_a' => 'Thn Ayah',
  'pendidikan_a' => 'Pendidikan Ayah',
  'pekerjaan_a' => 'Pekerjaan Ayah',
  'ibu' => 'Ibu',
  'nik_i' => 'NIK',
  'tl_i' => 'Tl Ibu',
  'tgl_i' => 'Tgl Ibu',
  'bulan_i' => 'Bln Ibu',
  'tahun_i' => 'Thn Ibu',
  'pendidikan_i' => 'Pendidikan Ibu',
  'pekerjaan_i' => 'Pekerjaan Ayah',
  'no_hp' => 'No HP',
  'asal_sekolah' => 'Asal Sekolah',
  'npsn' => 'NPSN',
  'nsm' => 'NSM',
  'nisn' => 'NISN',
  'jurusan_sekolah_asal' => 'JSA',
  'status_nikah' => 'Status Nikah',
  'email' => 'Email',
  'foto' => 'Foto',
  'status' => 'Status',
);
?>
<style>
  .gambar img {
    max-width: 100px;
    height: auto;
    border-radius: 10%;
    object-fit: cover;
  }

  .gambar {
    margin: 0;
    padding: 0;
  }
</style>
<div class="container1">
  <div class="table-container">
    <table id="myTable" class="display">
      <thead>
        <tr>
          <th>No</th>
          <th>ID</th>
          <th>Nama</th>
          <th>Data</th>
          <th>Old Data</th>
          <th>New Data</th>
          <th>History</th>
          <th>Tanggal</th>
          <th>By User</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $nomer = 1;
        foreach ($a as $d) :
          $id_hs = $d['id_hs'];
          $data_s = $d['data_s'];
          $old = json_decode($d['old_data'], true);
          $new = json_decode($d['new_data'], true);
          $dataArray = json_decode($data_s, true);
        ?>
          <tr>
            <td><?php echo $nomer++; ?></td>
            <td><?php echo $d['id_hs']; ?></td>
            <td><?php echo $dataArray['nama'] ?></td>
            <td><?php echo $dataArray['dusun'] ?></td>
            <td>
              <?php
              $limit = 3;
              if ($old !== null) {
                $count = 0;
                foreach ($old as $key => $value) {
                  if (isset($namaBaru[$key])) {
                    $namaBaruKolom = $namaBaru[$key];
                    echo "$namaBaruKolom : $value<br>";
                    $count++;
                    if ($count >= $limit) {
                      break;
                    }
                  }
                }
              } else {
              }
              ?>
            </td>
            <td>
              <?php
              $limit = 3;
              if ($new !== null) {
                $count = 0;
                foreach ($new as $key => $value) {
                  if (isset($namaBaru[$key])) {
                    $namaBaruKolom = $namaBaru[$key];
                    echo "$namaBaruKolom : $value<br>";
                    $count++;
                    if ($count >= $limit) {
                      break;
                    }
                  }
                }
              } else {
              }
              ?>
            </td>
            <td><?php echo $d['perubahan'] ?></td>
            <td><?php echo $d['tanggal'] ?></td>
            <td><?php echo $d['name'] ?></td>
            <td>
              <?php if($d['perubahan'] != "Update Foto"){ ?>
              <button type="button" name="move" class="btn btn-warning btn-sm" onclick="showUndoAlert('undo','<?php echo $d['act']; ?>','<?php echo $d['n_id']; ?>','<?php echo $d['id_hs']; ?>','<?php echo $d['log_id'] ?>')"><i class="ic material-icons" style="font-size: 12px;">undo</i></button>
              <?php }else{ echo ""; }; ?>
              <button type="button" name="move" class="btn btn-danger btn-sm" onclick="showUndoAlert('remove','<?php echo $d['act']; ?>','<?php echo $d['n_id']; ?>','<?php echo $d['id_hs']; ?>','<?php echo $d['log_id'] ?>')"><i class="ic material-icons" style="font-size: 12px;">remove</i></button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>



<?php
require '../tem/foot.php';
?>

<script src="../assets/js/table.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/script2.js"></script>
<script src="../assets/js/gambar.js"></script>
<script src="../assets/js/alert.js"></script>
<script>
  function showUndoAlert(pesan, act, n_id, id_hs, log_id) {
    let msg = '';
    if(pesan == "undo"){
      msg = "Data yang telah dipilih akan dikembalikan ke sebelum ada perubahan";
    }else{
      msg = "Data yang dihapus tidak bisa dikembalikan lagi. Lanjutkan?";
    }
    Swal.fire({
      title: "Apakah Anda yakin?",
      text: msg,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya",
      cancelButtonText: "Batal",
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = "../mod/data/undoChang?act=" + act + "&n_id=" + n_id + "&id_hs=" + id_hs + "&log_id=" + log_id+"&pesan="+pesan;
      }
    });
  }
</script>

</body>

</html>
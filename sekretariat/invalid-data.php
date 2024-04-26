<?php
session_start();
if (!isset($_SESSION['login'])) {
  header('Location: ../index.php');
}
$judul = "Data Santri";
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';
require '../config/conn.php';
require '../helper/nb_i.php';
require '../helper/alert.php';
require '../data/proses-data/santri2.php';

$pesan = isset($_GET['status']) ? $_GET['status'] : '';
$item = isset($_GET['item']) ? $_GET['item'] : '';
$Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';

$k = $conn->query("SELECT k.id as id_k, k.name as kelas, m.name FROM master_data as m
left join kelas as k on k.id_md = m.id where m.name = 'Sekretariat' ORDER BY kelas ASC
")
?>
<style>
  .dropdown {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1;
    border-radius: 5px;
    padding: 2px;
    margin-top: 10px;
    left: 50%;
  }

  .dropdown span {
    margin: 7px;
  }

  /* #myTable tbody tr td img {
    width: 80px;
    height: 80px;
    border-radius: 10%;
    object-fit: cover;
  } */
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
  <div class="btn-kelas">
    <?php
    foreach ($k as $kls) {
    ?>
      <button type="button" class="btn btn-info btn-sm mb-2" onclick="updateKelas('<?php echo $kls['kelas'] ?>')"><?php echo $kls['kelas'] ?></button>
    <?php
    } ?>
    <button type="button" class="btn btn-info btn-sm mb-2" onclick="gender('Pria')">Banin</button>
    <button type="button" class="btn btn-info btn-sm mb-2" onclick="gender('Wanita')">Banat</button>
    <!-- <button type="button" id="btnReloadKelas" class="btn btn-info btn-sm mb-2" onclick="reloadKelas('<?php echo $kelas ?>')">Semua</button> -->
    <button type="button" class="btn btn-info btn-sm mb-2" id="toggleButton1">Column</button>
  </div>
  <div class="table-container">
    <table id="myTable" class="display">
      <thead>
        <tr>
          <th>No</th>
          <th>Foto</th>
          <th>Induk Sentral</th>
          <th class="kolom-hidden">Id Diniyah</th>
          <th class="kolom-hidden">Induk Diniyah</th>
          <th class="kolom-hidden">Induk Ammiyah</th>
          <th class="kolom-hidden">Induk Mahasiswa</th>
          <th>Nama</th>
          <th>Kelas Diniyah</th>
          <th>Kelas Ammiyah</th>
          <th>Domisili</th>
          <th>Tahun Masuk</th>
          <th class="kolom-hidden">NO. KK</th>
          <th class="kolom-hidden">NIK Santri</th>
          <th class="kolom-hidden">Tempat Lahir</th>
          <th class="kolom-hidden">Tanggal Lahir</th>
          <th class="kolom-hidden">Gender</th>
          <th class="kolom-hidden">Agama</th>
          <th class="kolom-hidden">Dusun</th>
          <th class="kolom-hidden">Desa</th>
          <th class="kolom-hidden">Kecamatan</th>
          <th class="kolom-hidden">Kabupaten</th>
          <th class="kolom-hidden">Provinsi</th>
          <th class="kolom-hidden">Kode Pos</th>
          <th class="kolom-hidden">Anak Ke</th>
          <th class="kolom-hidden">Jmlh Saudara</th>
          <th class="kolom-hidden">Gol. Darah</th>
          <th class="kolom-hidden">Ayah</th>
          <th class="kolom-hidden">NIK Ayah</th>
          <th class="kolom-hidden">Tempat Lahir</th>
          <th class="kolom-hidden">Tanggal Lahir</th>
          <th class="kolom-hidden">Pendidikan Terakhir</th>
          <th class="kolom-hidden">Pekerjaan</th>
          <th class="kolom-hidden">Ibu</th>
          <th class="kolom-hidden">NIK Ibu</th>
          <th class="kolom-hidden">Tempat Lahir</th>
          <th class="kolom-hidden">Tanggal Lahir</th>
          <th class="kolom-hidden">Pendidikan Terakhir</th>
          <th class="kolom-hidden">Pekerjaan</th>
          <th class="kolom-hidden">No HP</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $nomer = 1;
        if ($json !== null) {
          $decodedData = json_decode($json, true);
          if ($decodedData !== null) {
            foreach ($decodedData as $d) {
              $ids = $d['ids'];
              if ($ids === 0 || empty($ids)) {
                $dis = "disabled";
              } else {
                $dis = "";
              }
              $bulan = isset($bulanIndonesia[$d['bulan']]) ? $bulanIndonesia[$d['bulan']] : '0';
              $bulan_a = isset($bulanIndonesia[$d['bulan_a']]) ? $bulanIndonesia[$d['bulan_a']] : '0';
              $bulan_i = isset($bulanIndonesia[$d['bulan_i']]) ? $bulanIndonesia[$d['bulan_i']] : '0';
        ?>
              <tr>
                <td><?php echo $nomer++; ?></td>
                <td class="gambar"><img src="../assets/uploads/sans/<?php echo $d['foto'] ?>" alt=""></td>
                <td><?php echo $d['ids'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['id_d1'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['id_d'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['id_a'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['id_m'] ?> </td>
                <td><?php echo $d['nama'] ?> </td>
                <td><?php echo $d['kls_din'] . ' ' . $d['jenjang_din'] ?> </td>
                <td><?php echo $d['kls_am'] . ' ' . $d['jenjang_am']  ?> </td>
                <td><?php echo $d['dom'] . ' ' . $d['no_kamar'] ?> </td>
                <td><?php echo $d['tahun_masuk'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['no_kk'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['nik'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['tempat_lahir'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['tanggal'] . ' ' . $bulan . ' ' . $d['tahun'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['gender'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['agama'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['dusun'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['desa'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['kecamatan'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['kabupaten'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['provinsi'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['kode_pos'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['anak_ke'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['jumlah_saudara'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['gol_darah'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['ayah'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['nik_a'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['tl_a'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['tgl_a'] . ' ' . $bulan_a . ' ' . $d['tahun_a'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['pendidikan_a'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['pekerjaan_a'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['ibu'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['nik_i'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['tl_i'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['tgl_i'] . ' ' . $bulan_i . ' ' . $d['tahun_i'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['pendidikan_i'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['pekerjaan_i'] ?> </td>
                <td class="kolom-hidden"><?php echo $d['no_hp'] ?> </td>
                <td><?php echo $d['status'] ?> </td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $d['ids'] ?>" <?php echo $dis ?>><i class="material-icons" style="font-size: 12px;">edit</i></button>
                  <button type="button" class="btn btn-danger btn-sm" onclick="BackDrop('ids','<?php echo $d['ids'] ?>', '<?php echo $kelas; ?>', 'invalid-data','sekretariat/invalid-data',)"><i class="material-icons" style="font-size: 12px;">delete</i></button>
                </td>
              </tr>
        <?php }
          }
        } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<?php if ($json !== null) {
  $decodedData = json_decode($json, true);
  if ($decodedData !== null) {
    foreach ($decodedData as $d) { ?>
      <div class="modal fade" id="myModal<?php echo $d['ids']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header custom-modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Detail Data <?php echo $d['nama']; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- <form action="../mod/data/up_invalid?Apdata=Santri Invalid&kelas=<?php echo $kelas ?>" method="post" id="myForm"> -->
            <!-- <input type="hidden" name="foto_lama" value="<?php echo $d['foto'] ?>"> -->
            <div class="modal-body">
              <div class="container">
                <div class="row">
                  <div class="col-lg-4 upload-container">
                    <img src="../assets/uploads/sans2/<?php echo $d['foto'] ?>" class="img-fluid" id="fotoS_<?php echo $d['ids'] ?>">
                    <br>
                    <label for="infotoS_<?php echo $d['ids'] ?>" class="upload-button">Pilih Gambar</label>
                    <input type="file" name="foto" id="infotoS_<?php echo $d['ids'] ?>" accept="image/*" onchange="previewImage(event, <?php echo $d['ids'] ?>)" style="display: none;">
                  </div>
                  <div class="col-lg-8">
                    <div class="card">
                      <div class="card-body">
                        <table class="table table-striped scrollable">
                          <tbody>
                            <tr>
                              <th id="santri<?php echo $d['ids']; ?>">Induk Sentral</th>
                              <td><input type="text" value="<?php echo $d['ids']; ?>" name="ids" readonly> </td>
                            </tr>
                            <tr>
                              <th>Id Diniyah</th>
                              <td><input type="text" value="<?php echo $d['id_d1']; ?>" name="id_d1"> </td>
                            </tr>
                            <tr>
                              <th>Induk Diniyah</th>
                              <td><input type="text" value="<?php echo $d['id_d']; ?>" name="id_d"> </td>
                            </tr>
                            <tr>
                              <th>Induk Ammiyah</th>
                              <td><input type="text" value="<?php echo $d['id_a']; ?>" name="id_a"> </td>
                            </tr>
                            <tr>
                              <th>Induk Mahasiswa</th>
                              <td><input type="text" value="<?php echo $d['id_m']; ?>" name="id_m"> </td>
                            </tr>
                            <tr>
                              <th>Nama</th>
                              <td><input type="text" value="<?php echo $d['nama']; ?>" name="nama"> </td>
                            </tr>
                            <tr>
                              <th>Kelas Diniyah</th>
                              <td>
                                <div class="user-input">
                                  <input type="text" value="<?php echo $d['kls_din']; ?>" name="kls_din" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['jenjang_din']; ?>" name="jenjang_din">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th>Kelas Ammiyah</th>
                              <td>
                                <div class="user-input">
                                  <input type="text" value="<?php echo $d['kls_am']; ?>" name="kls_am" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['jenjang_am']; ?>" name="jenjang_am">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th>Domisili</th>
                              <td>
                                <div class="user-input">
                                  <input type="text" value="<?php echo $d['dom']; ?>" name="dom" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['no_kamar']; ?>" name="no_kamar">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th>Tahun Masuk</th>
                              <td><input type="text" value="<?php echo $d['tahun_masuk']; ?>" name="tahun_masuk"> </td>
                            </tr>
                            <tr>
                              <th>NO. KK</th>
                              <td><input type="text" value="<?php echo $d['no_kk']; ?>" name="no_kk"> </td>
                            </tr>
                            <tr>
                              <th>NIK Santri</th>
                              <td><input type="text" value="<?php echo $d['nik']; ?>" name="nik"> </td>
                            </tr>
                            <tr>
                              <th>Tempat Lahir</th>
                              <td><input type="text" value="<?php echo $d['tempat_lahir']; ?>" name="tempat_lahir"> </td>
                            </tr>
                            <tr>
                              <th>Tanggal Lahir</th>
                              <td>
                                <div class="user-input">
                                  <input type="text" value="<?php echo $d['tanggal']; ?>" name="tanggal" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['bulan']; ?>" name="bulan" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['tahun']; ?>" name="tahun">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th>Gender</th>
                              <td><input type="text" value="<?php echo $d['gender']; ?>" name="gender"> </td>
                            </tr>
                            <tr>
                              <th>Agama</th>
                              <td><input type="text" value="<?php echo $d['agama']; ?>" name="agama"> </td>
                            </tr>
                            <tr>
                              <th>Dusun</th>
                              <td><input type="text" value="<?php echo $d['dusun']; ?>" name="dusun"> </td>
                            </tr>
                            <tr>
                              <th>Desa</th>
                              <td><input type="text" value="<?php echo $d['desa']; ?>" name="desa"> </td>
                            </tr>
                            <tr>
                              <th>Kecamatan</th>
                              <td><input type="text" value="<?php echo $d['kecamatan']; ?>" name="kecamatan"> </td>
                            </tr>
                            <tr>
                              <th>Kabupaten</th>
                              <td><input type="text" value="<?php echo $d['kabupaten']; ?>" name="kabupaten"> </td>
                            </tr>
                            <tr>
                              <th>Provinsi</th>
                              <td><input type="text" value="<?php echo $d['provinsi']; ?>" name="provinsi"> </td>
                            </tr>
                            <tr>
                              <th>Kode Pos</th>
                              <td><input type="text" value="<?php echo $d['kode_pos']; ?>" name="kode_pos"> </td>
                            </tr>
                            <tr>
                              <th>Anak Ke</th>
                              <td><input type="text" value="<?php echo $d['anak_ke']; ?>" name="anak_ke"> </td>
                            </tr>
                            <tr>
                              <th>Jmlh Saudara</th>
                              <td><input type="text" value="<?php echo $d['jumlah_saudara']; ?>" name="jumlah_saudara"> </td>
                            </tr>
                            <tr>
                              <th>Gol. Darah</th>
                              <td><input type="text" value="<?php echo $d['gol_darah']; ?>" name="gol_darah"> </td>
                            </tr>
                            <tr>
                              <th id="ayah<?php echo $d['ids']; ?>">Ayah</th>
                              <td><input type="text" value="<?php echo $d['ayah']; ?>" name="ayah"> </td>
                            </tr>
                            <tr>
                              <th>NIK Ayah</th>
                              <td><input type="text" value="<?php echo $d['nik_a']; ?>" name="nik_a"> </td>
                            </tr>
                            <tr>
                              <th>Tempat Lahir</th>
                              <td><input type="text" value="<?php echo $d['tl_a']; ?>" name="tl_a"> </td>
                            </tr>
                            <tr>
                              <th>Tanggal Lahir</th>
                              <td>
                                <div class="user-input">
                                  <input type="text" value="<?php echo $d['tgl_a']; ?>" name="tgl_a" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['bulan_a']; ?>" name="bulan_a" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['tahun_a']; ?>" name="tahun_a">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th>Pendidikan Terakhir</th>
                              <td><input type="text" value="<?php echo $d['pendidikan_a']; ?>" name="pendidikan_a"> </td>
                            </tr>
                            <tr>
                              <th>Pekerjaan</th>
                              <td><input type="text" value="<?php echo $d['pekerjaan_a']; ?>" name="pekerjaan_a"> </td>
                            </tr>
                            <tr>
                              <th id="ibu<?php echo $d['ids']; ?>">Ibu</th>
                              <td><input type="text" value="<?php echo $d['ibu']; ?>" name="ibu"> </td>
                            </tr>
                            <tr>
                              <th>NIK Ibu</th>
                              <td><input type="text" value="<?php echo $d['nik_i']; ?>" name="nik_i"> </td>
                            </tr>
                            <tr>
                              <th>Tempat Lahir</th>
                              <td><input type="text" value="<?php echo $d['tl_i']; ?>" name="tl_i"> </td>
                            </tr>
                            <tr>
                              <th>Tanggal Lahir</th>
                              <td>
                                <div class="user-input">
                                  <input type="text" value="<?php echo $d['tgl_i']; ?>" name="tgl_i" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['bulan_i']; ?>" name="bulan_i" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['tahun_i']; ?>" name="tahun_i">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th>Pendidikan Terakhir</th>
                              <td><input type="text" value="<?php echo $d['pendidikan_i']; ?>" name="pendidikan_i"> </td>
                            </tr>
                            <tr>
                              <th>Pekerjaan</th>
                              <td><input type="text" value="<?php echo $d['pekerjaan_i']; ?>" name="pekerjaan_i"> </td>
                            </tr>
                            <tr>
                              <th>No HP</th>
                              <td><input type="text" value="<?php echo $d['no_hp']; ?>" name="no_hp"> </td>
                            </tr>
                            <tr>
                              <th>Status</th>
                              <td>
                                <select name="status">
                                  <option value="<?php echo $d['status']; ?>" selected><?php echo $d['status']; ?></option>
                                </select>
                              </td>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="scroll-bawah">
                      <a class="btn btn-btn-outline-primary btn-sm modal-data1" href="#santri<?php echo $d['ids']; ?>">Santri</a>
                      <a class="btn btn-btn-outline-primary btn-sm modal-data1" href="#ayah<?php echo $d['ids']; ?>">Ayah</a>
                      <a class="btn btn-btn-outline-primary btn-sm modal-data1" href="#ibu<?php echo $d['ids']; ?>">Ibu</a>
                      <button class="btn btn-btn-outline-primary btn-sm modal-data1" id="editButton<?php echo $d['ids']; ?>">Edit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer custom-modal-footer">
              <button type="submit" class="btn btn-primary" id="save-button<?php echo $d['ids']; ?>" disabled>Simpan</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
            <!-- </form> -->
          </div>
        </div>
      </div>
      <script>
        document.addEventListener("DOMContentLoaded", function() {
          function disableInputs() {
            var inputs = document.querySelectorAll('input[type="text"]');
            var selectStatus = document.querySelector('select[name="status"]');
            var saveButton = document.getElementById('save-button<?php echo $d['ids']; ?>');
            saveButton.disabled = true;
            for (var i = 0; i < inputs.length; i++) {
              inputs[i].disabled = true;
            }
            selectStatus.disabled = false;
          }

          var editButton = document.getElementById('editButton<?php echo $d['ids']; ?>');
          editButton.addEventListener('click', function() {
            enableInputs();
          });

          function enableInputs() {
            var inputs = document.querySelectorAll('input[type="text"]');
            var selectStatus = document.querySelector('select[name="status"]');
            var saveButton = document.getElementById('save-button<?php echo $d['ids']; ?>');
            saveButton.disabled = false;
            for (var i = 0; i < inputs.length; i++) {
              inputs[i].disabled = true;
            }
            selectStatus.disabled = false;
          }

          var saveButton = document.getElementById('save-button<?php echo $d['ids']; ?>');
          saveButton.addEventListener('click', function() {
            var myForm = document.getElementById('myForm');
            myForm.submit();
          });

          var modal = document.getElementById('myModal<?php echo $d['ids']; ?>');
          modal.addEventListener('show.bs.modal', function() {
            disableInputs();
          });
        });
      </script>

<?php }
  }
} ?>

<?php
require '../tem/foot.php';
?>

<script src="../assets/js/table.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/madrosiyah.js"></script>
<script src="../assets/js/script2.js"></script>
<script src="../assets/js/gambar.js"></script>
<script src="../assets/js/input.js"></script>
<script src="../assets/js/alert.js"></script>
<script>
  function BackDrop(n_id, id, kelas, Apdata, link) {
    Swal.fire({
      title: "Apakah Anda yakin?",
      text: "Data akan dihapus dari " + Apdata,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya",
      cancelButtonText: "Batal",
      input: 'select',
      inputOptions: {
        'AKTIF': 'AKTIF',
        'NON AKTIF': 'NON AKTIF',
        'BOYONG': 'BOYONG',
        'DROP OUT': 'DROP OUT'
      },
      inputPlaceholder: 'Pilih tindakan',
      inputValidator: (value) => {
        if (!value) {
          return 'Anda harus memilih tindakan';
        }
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const choice = Swal.getInput().value;
        if (choice) {
          window.location = "../mod/data/opt-dell.php?n_id=" + n_id + "&id=" + id + "&kelas=" + kelas + "&Apdata=" + Apdata + "&link=" + link + "&choice=" + choice;
        }
      }
    });
  }
</script>
</body>

</html>
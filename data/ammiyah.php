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
$item = isset($_GET['item']) ? $_GET['item'] : '';
$Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';
$qu = '';
$quu = '';
$kelas = '';
$gen = $_SESSION['gender'];

if (isset($_GET['kelas'])) {
  $kelas = $_GET['kelas'];
  $qu = "AND kls_am = '$kelas'";
}
if ($Apdata == "Mahasiswa") {
  $n_btn_kls = "";
  $n_th_kls = "Semseter";
  $n_th_jenajang = "Prodi";
} else {
  $n_btn_kls = "Kelas";
  $n_th_kls = "Kelas";
  $n_th_jenajang = "Jenjang";
}

if (isset($_GET['gender'])) {
  $gender = $_GET['gender'];
  $quu = "AND gender LIKE '%$gender%'";
}

if (!empty($gen)) {
  if ($gen != "All") {
    $a = $conn->query("SELECT * FROM santri WHERE jenjang_am LIKE '%$Apdata%' AND gender like '%$gen%' AND status = 'AKTIF' $qu $quu");
  } else {
    $a = $conn->query("SELECT * FROM santri WHERE jenjang_am LIKE '%$Apdata%' AND status = 'AKTIF' $qu $quu");
  }
} else {
  $a = "";
}

$k = $conn->query("SELECT k.id as id_k, k.name as kelas, m.name FROM master_data as m
left join kelas as k on k.id_md = m.id where m.name = '$Apdata' ORDER BY kelas ASC
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
    if ($a != "") {
      foreach ($k as $kls) {
    ?>
        <button type="button" class="btn btn-info btn-sm mb-2" onclick="updateKelas('<?php echo $kls['kelas'] ?>')"><?php echo $n_btn_kls . ' ' . $kls['kelas'] ?></button>
      <?php
      };
      if ($gen === "All") {
      ?>
        <button type="button" class="btn btn-info btn-sm mb-2" onclick="gender('Pria')">Banin</button>
        <button type="button" class="btn btn-info btn-sm mb-2" onclick="gender('Wanita')">Banat</button>
      <?php } ?>
      <button type="button" id="btnReloadKelas" class="btn btn-info btn-sm mb-2" onclick="reloadKelas('<?php echo $kelas ?>')">Semua</button>
      <button type="button" class="btn btn-info btn-sm mb-2" id="toggleButton1">Column</button>
  </div>
  <input type="hidden" id="kelas-valid" value="<?php echo $kelas ?>">
  <form id="formAction" action="../mod/data/option" method="post">
    <input type="hidden" name="items" id="items">
    <input type="hidden" name="kelas-input" id="kelas-input">
    <input type="hidden" name="jenjang-input" id="jenjang-input">
    <div class="table-container">
      <table id="myTable" class="display">
        <thead>
          <tr>
            <th>No</th>
            <th>Foto</th>
            <th>No Induk</th>
            <th>Nama</th>
            <th>Asal Sekolah</th>
            <th><?php echo $n_th_kls ?></th>
            <th><?php echo $n_th_jenajang ?></th>
            <th class="kolom-hidden">NPSN</th>
            <th class="kolom-hidden">NSM/NSS</th>
            <th class="kolom-hidden">NISN</th>
            <th class="kolom-hidden">NIK</th>
            <th class="kolom-hidden">Tempat Lahir</th>
            <th class="kolom-hidden">Tanggal Lahir</th>
            <th class="kolom-hidden">Gender</th>
            <th class="kolom-hidden">Anak Ke</th>
            <th class="kolom-hidden">J. Saudara</th>
            <th class="kolom-hidden">Dusun</th>
            <th class="kolom-hidden">Desa</th>
            <th class="kolom-hidden">Kecamatan</th>
            <th class="kolom-hidden">Kabupaten</th>
            <th class="kolom-hidden">Provinsi</th>
            <th class="kolom-hidden">Kode Pos</th>
            <th class="kolom-hidden">No KK</th>
            <th class="kolom-hidden">Ayah</th>
            <th class="kolom-hidden">Status Ayah</th>
            <th class="kolom-hidden">NIK Ayah</th>
            <th class="kolom-hidden">Tempat Lahir</th>
            <th class="kolom-hidden">Tanggal Lahir</th>
            <th class="kolom-hidden">Pendidikan Terakhir</th>
            <th class="kolom-hidden">Pekerjaan</th>
            <th class="kolom-hidden">Ibu</th>
            <th class="kolom-hidden">Status Ibu</th>
            <th class="kolom-hidden">NIK Ibu</th>
            <th class="kolom-hidden">Tempat Lahir</th>
            <th class="kolom-hidden">Tanggal Lahir</th>
            <th class="kolom-hidden">Pendidikan Terakhir</th>
            <th class="kolom-hidden">Pekerjaan</th>
            <th class="kolom-hidden">No HP</th>
            <th>Status</th>
            <th>Action</th>
            <th><input type="checkbox" id="selectAll" onclick="toggleCheckbox('<?php echo $kelas ?>')"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $nomer = 1;
          foreach ($a as $d) :
            $id_a = $d['id_a'];
            if ($id_a === 0 || empty($id_a)) {
              $dis = "disabled";
            } else {
              $dis = "";
            }
            $stmt = $conn->prepare("SELECT id_a FROM santri WHERE id_a = ?");
            $stmt->bind_param("i", $id_a);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 1) {
              $idClass = 'duplicate-id';
            } else {
              $idClass = '';
            }
            $stmt->close();
            $bulan = isset($bulanIndonesia[$d['bulan']]) ? $bulanIndonesia[$d['bulan']] : '0';
            $bulan_a = isset($bulanIndonesia[$d['bulan_a']]) ? $bulanIndonesia[$d['bulan_a']] : '0';
            $bulan_i = isset($bulanIndonesia[$d['bulan_i']]) ? $bulanIndonesia[$d['bulan_i']] : '0';
          ?>
            <tr>
              <td><?php echo $nomer++; ?></td>
              <td class="gambar"><img src="../assets/uploads/sans/<?php echo $d['foto'] ?>" alt=""></td>
              <td class="<?php echo $idClass ?>"><?php echo $d['id_a']; ?></td>
              <td><?php echo $d['nama'] ?></td>
              <td><?php echo $d['asal_sekolah'] ?></td>
              <td><?php echo $d['kls_am'] ?></td>
              <td><?php echo $d['jenjang_am'] ?></td>
              <td class="kolom-hidden"><?php echo $d['npsn'] ?></td>
              <td class="kolom-hidden"><?php echo $d['nsm'] ?></td>
              <td class="kolom-hidden"><?php echo $d['nisn'] ?></td>
              <td class="kolom-hidden"><?php echo $d['nik'] ?></td>
              <td class="kolom-hidden"><?php echo $d['tempat_lahir'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['tanggal'] . ' ' . $bulan . ' ' . $d['tahun'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['gender'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['anak_ke'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['jumlah_saudara'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['dusun'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['desa'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['kecamatan'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['kabupaten'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['provinsi'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['kode_pos'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['no_kk'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['ayah'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['status_a'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['nik_a'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['tl_a'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['tgl_a'] . ' ' . $bulan_a . ' ' . $d['tahun_a'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['pendidikan_a'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['pekerjaan_a'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['ibu'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['status_i'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['nik_i'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['tl_i'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['tgl_i'] . ' ' . $bulan_i . ' ' . $d['tahun_i'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['pendidikan_i'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['pekerjaan_i'] ?> </td>
              <td class="kolom-hidden"><?php echo $d['no_hp'] ?> </td>
              <td><?php echo $d['status'] ?> </td>
              <td>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $d['id_a'] ?>" <?php echo $dis ?>><i class="material-icons" style="font-size: 12px;">edit</i></button>
                <button type="button" class="btn btn-danger btn-sm" onclick="HapusData('id_a','<?php echo $d['id_a'] ?>', '<?php echo $kelas; ?>', '<?php echo $Apdata; ?>','data/ammiyah')"><i class="material-icons" style="font-size: 12px;">person_remove</i></button>
              </td>
              <td>
                <input type="hidden" name="kls_am[<?php echo $d['id_a'] ?>]" value="<?php echo $d['kls_am'] ?>">
                <input type="checkbox" id="itemCheckbox<?php echo $d['id_a'] ?>" class="itemCheckbox" data-kls-din="<?php echo $d['kls_am'] ?>" name="selectedItems[]" value="<?php echo $d['id_a'] ?>" <?php echo $dis ?> onclick="toggleCheckbox('<?php echo $kelas ?>', '<?php echo $d['id_a'] ?>')">
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <div id="dropdown" class="dropdown">
          <button type="button" name="move" class="btn btn-primary btn-sm ax" onclick="kelas_br('move', 'id_a', 'kls_am','<?php echo $kelas; ?>', '<?php echo $Apdata; ?>','ammiyah')"><i class="ic material-icons">north_east</i></button>
          <!-- <button type="button" name="delete" class="btn btn-danger btn-sm ax" onclick="showDeleteAlert('delete', '<?php echo $kelas; ?>', '<?php echo $Apdata; ?>')"><i class="ic material-icons">delete_outline</i></button> -->
          <span id="itemCount">Item : </span>
        </div>
      </table>
    </div>
  </form>
</div>

<!-- Modal -->
<?php foreach ($a as $d) : ?>
  <div class="modal fade" id="myModal<?php echo $d['id_a']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header custom-modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Data <?php echo $d['nama']; ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="../mod/data/up_ammiyah?Apdata=<?php echo $Apdata ?>&kelas=<?php echo $kelas ?>" method="post" enctype="multipart/form-data" id="myForm">
          <input type="hidden" name="foto_lama" value="<?php echo $d['foto'] ?>">
          <input type="hidden" name="ids" value="<?php echo $d['ids'] ?>">
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-lg-4 upload-container">
                  <img src="../assets/uploads/sans/<?php echo $d['foto'] ?>" class="img-fluid" id="fotoS_<?php echo $d['id_d1'] ?>">
                  <br>
                  <label for="infotoS_<?php echo $d['id_d1'] ?>" class="upload-button">Pilih Gambar</label>
                  <input type="file" name="foto" id="infotoS_<?php echo $d['id_d1'] ?>" accept="image/*" onchange="previewImage(event, <?php echo $d['id_d1'] ?>)" style="display: none;">
                </div>
                <div class="col-lg-8">
                  <div class="card">
                    <div class="card-body">
                      <table class="table table-striped scrollable">
                        <tbody>
                          <tr>
                            <th id="santri<?php echo $d['id_a']; ?>">No Induk</th>
                            <td><input type="text" name="id_a" value="<?php echo $d['id_a']; ?>"></td>
                          </tr>
                          <tr>
                            <th>Nama</th>
                            <td><input type="text" name="nama" value="<?php echo $d['nama']; ?>"></td>
                          </tr>
                          <tr>
                            <th>Kelas</th>
                            <td>
                              <div class="user-input">
                                <input type="text" value="<?php echo $d['kls_am']; ?>" name="kls_am" id="dynamic-input">
                                <input type="text" value="<?php echo $d['jenjang_am']; ?>" name="jenjang_am">
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>Asal Sekolah</th>
                            <td>
                              <input type="text" name="asal_sekolah" value="<?php echo $d['asal_sekolah']; ?>">
                            </td>
                          </tr>
                          <tr>
                            <th>NPSN</th>
                            <td>
                              <input type="text" name="npsn" value="<?php echo $d['npsn']; ?>">
                            </td>
                          </tr>
                          <tr>
                            <th>NSM/NSS</th>
                            <td>
                              <input type="text" name="nsm" value="<?php echo $d['nsm']; ?>">
                            </td>
                          </tr>
                          <tr>
                            <th>NISN</th>
                            <td>
                              <input type="text" name="nisn" value="<?php echo $d['nisn']; ?>">
                            </td>
                          </tr>
                          <tr>
                            <th>NIK</th>
                            <td><input type="text" name="nik" value="<?php echo $d['nik'] ?>"></td>
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
                            <th>Anak Ke</th>
                            <td><input type="text" value="<?php echo $d['anak_ke']; ?>" name="anak_ke"> </td>
                          </tr>
                          <tr>
                            <th>J. Saudara</th>
                            <td><input type="text" value="<?php echo $d['jumlah_saudara']; ?>" name="jumlah_saudara"> </td>
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
                            <th>Tahun Masuk</th>
                            <td><input type="text" name="thn_masuk_a" value="<?php echo $d['thn_masuk_a']; ?>"></td>
                          </tr>
                          <tr>
                            <th>No KK</th>
                            <td><input type="text" value="<?php echo $d['no_kk']; ?>" name="no_kk"> </td>
                          </tr>
                          <tr>
                            <th id="ayah<?php echo $d['id_a']; ?>">Ayah</th>
                            <td><input type="text" value="<?php echo $d['ayah']; ?>" name="ayah"> </td>
                          </tr>
                          <tr>
                            <th>Status Ayah</th>
                            <td><input type="text" value="<?php echo $d['status_a']; ?>" name="status_a"> </td>
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
                            <th id="ibu<?php echo $d['id_a']; ?>">Ibu</th>
                            <td><input type="text" value="<?php echo $d['ibu']; ?>" name="ibu"> </td>
                          </tr>
                          <tr>
                            <th>Status Ibu</th>
                            <td><input type="text" value="<?php echo $d['status_i']; ?>" name="status_i"> </td>
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
                                <option value="Aktif">Aktif</option>
                                <option value="Non Aktif">Non Aktif</option>
                                <option value="Boyong">Boyong</option>
                                <option value="Drop Out">Drop Out</option>
                              </select>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="scroll-bawah">
                    <a class="btn btn-btn-outline-primary btn-sm modal-data1" href="#santri<?php echo $d['id_a']; ?>">Siswa</a>
                    <a class="btn btn-btn-outline-primary btn-sm modal-data1" href="#ayah<?php echo $d['id_a']; ?>">Ayah</a>
                    <a class="btn btn-btn-outline-primary btn-sm modal-data1" href="#ibu<?php echo $d['id_a']; ?>">Ibu</a>
                    <button class="btn btn-btn-outline-primary btn-sm modal-data1" id="editButton<?php echo $d['id_a']; ?>">Edit</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer custom-modal-footer">
            <button type="submit" class="btn btn-primary" id="save-button<?php echo $d['id_a']; ?>" disabled onclick="openModal('<?php echo $kelas ?>','<?php echo $d['id_a'] ?>')">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      function disableInputs() {
        var inputs = document.querySelectorAll('input[type="text"]');
        var saveButton = document.getElementById('save-button<?php echo $d['id_a']; ?>');
        saveButton.disabled = true;
        for (var i = 0; i < inputs.length; i++) {
          inputs[i].disabled = true;
        }
      }

      function enableInputs() {
        var inputs = document.querySelectorAll('input[type="text"]');
        var saveButton = document.getElementById('save-button<?php echo $d['id_a']; ?>');
        saveButton.disabled = false;
        for (var i = 0; i < inputs.length; i++) {
          inputs[i].disabled = false;
        }
      }
      var editButton = document.getElementById('editButton<?php echo $d['id_a']; ?>');
      editButton.addEventListener('click', function() {
        enableInputs();
      });

      var saveButton = document.getElementById('save-button<?php echo $d['id_a']; ?>');
      saveButton.addEventListener('click', function() {
        var myForm = document.getElementById('myForm');
        myForm.submit();
      });
      var modal = document.getElementById('myModal<?php echo $d['id_a']; ?>');
      modal.addEventListener('show.bs.modal', function() {
        disableInputs();
      });
    });
  </script>
<?php endforeach ?>


<?php
      require '../tem/foot.php';
    };
?>

<script src="../assets/js/table.js"></script>
<script src="../assets/js/chekbox.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/madrosiyah.js"></script>
<script src="../assets/js/script2.js"></script>
<script src="../assets/js/gambar.js"></script>
<script src="../assets/js/input.js"></script>
<script src="../assets/js/alert.js"></script>
<script>

</script>


</body>

</html>
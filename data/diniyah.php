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
  $qu = "AND kls_din LIKE '%$kelas%'";
}
if ($Apdata == "Sifir") {
  $n_btn_kls = "";
} elseif ($Apdata == "PK") {
  $n_btn_kls = "";
} else {
  $n_btn_kls = "Kelas";
}

if (isset($_GET['gender'])) {
  $gender = $_GET['gender'];
  $quu = "AND gender LIKE '%$gender%'";
}

if (!empty($gen)) {
  if ($gen != "All") {
    $a = $conn->query("SELECT * FROM santri WHERE jenjang_din LIKE '%$Apdata%' AND gender like '%$gen%' AND status = 'AKTIF' $qu $quu");
  } else {
    $a = $conn->query("SELECT * FROM santri WHERE jenjang_din LIKE '%$Apdata%' AND status = 'AKTIF' $qu $quu");
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

  .bx-plus {
    font-size: 12px;
  }
</style>
<div class="container1">
  <div class="btn-kelas">
    <?php
    if ($a != "") {
      foreach ($k as $kls) {
        ?>
        <button type="button" class="btn btn-info btn-sm mb-2"
          onclick="updateKelas('<?php echo $kls['kelas'] ?>')"><?php echo $n_btn_kls . ' ' . $kls['kelas'] ?></button>
        <?php
      }
      ;
      if ($gen === "All") {
        ?>
        <button type="button" class="btn btn-info btn-sm mb-2" onclick="gender('Pria')">Banin</button>
        <button type="button" class="btn btn-info btn-sm mb-2" onclick="gender('Wanita')">Banat</button>
      <?php } ?>
      <button type="button" id="btnReloadKelas" class="btn btn-info btn-sm mb-2"
        onclick="reloadKelas('<?php echo $kelas ?>')">Semua</button>
      <button type="button" class="btn btn-info btn-sm mb-2" id="toggleButton1">Column</button>
      <button class="btn btn-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#add_class"><i
          class="bx bx-plus"></i> Tambah Siswa</button>
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
              <th>ID Induk</th>
              <th>No Induk</th>
              <th>Nama</th>
              <th>Dusun</th>
              <th class="kolom-hidden">Desa</th>
              <th class="kolom-hidden">Kecamatan</th>
              <th class="kolom-hidden">Kabupaten</th>
              <th>Wali</th>
              <th>Kelas</th>
              <th>Domisili</th>
              <th>Status</th>
              <th>Action</th>
              <th><input type="checkbox" id="selectAll" onclick="toggleCheckbox('<?php echo $kelas ?>')"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $nomer = 1;
            foreach ($a as $d):
              $id_d1 = $d['id_d1'];
              if ($id_d1 === 0 || empty($id_d1)) {
                $dis = "disabled";
              } else {
                $dis = '';
              }
              $stmt = $conn->prepare("SELECT id_d1 FROM santri WHERE id_d1 = ?");
              $stmt->bind_param("i", $id_d);
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result->num_rows > 1) {
                $idClass = 'duplicate-id';
              } else {
                $idClass = '';
              }
              $stmt->close();
              ?>
              <tr>
                <td><?php echo $nomer++; ?></td>
                <td class="gambar"><img src="../assets/uploads/sans/<?php echo $d['foto'] ?>" alt=""></td>
                <td class="<?php echo $idClass ?>"><?php echo $d['id_d1']; ?></td>
                <td><?php echo $d['id_d']; ?></td>
                <td><?php echo $d['nama'] ?></td>
                <td><?php echo $d['dusun'] ?></td>
                <td class="kolom-hidden"><?php echo $d['desa'] ?></td>
                <td class="kolom-hidden"><?php echo $d['kecamatan'] ?></td>
                <td class="kolom-hidden"><?php echo $d['kabupaten'] ?></td>
                <td><?php echo $d['ayah'] ?></td>
                <td><?php echo $d['kls_din'] . ' ' . $d['jenjang_din'] ?></td>
                <td><?php echo $d['dom'] . ' ' . $d['no_kamar'] ?></td>
                <td><?php echo $d['status'] ?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#myModal<?php echo $d['id_d1'] ?>" <?php echo $dis ?>><i class="material-icons"
                      style="font-size: 12px;">edit</i></button>
                  <button type="button" class="btn btn-danger btn-sm"
                    onclick="HapusData('id_d1','<?php echo $d['id_d1'] ?>', '<?php echo $kelas; ?>', '<?php echo $Apdata; ?>','data/diniyah')"><i
                      class="material-icons" style="font-size: 12px;">person_remove</i></button>
                </td>
                <td>
                  <input type="hidden" name="kls_din[<?php echo $d['id_d1'] ?>]" value="<?php echo $d['kls_din'] ?>">
                  <input type="checkbox" id="itemCheckbox<?php echo $d['id_d1'] ?>" class="itemCheckbox"
                    data-kls-din="<?php echo $d['kls_din'] ?>" name="selectedItems[]" value="<?php echo $d['id_d1'] ?>"
                    <?php echo $dis ?> onclick="toggleCheckbox('<?php echo $kelas ?>', '<?php echo $d['id_d1'] ?>')">
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <div id="dropdown" class="dropdown">
            <button type="button" name="move" class="btn btn-primary btn-sm ax"
              onclick="kelas_br('move', 'id_d1', 'kls_din','<?php echo $kelas; ?>', '<?php echo $Apdata; ?>','diniyah')"><i
                class="ic material-icons">north_east</i></button>
            <!-- <button type="button" name="delete" class="btn btn-danger btn-sm ax" onclick="showDeleteAlert('drop', 'id_d1', 'kls_din', '<?php echo $kelas; ?>', '<?php echo $Apdata; ?>' ,'diniyah')"><i class="ic material-icons">person_remove</i></button> -->
            <span id="itemCount">Item : </span>
          </div>
        </table>
      </div>
    </form>
  </div>

  <!-- Modal -->
  <?php foreach ($a as $d): ?>
    <div class="modal fade" id="myModal<?php echo $d['id_d1']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header custom-modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Data <?php echo $d['nama']; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="../mod/data/up_diniyah?Apdata=<?php echo $Apdata ?>&kelas=<?php echo $kelas ?>" method="post"
            enctype="multipart/form-data" id="myForm">
            <input type="hidden" name="foto_lama" value="<?php echo $d['foto'] ?>">
            <input type="hidden" name="ids" value="<?php echo $d['ids'] ?>">
            <div class="modal-body">
              <div class="container">
                <div class="row">
                  <div class="col-lg-4 upload-container">
                    <img src="../assets/uploads/sans/<?php echo $d['foto'] ?>" class="img-fluid"
                      id="fotoS_<?php echo $d['id_d1'] ?>">
                    <br>
                    <label for="infotoS_<?php echo $d['id_d1'] ?>" class="upload-button">Pilih Gambar</label>
                    <input type="file" name="foto" id="infotoS_<?php echo $d['id_d1'] ?>" accept="image/*"
                      onchange="previewImage(event, <?php echo $d['id_d1'] ?>)" style="display: none;">
                  </div>
                  <div class="col-lg-8">
                    <div class="card">
                      <div class="card-body">
                        <table class="table table-striped scrollable">
                          <tbody>
                            <tr>
                              <th>Id Induk</th>
                              <td><input type="text" name="id_d1" value="<?php echo $d['id_d1']; ?>"></td>
                            </tr>
                            <tr>
                              <th>No Induk</th>
                              <td><input type="text" name="id_d" value="<?php echo $d['id_d']; ?>"></td>
                            </tr>
                            <tr>
                              <th>Nama</th>
                              <td><input type="text" name="nama" value="<?php echo $d['nama']; ?>"></td>
                            </tr>
                            <tr>
                              <th>Kelas</th>
                              <td>
                                <div class="user-input">
                                  <input type="text" value="<?php echo $d['kls_din']; ?>" name="kls_din" id="dynamic-input">
                                  <input type="text" value="<?php echo $d['jenjang_din']; ?>" name="jenjang_din">
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th>Tahun Masuk</th>
                              <td><input type="text" name="thn_masuk_d" value="<?php echo $d['thn_masuk_d']; ?>"></td>
                            </tr>
                            <tr>
                              <th>Dusun</th>
                              <td><input type="text" name="dusun" value="<?php echo $d['dusun']; ?>"></td>
                            </tr>
                            <tr>
                              <th>Desa</th>
                              <td><input type="text" name="desa" value="<?php echo $d['desa']; ?>"></td>
                            </tr>
                            <tr>
                              <th>Kecamatan</th>
                              <td><input type="text" name="kecamatan" value="<?php echo $d['kecamatan']; ?>"></td>
                            </tr>
                            <tr>
                              <th>Kabupaten</th>
                              <td><input type="text" name="kabupaten" value="<?php echo $d['kabupaten']; ?>"></td>
                            </tr>
                            <tr>
                              <th>Tempat Lahir</th>
                              <td><input type="text" name="tempat_lahir" value="<?php echo $d['tempat_lahir']; ?>"></td>
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
                              <th>NIK</th>
                              <td><input type="text" name="nik" value="<?php echo $d['nik'] ?>"></td>
                            </tr>
                            <tr>
                              <th>Gender</th>
                              <td><input type="text" name="gender" value="<?php echo $d['gender'] ?>"></td>
                            </tr>
                            <tr>
                              <th>Wali</th>
                              <td><input type="text" name="ayah" value="<?php echo $d['ayah'] ?>"></td>
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
                      <button class="btn btn-btn-outline-primary btn-sm modal-data1"
                        id="editButton<?php echo $d['id_d1']; ?>">Edit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer custom-modal-footer">
              <button type="submit" class="btn btn-primary" id="save-button<?php echo $d['id_d1']; ?>" disabled
                onclick="openModal('<?php echo $kelas ?>','<?php echo $d['id_d1'] ?>')">Simpan</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        function disableInputs() {
          var inputs = document.querySelectorAll('input[type="text"]');
          var saveButton = document.getElementById('save-button<?php echo $d['id_d1']; ?>');
          saveButton.disabled = true;
          for (var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = true;
          }
        }

        function enableInputs() {
          var inputs = document.querySelectorAll('input[type="text"]');
          var saveButton = document.getElementById('save-button<?php echo $d['id_d1']; ?>');
          saveButton.disabled = false;
          for (var i = 0; i < inputs.length; i++) {
            inputs[i].disabled = false;
          }
        }
        var editButton = document.getElementById('editButton<?php echo $d['id_d1']; ?>');
        editButton.addEventListener('click', function () {
          enableInputs();
        });

        var saveButton = document.getElementById('save-button<?php echo $d['id_d1']; ?>');
        saveButton.addEventListener('click', function () {
          var myForm = document.getElementById('myForm');
          myForm.submit();
        });
        var modal = document.getElementById('myModal<?php echo $d['id_d1']; ?>');
        modal.addEventListener('show.bs.modal', function () {
          disableInputs();
        });
      });
    </script>
  <?php endforeach; ?>

  <div class="modal fade" id="add_class" tabindex="-1" role="dialog" aria-labelledby="add_classLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Add Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="id_c" class="form-label">Id Calon Siswa</label>
            <input type="text" class="form-control" id="id_c" name="id_c">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnLanjut">Lanjut</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <?php
  require '../tem/foot.php';
    }
    ;
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
  $(document).ready(function () {
    $("#ids").keypress(function (e) {
      if (e.which == 13) {
        e.preventDefault();
        $("#btnLanjut").click();
      }
    });

    $("#btnLanjut").click(function () {
      let id_c = $("#id_c").val();
      let Apdata = <?php echo json_encode($Apdata); ?>;
      $.ajax({
        type: "POST",
        url: "../mod/pendaftaran/cc-penerimaan-i",
        data: {
          id_c: id_c,
          Apdata: Apdata
        },
        success: function (id) {
          window.location = '../pendaftaran/penerimaan-i?id=' + id + '&Apdata=Penerimaan';
        },
        error: function () {
          alert("Terjadi kesalahan.");
        }
      });
    });
  });

</script>


</body>

</html>
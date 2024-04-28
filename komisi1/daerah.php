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
$qu = '';
$quu = '';
$kelas = '';
$gen = $_SESSION['gender'];
if (isset($_GET['kelas'])) {
    $kelas = $_GET['kelas'];
    $qu = "AND dom LIKE '%$kelas%'";
}

if (isset($_GET['gender'])) {
    $gender = $_GET['gender'];
    $quu = "AND gender LIKE '%$gender%'";
}
$daerah1 = substr($Apdata, -1);
$daerah = $Apdata;
if (!empty($gen)) {
    if ($gen != "All") {
        $a = $conn->query("SELECT * FROM santri WHERE dom LIKE '%B%' AND gender like '%$gen%' AND status = 'Aktif' $qu $quu");
    } else {
        $a = $conn->query("SELECT * FROM santri WHERE dom LIKE '%$daerah%' AND status = 'Aktif' $qu $quu");
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
                <button type="button" class="btn btn-info btn-sm mb-2" onclick="updateKelas('<?php echo $kls['kelas'] ?>')"><?php echo $kls['kelas'] ?></button>
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
    <form id="formAction" action="../mod/data/option.php" method="post">
        <input type="hidden" name="items" id="items">
        <input type="hidden" name="kelas-input" id="kelas-input">
        <input type="hidden" name="jenjang-input" id="jenjang-input">
        <div class="table-container">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>ID Santri</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Wali</th>
                        <th>Kelas</th>
                        <th>Domisili</th>
                        <th>Action</th>
                        <th><input type="checkbox" id="selectAll" onclick="toggleCheckbox('<?php echo $kelas ?>')"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomer = 1;
                    foreach ($a as $d) :
                    ?>
                        <tr>
                            <td><?php echo $nomer++; ?></td>
                            <td class="gambar"><img src="../assets/uploads/sans/<?php echo $d['foto'] ?>" alt=""></td>
                            <td><?php echo $d['ids']; ?></td>
                            <td><?php echo $d['nama'] ?></td>
                            <td><?php echo $d['dusun'] . ' ' . $d['desa'] . ' ' . $d['kecamatan'] ?></td>
                            <td><?php echo $d['ayah'] ?></td>
                            <td><?php echo $d['kls_din'] . ' ' . $d['jenjang_din'] ?></td>
                            <td><?php echo $d['dom'] . ' ' . $d['no_kamar'] ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $d['ids'] ?>"><i class="material-icons" style="font-size: 12px;">edit</i></button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="HapusData('ids','<?php echo $d['ids'] ?>', '<?php echo $kelas; ?>', '<?php echo $Apdata; ?>','komisi1/daerah')"><i class="material-icons" style="font-size: 12px;">person_remove</i></button>
                            </td>
                            <td>
                                <input type="hidden" name="dom[<?php echo $d['ids'] ?>]" value="<?php echo $d['dom'] ?>">
                                <input type="checkbox" id="itemCheckbox<?php echo $d['ids'] ?>" class="itemCheckbox" data-kls-din="<?php echo $d['dom'] ?>" name="selectedItems[]" value="<?php echo $d['ids'] ?>" onclick="toggleCheckbox('<?php echo $kelas ?>', '<?php echo $d['ids'] ?>')">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <div id="dropdown" class="dropdown">
                    <button type="button" name="move" class="btn btn-primary btn-sm ax" onclick="kelas_br('move', 'ids', 'dom','<?php echo $kelas; ?>', '<?php echo $Apdata; ?>','daerah')"><i class="ic material-icons">north_east</i></button>
                    <!-- <button type="button" name="delete" class="btn btn-danger btn-sm ax" onclick="showDeleteAlert('drop', 'ids', 'dom', '<?php echo $kelas; ?>', '<?php echo $Apdata; ?>' ,'daerah')"><i class="ic material-icons">person_remove</i></button> -->
                    <span id="itemCount">Item : </span>
                </div>
            </table>
        </div>
    </form>
</div>

<!-- Modal -->
<?php foreach ($a as $d) : ?>
    <div class="modal fade" id="myModal<?php echo $d['ids']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data <?php echo $d['nama']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../mod/data/up_diniyah.php?Apdata=<?php echo $Apdata ?>&kelas=<?php echo $kelas ?>" method="post" enctype="multipart/form-data" id="myForm">
                    <input type="hidden" name="foto_lama" value="<?php echo $d['foto'] ?>">
                    <input type="hidden" name="ids" value="<?php echo $d['ids'] ?>">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 upload-container">
                                    <img src="../assets/uploads/sans/<?php echo $d['foto'] ?>" class="img-fluid" id="fotoS_<?php echo $d['ids'] ?>">
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
                                                        <th>Id Santri</th>
                                                        <td><input type="text" name="ids" value="<?php echo $d['ids']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <td><input type="text" name="nama" value="<?php echo $d['nama']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Domisili</th>
                                                        <td><input type="text" name="dom" value="<?php echo $d['dom']; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>No Kamar</th>
                                                        <td><input type="text" name="no_kamar" value="<?php echo $d['no_kamar']; ?>"></td>
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
                                                        <td><input type="text" name="tahun_masuk" value="<?php echo $d['tahun_masuk']; ?>"></td>
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
                                        <button class="btn btn-btn-outline-primary btn-sm modal-data1" id="editButton<?php echo $d['ids']; ?>">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer custom-modal-footer">
                        <button type="submit" class="btn btn-primary" id="save-button<?php echo $d['ids']; ?>" disabled onclick="openModal('<?php echo $kelas ?>','<?php echo $d['ids'] ?>')">Simpan</button>
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
                var saveButton = document.getElementById('save-button<?php echo $d['ids']; ?>');
                saveButton.disabled = true;
                for (var i = 0; i < inputs.length; i++) {
                    var input = inputs[i];
                    input.disabled = true;
                }
            }

            function enableInputs() {
                var inputs = document.querySelectorAll('input[type="text"]');
                var saveButton = document.getElementById('save-button<?php echo $d['ids']; ?>');
                saveButton.disabled = false;
                for (var i = 0; i < inputs.length; i++) {
                    var input = inputs[i];
                    var nameAttribute = input.getAttribute('name');

                    if (nameAttribute !== "kls_din" && nameAttribute !== "jenjang_din") {
                        input.disabled = false;
                    }
                }
            }

            var editButton = document.getElementById('editButton<?php echo $d['ids']; ?>');
            editButton.addEventListener('click', function() {
                enableInputs();
            });

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
<?php endforeach; ?>


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
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

$id_u = $_SESSION['id'];
$p = $conn->query("SELECT u.*, p.*, p.id_p as id_pp from user as u left join pengurus as p on u.id_p = p.id_p WHERE u.id = '$id_u'");
if ($p->num_rows > 0) {
    $u = $p->fetch_assoc();
}
?>
<style>
    .card-body img {
    min-width: 170px;
    max-width: 100%;
    height: auto;
}
</style>

<link rel="stylesheet" href="../assets/css/profile.css">
<div class="container light-style flex-grow-1 container-p-y mt-2 mb-5">
    <div class="card overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="card-body media align-items-center">
                    <img src="../assets/uploads/pengurus/<?php echo $u['foto'] ?>" alt class="d-block ui-w-80">
                </div>
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account-general">General</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#account-change-password">Change password</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#account-info">Data</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#account-social-links">Social links</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#account-jabatan">Jabatan & Apps</a>
                </div>
            </div>
            <div class="col-md-9">
                <form action="../mod/user/up-pengurus" method="POST" enctype="multipart/form-data">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <label class="btn btn-outline-primary">
                                    Upload new photo
                                    <input type="file" class="account-settings-fileinput" name="foto" accept="image/*"> 
                                </label> &nbsp;
                                <div class="text-light small mt-1">Allowed JPG. Max size of 1mb</div>
                                <input type="hidden" class="form-control mb-1" value="<?php echo $u['foto']; ?>" name="foto_lama">
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">ID Pengurus</label>
                                    <input type="text" class="form-control mb-1" value="<?php echo $u['id_pp']; ?>" name="id_p" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control mb-1" value="<?php echo $u['username']; ?>" name="username">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="<?php echo $u['name']; ?>" name="name_user">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Password lama</label>
                                    <input type="password" class="form-control" name="pw_lama">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password baru</label>
                                    <input type="password" class="form-control" name="pw_baru">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Ulangi kata sandi baru</label>
                                    <input type="password" class="form-control" name="pw_baru_lagi">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tahun masuk</label>
                                            <input type="text" class="form-control" value="<?php echo $u['tahun_masuk']; ?>" name="tahun_masuk">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Nomer KK</label>
                                            <input type="text" class="form-control" value="<?php echo $u['no_kk']; ?>" name="no_kk">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">NIK</label>
                                            <input type="text" class="form-control" value="<?php echo $u['nik']; ?>" name="nik">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tempat lahir</label>
                                            <input type="text" class="form-control" value="<?php echo $u['tempat_lahir']; ?>" name="tempat_lahir">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tanggal lahir</label>
                                            <input type="text" class="form-control" value="<?php echo $u['tgl']; ?>" name="tgl_lahir">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Jenis kelamin</label>
                                            <div class="form-check">
                                                <?php
                                                $cek = '';
                                                if (isset($u['gender']) && $u['gender'] === 'PRIA') {
                                                    $cek = 'checked';
                                                }
                                                ?>
                                                <input class="form-check-input" type="radio" value="PRIA" id="pria" name="jenis_kelamin" <?php echo $cek; ?>>
                                                <label class="form-check-label" for="pria">
                                                    Laki-laki
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <?php
                                                $cek = '';
                                                if (isset($u['gender']) && $u['gender'] === 'WANITA') {
                                                    $cek = 'checked';
                                                }
                                                ?>
                                                <input class="form-check-input" type="radio" value="WANITA" id="wanita" name="jenis_kelamin" <?php echo $cek; ?>>
                                                <label class="form-check-label" for="wanita">
                                                    Perempuan
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Dusun</label>
                                            <input type="text" class="form-control" value="<?php echo $u['dusun']; ?>" name="dusun">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Desa</label>
                                            <input type="text" class="form-control" value="<?php echo $u['desa']; ?>" name="desa">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" value="<?php echo $u['kecamatan']; ?>" name="kecamatan">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Kabupaten</label>
                                            <input type="text" class="form-control" value="<?php echo $u['kabupaten']; ?>" name="kabupaten">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Provinsi</label>
                                            <input type="text" class="form-control" value="<?php echo $u['provinsi']; ?>" name="provinsi">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Anak Ke</label>
                                            <input type="number" class="form-control" value="<?php echo $u['anak_ke']; ?>" name="anak_ke">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Jumlah Saudara</label>
                                            <input type="number" class="form-control" value="<?php echo $u['jumlah_saudara']; ?>" name="jumlah_saudara">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Golongan darah</label>
                                            <input type="text" class="form-control" value="<?php echo $u['gol_darah']; ?>" name="gol_darah">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Kelas ammiyah</label>
                                            <input type="text" class="form-control" value="<?php echo $u['kls_am']; ?>" name="kls_am">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jenjang ammiyah</label>
                                            <input type="text" class="form-control" value="<?php echo $u['jenjang_am']; ?>" name="jenjang_am">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Domisili</label>
                                            <input type="text" class="form-control" value="<?php echo $u['dom']; ?>" name="dom">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">No. Kamar</label>
                                            <input type="number" class="form-control" value="<?php echo $u['no_kamar']; ?>" name="no_kamar">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Ayah</label>
                                            <input type="text" class="form-control" value="<?php echo $u['ayah']; ?>" name="ayah">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">NIK Ayah</label>
                                            <input type="text" class="form-control" value="<?php echo $u['nik_ayah']; ?>" name="nik_ayah">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tempat lahir Ayah</label>
                                            <input type="text" class="form-control" value="<?php echo $u['tl_a']; ?>" name="tl_a">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tanggal lahir Ayah</label>
                                            <input type="text" class="form-control" value="<?php echo $u['tgl_a']; ?>" name="tgl_lahir_ayah">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Pendidikan ayah</label>
                                            <input type="text" class="form-control" value="<?php echo $u['pendidikan_a']; ?>" name="pendidikan_a">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Pekerjaan ayah</label>
                                            <input type="text" class="form-control" value="<?php echo $u['pekerjaan_a']; ?>" name="pekerjaan_a">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Ibu</label>
                                            <input type="text" class="form-control" value="<?php echo $u['ibu']; ?>" name="ibu">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">NIK ibu</label>
                                            <input type="text" class="form-control" value="<?php echo $u['nik_ibu']; ?>" name="nik_ibu">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tempat lahir ibu</label>
                                            <input type="text" class="form-control" value="<?php echo $u['tl_i']; ?>" name="tl_i">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Tanggal lahir ibu</label>
                                            <input type="text" class="form-control" value="<?php echo $u['tgl_i']; ?>" name="tgl_lahir_ibu">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Pendidikan ibu</label>
                                            <input type="text" class="form-control" value="<?php echo $u['pendidikan_i']; ?>" name="pendidikan_i">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Pekerjaan ibu</label>
                                            <input type="text" class="form-control" value="<?php echo $u['pekerjaan_i']; ?>" name="pekerjaan_i">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Contacts</h6>
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" value="<?php echo $u['no_hp']; ?>" name="no_hp">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-social-links">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" class="form-control" value="<?php echo $u['twitter']; ?>" name="twitter">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control" value="<?php echo $u['fb']; ?>" name="fb">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Google+</label>
                                    <input type="text" class="form-control" value="<?php echo $u['google']; ?>" name="google">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control" value="<?php echo $u['instagram']; ?>" name="instagram">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-jabatan">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Jabatan</h6>
                                <?php
                                $id_u = $_SESSION['id'];
                                $r = $conn->query("SELECT r.name from role_u as u inner join role as r on u.id_r = r.id WHERE u.id_u = '$id_u'");
                                foreach ($r as $ru) {
                                ?>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <i class="bi bi-check"></i>
                                            <span class="switcher-label"><?php echo $ru['name']; ?></span>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Apps</h6>
                                <?php
                                $app = $conn->query("SELECT m.name from app as a inner join master_data as m on a.id_md = m.id WHERE a.id_u = '$id_u'");
                                foreach ($app as $ap) {
                                ?>
                                    <div class="form-group">
                                        <label class="switcher">
                                            <i class="bi bi-check"></i>
                                            <span class="switcher-label"><?php echo $ap['name']; ?></span>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="text-right m-3">
                        <button type="submit" class="btn btn-primary" name="saveChanges" id="saveButton">Save changes</button>
                        <button type="button" class="btn btn-default">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <?php
require '../tem/foot.php';
?> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/script2.js"></script>
<script src="../assets/js/alert.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var pwBaruInput = document.querySelector('input[name="pw_baru"]');
    pwBaruInput.addEventListener('input', function () {
        var pwBaruValue = pwBaruInput.value;
        var pwLamaInput = document.querySelector('input[name="pw_lama"]');
        var pwBaruLagiInput = document.querySelector('input[name="pw_baru_lagi"]');
        if (pwBaruValue.trim() !== '') {
            pwLamaInput.setAttribute('required', '');
            pwBaruLagiInput.setAttribute('required', '');
        } else {
            pwLamaInput.removeAttribute('required');
            pwBaruLagiInput.removeAttribute('required');
        }
    });
});
</script>

</body>

</html>
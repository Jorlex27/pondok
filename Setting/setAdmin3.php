<?php
session_start();
$judul = "Setting";
require '../tem/head.php';
require 'nav.php';
require '../tem/header.php';
require '../config/conn.php';
$am = $conn->query("SELECT * FROM user");
$b = $conn->query("SELECT md.*, u.name AS user_name, u.role AS role FROM master_data md LEFT JOIN user u ON md.by_id = u.id");
$pesan = isset($_GET['status']) ? $_GET['status'] : '';

?>

<style>
    .container {
        padding: 20px 40px 0 40px;
    }
    .ellak{
        height: 100px;
    }
    .more{
    font-size: 13px;
    text-align: center;
    vertical-align: middle;
    margin-right: 5px;
    }
    .pilihan{
        font-size: 15px;
        width: 100%;
        text-align: left;
    }
    .pilihan:hover{
    background-color: rgb(181, 184, 184);
    }

    .dropdownAdmin {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1;
    border-radius: 5px;
    padding: 2px;
    width: 150px;
}
</style>
<div class="container">
        <div class="row">
            <div class="col-md-6" id="data-user">
                <div class="col-md-12 d-flex justify-content-between mb-2 tabel-data">
                    <h2 class="h2">Data User</h2>
                    <button class="btn btn-primary btn-sm btn-tambah" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class='icon bx bx-plus'></i></button>
                </div>
                <div class="table-responsive shadow p-3 mb-5 bg-white rounded tabel1">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th></th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($am as $us) : ?>
                            <tr onclick="showUserDetails('<?php echo $us['username']; ?>', '<?php echo $us['name']; ?>', '<?php echo $us['role']; ?>')">
                                <td><?php echo $us['username']?></td>
                                <td>
                                    <div id="dropdownAdmin<?php echo $us['id']; ?>" class="dropdownAdmin">
                                    <button class="btn pilihan" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $us['id']; ?>"><i class="more material-icons">edit</i> Edit</button>
                                    <button class="btn pilihan" onclick="hapus(<?php echo $us['id']; ?>)"><i class="more material-icons">remove_circle</i> Hapus</button>
                                    </div>
                                </td>
                                <td><?php echo $us['name']?></td>
                                <td><?php echo $us['role'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-6" id="data-user">
                <div class="col-md-12 d-flex justify-content-between mb-2">
                    <h2 class="h2">Detail User</h2>
                </div>
                <div class="table-responsive shadow p-3 mb-5 bg-white rounded tabel1">
                <div class="user-card">
                    <div class="user-photo">
                    <img src="../assets/images/profile-1.jpg" alt="User Photo">
                    </div>
                    <div class="user-details">
                    <div class="user-name">Jorlex</div>
                    <div class="user-job">Manager</div>
                    <div class="user-info">
                        <div class="user-info-item">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Username</th>
                                        <td class="userName">kjhdjs</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td class="nameUser">bmnasbdm</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td class="jabatanUser">msbdmnb</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="col-md-12 d-flex justify-content-between mb-2">
                    <h2 class="h2">Import Data</h2>
                    <!-- <a class="btn btn-primary" href="upFoto.php">Import Foto</a> -->
                </div>
                <div class="table-responsive shadow p-3 mb-5 bg-white rounded tabel2">
                    <table class="table table-hover2">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th></th>
                                <th>Status</th>
                                <th>By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($b as $r) : ?>
                            <tr>
                                <td><?php echo $r['name']?></td>
                                <td>
                                <div id="dropdownAdmin<?php echo $r['name']; ?>" class="dropdownAdmin">
                                    <a class="btn pilihan" href="../import/example/<?php echo $r['name']; ?>.xlsx" download><i class="more material-icons">file_download</i> Download</a>
                                    <button class="btn pilihan" data-bs-toggle="modal" data-bs-target="#upData<?php echo $r['name']; ?>"><i class="more material-icons">upload</i> Upload</button>
                                    <button class="btn pilihan" onclick="ResetData('<?php echo $r['name']; ?>', '<?php echo $r['kolom']; ?>')"><i class="more material-icons">restart_alt</i> Reset</button>
                                    <button class="btn pilihan" data-bs-toggle="modal" data-bs-target="#cekDataModal"><i class="more material-icons">search</i> Cek Data</button>
                                </div>
                                </td>
                                <td><?php echo $r['status']?></td>
                                <td><?php echo $r['user_name']?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php foreach ($am as $us) : ?>
        <div class="modal fade" id="editModal<?php echo $us['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../mod/edit_user.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $us['username']; ?>">
                                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $us['id']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $us['name']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="hashed_password" class="form-control" value="" placeholder="***">
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <select id="jabatan" name="jabatan" class="form-control">
                                    <option value="" selected disabled><?php echo $us['role']; ?></option>
                                    <option value="Sekretariat">Ketua Umum</option>
                                    <option value="Wakil Koordinator">Sekretais Umum</option>
                                    <option value="Sekretaris">Bendahara Umum</option>
                                    <option value="Wakil Sekretaris">Komisi</option>
                                    <option value="IT">IT</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <?php foreach ($b as $r) : ?>
        <div class="modal fade" id="upData<?php echo $r['name']; ?>" tabindex="-1" role="dialog" aria-labelledby="upDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="rekeningModalLabel">Import Data <?php echo $r['name']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../import/<?php echo $r['name']; ?>.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="data" class="form-label">File</label>
                                <input type="file" name="excelFile" id="excelFile" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- form cek -->
        <div class="modal fade" id="cekDataModal" tabindex="-1" role="dialog" aria-labelledby="cekDataModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="cekDataModalLabel">Cek Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../import/cekdata.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="data" class="form-label">File</label>
                                <input type="file" name="excelFile" id="excelFile" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

                <!-- Modal untuk menambah data user -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm" action="../mod/setting/addUser.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <select id="jabatan" name="jabatan" class="form-control">
                                    <option value="" selected disabled>Pilih Jabatan</option>
                                    <option value="Koordinator">Ketua Umum</option>
                                    <option value="Wakil Koordinator">Sekretais Umum</option>
                                    <option value="Sekretaris">Bendahara Umum</option>
                                    <option value="Wakil Sekretaris">Komisi</option>
                                    <option value="IT">IT</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="ellak"></div>


<?php 
require '../helper/toastr.php';
require '../tem/foot.php';

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/script2.js"></script>
<script src="../assets/js/repag.js"></script>
<script src="../assets/js/hed.js"></script>
<script>
function hapus(id) {
  Swal.fire({
    title: 'Yakin mau dihapus?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '../mod/setting/deleteUser.php?id=' + id;
    }
  });
}
function ResetData(name, kolom) {
  Swal.fire({
    title: 'Semua data '+ name +' akan dihapus',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '../mod/setting/reset.php?name=' + name + '&kolom=' + kolom;
    }
  });
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('message');

    if (status === 'delete') {
        showSweetAlert("success", "Data telah dihapus");
    } else if (status === 'nodelete') {
        showSweetAlert("error", "Error! Tidak dapat melakukan operasi delete");
    } else if (status === 'update') {
        showSweetAlert("success", "Data telah diupdate");
    } else if (status === 'noupdate') {
        showSweetAlert("error", "Tidak dapat melakukan operasi update");
    } else if (status === 'import') {
        showSweetAlert("success", "Import selesai");
    }

    function showSweetAlert(icon, message) {
        Swal.fire({
            icon: icon,
            title: message,
            showConfirmButton: false,
            timer: 1000
        });
    }
});
</script>
<script>
  // Function to show user details
  function showUserDetails(username, name, jabatan) {
    const userPhoto = document.querySelector(".user-photo img");
    const userName = document.querySelector(".user-name");
    const userJob = document.querySelector(".user-job");
    const userUsername = document.querySelector(".userName");
    const userNameDetail = document.querySelector(".nameUser");
    const userJabatan = document.querySelector(".jabatanUser");

    userPhoto.src = "../assets/images/profile-1.jpg";
    userName.textContent = name;
    userJob.textContent = jabatan;
    userUsername.textContent = username;
    userNameDetail.textContent = name;
    userJabatan.textContent = jabatan;

    document.getElementById("data-user").style.display = "block";
  }
</script>

</body>
</html>
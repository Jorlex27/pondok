<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
}
$judul = "Setting Apps";
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';
require '../config/conn.php';
require '../setdb_admin/admin_db.php';

$status = isset($_GET['status']) ? $_GET['status'] : '';
require '../helper/alert.php';
?>
<style>
    .btn-sm {
        margin: 0 0 5px 5px;
    }

    .bx-plus {
        font-size: 12px;
    }

    .more {
        font-size: 13px;
        text-align: center;
        vertical-align: middle;
    }
</style>
<div class="container1">
    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#add_apps"><i class="bx bx-plus"></i> User</button>
    <div class="table-container">
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Apps</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomer = 1;
                foreach ($dataByRole as $id_u => $data) {
                ?>
                    <tr>
                        <td><?php echo $nomer++ ?> </td>
                        <td><?php echo $data['u_name'] ?></td>
                        <td><?php echo implode(', ', $data['jabatan']) ?></td>
                        <td><?php echo implode(', ', $data['apps']) ?></td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $id_u ?>"><i class="more material-icons">edit</i></button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#remove<?php echo $id_u ?>"><i class="more material-icons">backspace</i></button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus(<?php echo $id_u ?>)"><i class="more material-icons">delete</i></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php foreach ($dataByRole as $id_u => $data) {
    $n = $conn->query("SELECT id, name FROM master_data WHERE name != 'jabatan' AND id NOT IN (SELECT id_md FROM app WHERE id_u = $id_u)");
    $app = array();
    while ($row = $n->fetch_assoc()) {
        $app[] = $row;
    }
    $app_json = json_encode($app);

    $nr = $conn->query("SELECT * FROM role WHERE id NOT IN (SELECT id_r FROM role_u WHERE id_u = $id_u)");
    $roleU = array();
    while ($rr = $nr->fetch_assoc()) {
        $roleU[] = $rr;
    }
    $role_json2 = json_encode($roleU);
?>
    <div class="modal fade" id="myModal<?php echo $id_u ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../mod/setting/user?action=edit" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username']; ?>">
                            <input type="hidden" class="form-control" id="id_u" name="id_u" value="<?php echo $data['id_u']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="name" value="<?php echo $data['u_name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="pass-baru" class="form-control" value="" placeholder="***">
                        </div>
                        <div class="mb-3">
                            <label for="jabatan-input<?php echo $id_u ?>" class="form-label">Jabatan</label>
                            <input id="jabatan-input<?php echo $id_u ?>" class="form-control" placeholder="Tambah Jabatan">
                            <input type="hidden" id="jabatan-value<?php echo $id_u ?>" class="form-control" name="jabatan-input2">
                        </div>
                        <div class="mb-3">
                            <label for="input-tags<?php echo $id_u ?>" class="form-label">Apps</label>
                            <input id="input-tags<?php echo $id_u ?>" name="tags2" placeholder="Tambah tags" class="form-control">
                            <input type="hidden" name="tags_value2" id="tags-value<?php echo $id_u ?>">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="save" class="btn btn-primary" value="Update">
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var role_data = <?php echo $role_json2; ?>;
            var whitelistNames = role_data.map(function(item) {
                return item.name;
            });

            var jabatanTambah<?php echo $id_u ?> = document.querySelector('#jabatan-input<?php echo $id_u ?>');
            var tagifyJb<?php echo $id_u ?> = new Tagify(jabatanTambah<?php echo $id_u ?>, {
                whitelist: whitelistNames,
                enforceWhitelist: true,
            });

            tagifyJb<?php echo $id_u ?>.on('change', function(e) {
                var selectedTags = tagifyJb<?php echo $id_u ?>.value.map(function(tag) {
                    return tag.value;
                });

                var selectedIds = [];
                role_data.forEach(function(item) {
                    if (selectedTags.includes(item.name)) {
                        selectedIds.push(item.id);
                    }
                });

                document.getElementById('jabatan-value<?php echo $id_u ?>').value = selectedIds.join(', ');
            });

            var app_data = <?php echo $app_json; ?>;
            var whitelistNames = app_data.map(function(item) {
                return item.name;
            });
            // console.log(app_data);
            var input<?php echo $id_u ?> = document.querySelector('#input-tags<?php echo $id_u ?>');
            var tagify<?php echo $id_u ?> = new Tagify(input<?php echo $id_u ?>, {
                whitelist: whitelistNames,
                enforceWhitelist: true,
            });
            tagify<?php echo $id_u ?>.on('change', function(e) {
                var selectedTags = tagify<?php echo $id_u ?>.value.map(function(tag) {
                    return tag.value;
                });
                var selectedIds = selectedTags.map(function(selectedName) {
                    var selectedItem = masterData.find(function(item) {
                        return item.name === selectedName;
                    });

                    if (selectedItem) {
                        return selectedItem.id;
                    } else {
                        return null;
                    }
                });
                document.getElementById('tags-value<?php echo $id_u ?>').value = selectedIds.filter(Boolean).join(', ');
            });
        });
    </script>
<?php } ?>

<?php foreach ($dataByRole as $id_u => $data) {
    $n = $conn->query("SELECT r.id, r.name from role_u as ru inner join role as r on ru.id_r = r.id WHERE ru.id_u = $id_u");
    $nm = $conn->query("SELECT m.id, m.name as apps from app as a inner join master_data as m on a.id_md = m.id WHERE a.id_u = $id_u");
?>
    <div class="modal fade" id="remove<?php echo $id_u ?>" tabindex="-1" role="dialog" aria-labelledby="removeLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Remove</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="name" value="<?php echo $data['u_name']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="remove-tags" class="form-label">Apps</label>
                        <?php foreach ($nm as $md) { ?>
                            <div class="input-group mb-2">
                                <input id="remove-tags" name="tags_remove" class="form-control" value="<?php echo $md['apps'] ?>" readonly>
                                <button class="btn btn-outline-danger" type="button" onclick="hapusApps('satuaja',<?php echo $md['id'] ?>)">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">Jabatan</label>
                        <?php foreach ($n as $jr) { ?>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" value="<?php echo $jr['name']; ?>" readonly>
                                <button class="btn btn-outline-danger" type="button" onclick="hapusApps('jabatanaja',<?php echo $jr['id'] ?>)">
                                    <i class="material-icons">delete</i>
                                </button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="modal fade" id="add_apps" tabindex="-1" role="dialog" aria-labelledby="add_appsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add Apps</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../mod/setting/user?action=add" method="post">
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
                        <label for="jabatan-input" class="form-label">Jabatan</label>
                        <input type="text" id="jabatan-input" class="form-control">
                        <input type="hidden" id="jabatan-value" class="form-control" name="jabatan-input">
                    </div>
                    <div class="mb-3">
                        <label for="input-tags" class="form-label">Apps</label>
                        <input id="input-tags" name="tags" placeholder="Tambahkan tags" class="tagify form-control">
                        <input type="hidden" name="tags_value" id="tags-value">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="save" class="btn btn-primary" value="Save">
            </div>
            </form>
        </div>
    </div>
</div>

<?php
require '../tem/foot.php';
// require '../helper/toastr.php';
?>

<script src="../assets/js/table.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/repag.js"></script>
<script src="../assets/js/script2.js"></script>
<script src="../assets/js/gambar.js"></script>
<script src="../assets/js/alert.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.3.0/tagify.min.js"></script>
<script>
    var masterRole = <?php echo $role_json; ?>;
    var listName = masterRole.map(function(item) {
        return item.name;
    });
    // console.log(Data);
    var jabatanInput = document.querySelector('#jabatan-input');
    var tagify2 = new Tagify(jabatanInput, {
        whitelist: listName,
        enforceWhitelist: true,
    });
    tagify2.on('change', function(e) {
        var selectedTags = tagify2.value.map(function(tag) {
            return tag.value;
        });
        var selectedIds = selectedTags.map(function(selectedName) {
            var selectedItem = masterRole.find(function(item) {
                return item.name === selectedName;
            });

            if (selectedItem) {
                return selectedItem.id;
            } else {
                return null;
            }
        });
        document.getElementById('jabatan-value').value = selectedIds.filter(Boolean).join(', ');
    });

    var masterData = <?php echo $data_json; ?>;
    var whitelistNames = masterData.map(function(item) {
        return item.name;
    });
    // console.log(Data);
    var input = document.querySelector('#input-tags');
    var tagify = new Tagify(input, {
        whitelist: whitelistNames,
        enforceWhitelist: true,
    });
    tagify.on('change', function(e) {
        var selectedTags = tagify.value.map(function(tag) {
            return tag.value;
        });
        var selectedIds = selectedTags.map(function(selectedName) {
            var selectedItem = masterData.find(function(item) {
                return item.name === selectedName;
            });

            if (selectedItem) {
                return selectedItem.id;
            } else {
                return null;
            }
        });
        document.getElementById('tags-value').value = selectedIds.filter(Boolean).join(', ');
    });

    function hapus(id) {
        Swal.fire({
            title: 'Semua data user akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "../mod/setting/remove-All?action=delete&id=" + id;
            }
        });
    }

    function hapusApps(act, id) {
        window.location = "../mod/setting/remove-All?action=" + act + "&id=" + id;
    }
</script>

</body>

</html>
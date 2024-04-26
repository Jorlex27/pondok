<?php
session_start();
$judul = "Setting";
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';
require '../config/conn.php';
$status = isset($_GET['status']) ? $_GET['status'] : '';
require '../helper/alert.php';

$b = $conn->query("SELECT * from master_data");
?>

<style>
    .container {
        padding: 20px 40px 0 40px;
    }

    .more {
        font-size: 13px;
        text-align: center;
        vertical-align: middle;
        margin-right: 5px;
    }

    .bx-plus {
        font-size: 12px;
    }

    .pilihan {
        font-size: 15px;
        width: 100%;
        text-align: left;
    }

    .pilihan:hover {
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

    .table-hover2 tbody tr:hover td {
        background-color: #eeecec;
    }

    .table-hover tbody tr:hover td .dropdownAdmin {
        display: block;
    }

    .table-hover2 tbody tr:hover td .dropdownAdmin {
        display: block;
    }
    input{
        border: none;
        background-color: transparent;
        width: 100%;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 mb-2">
                <h2 class="h2">Master Data</h2>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addData"><i class="bx bx-plus"></i> Apps</button>
            </div>
            <div class="table-responsive shadow p-3 mb-5 bg-white rounded">
                <table class="table table-hover2">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                            <th>Jenis</th>
                            <th>Link</th>
                            <th>App Name</th>
                            <th>Kolom</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($b as $r) : ?>
                            <tr>
                                <td><?php echo $r['name'] ?></td>
                                <td>
                                    <div id="dropdownAdmin<?php echo $r['name']; ?>" class="dropdownAdmin">
                                        <button class="btn pilihan" data-bs-toggle="modal" data-bs-target="#upData<?php echo $r['id']; ?>"><i class="more material-icons">edit</i> Update</button>
                                        <button class="btn pilihan" onclick="removeY('<?php echo $r['id']; ?>')"><i class="more material-icons">remove</i> Hapus</button>
                                    </div>
                                </td>
                                <td><?php echo $r['jenis'] ?></td>
                                <td><?php echo $r['link'] ?></td>
                                <td><?php echo $r['app_name'] ?></td>
                                <td><?php echo $r['kolom'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php foreach ($b as $r) : ?>
        <div class="modal fade" id="upData<?php echo $r['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="upDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rekeningModalLabel">Import Data <?php echo $r['name']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../mod/setting/up-admin?action=update" method="post">
                        <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                        <div class="modal-body">
                            <div class="card-body">
                                <table class="table table-striped scrollable">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td><input type="text" name="name" value="<?php echo $r['name']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis</th>
                                            <td><input type="text" name="jenis" value="<?php echo $r['jenis']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <th>Link</th>
                                            <td><input type="text" name="link" value="<?php echo $r['link']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <th>App Name</th>
                                            <td><input type="text" name="app_name" value="<?php echo $r['app_name']; ?>"></td>
                                        </tr>
                                        <tr>
                                            <th>Kolom</th>
                                            <td><input type="text" name="kolom" value="<?php echo $r['kolom']; ?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
<?php endforeach; ?>

<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="addDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addApps">Add APPS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../mod/setting/up-admin?action=add" method="post">
                        <div class="modal-body">
                            <div class="card-body">
                                <table class="table table-striped scrollable">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td><input type="text" class="form-control" name="name"></td>
                                        </tr>
                                        <tr>
                                            <th>Jenis</th>
                                            <td><input type="text" class="form-control" name="jenis"></td>
                                        </tr>
                                        <tr>
                                            <th>Link</th>
                                            <td><input type="text" class="form-control" name="link"></td>
                                        </tr>
                                        <tr>
                                            <th>App Name</th>
                                            <td><input type="text" class="form-control" name="app_name"></td>
                                        </tr>
                                        <tr>
                                            <th>Kolom</th>
                                            <td><input type="text" class="form-control" name="kolom"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php
require '../tem/foot.php';

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/script2.js"></script>
<script src="../assets/js/repag.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/alert.js"></script>
<script>
    function removeY(id) {
        Swal.fire({
            title: 'APPS mau di hapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../mod/setting/re-admin?action=remove&id=' + id;
            }
        });
    }
</script>


</body>

</html>
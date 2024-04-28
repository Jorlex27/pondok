<?php
session_start();
$judul = "Setting";
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';
require '../config/conn.php';

$status = isset($_GET['status']) ? $_GET['status'] : '';
require '../helper/alert.php';
$id_s = $_SESSION['id'];

$nm = $conn->query("SELECT md.*, u.name AS user_name
from app as a
INNER JOIN master_data AS md ON a.id_md = md.id
left JOIN user u ON md.by_id = u.id
WHERE a.id_u = $id_s AND (md.link = 'data' OR md.link = 'sekretariat') order by md.id asc");

$na = $conn->query("SELECT k.id as id_k, k.name as kelas, md.id, md.name as tingkat from app as a
inner join master_data as md on a.id_md = md.id
left join kelas as k on md.id = k.id_md
where a.id_u = $id_s AND (md.link = 'data' OR md.link = 'sekretariat') order by kelas asc
");
$datakelas = array();
while ($g = $na->fetch_assoc()) {
    $id_md = $g['id'];
    $id_k = $g['id_k'];
    $kls = $g['kelas'];
    $tingkat = $g['tingkat'];
    if (!isset($datakelas[$id_md])) {
        $datakelas[$id_md] = array(
            'id' => $id_md,
            'id_k' => $id_k,
            'tingkat' => $tingkat,
            'kelas' => array(),
        );
    }
    $kelasArray = array();
    foreach ($datakelas[$id_md]['kelas'] as $exkelas) {
        $kelasArray[$exkelas] = true;
    }
    if (!isset($kelasArray[$kls])) {
        $datakelas[$id_md]['kelas'][] = $kls;
    }
}

$m_d = $conn->query("SELECT id, name FROM master_data WHERE (jenis = 'Diniyah' OR jenis = 'Ammiyah') AND id IN (SELECT id_md FROM app WHERE id_u = $id_s)");

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

    .pilihan {
        font-size: 15px;
        width: 100%;
        text-align: left;
    }

    .tombol-data {
        width: 30px;
    }

    .bx-plus {
        font-size: 12px;
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
</style>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12 d-flex justify-content-between mb-2">
                <h2 class="h2">Import Data</h2>
            </div>
            <div class="table-responsive shadow p-3 mb-5 bg-white rounded">
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
                        <?php foreach ($nm as $r) : ?>
                            <tr>
                                <td><?php echo $r['name'] ?></td>
                                <td>
                                    <div id="dropdownAdmin<?php echo $r['name']; ?>" class="dropdownAdmin">
                                        <a class="btn pilihan" href="../import/example/<?php echo $r['app_name']; ?>.xlsx" download><i class="more material-icons">file_download</i> Download</a>
                                        <button class="btn pilihan" data-bs-toggle="modal" data-bs-target="#upData<?php echo $r['name']; ?>"><i class="more material-icons">upload</i> Upload</button>
                                        <button class="btn pilihan" onclick="ResetData('<?php echo $r['name']; ?>', '<?php echo $r['kolom']; ?>')"><i class="more material-icons">restart_alt</i> Reset</button>
                                        <button class="btn pilihan" data-bs-toggle="modal" data-bs-target="#cekDataModal"><i class="more material-icons">search</i> Cek Data</button>
                                    </div>
                                </td>
                                <td><?php echo $r['status'] ?></td>
                                <td><?php echo $r['user_name'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-8">
            <div class="col-md-12 d-flex justify-content-between mb-2">
                <h2 class="h2">Data Kelas</h2>
                <!-- <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#add_class"><i class="bx bx-plus"></i> Kelas</button> -->
            </div>
            <div class="table-responsive shadow p-3 mb-5 bg-white rounded" style="max-height: 600px; overflow-y: scroll;">
                <table class="table table-hover2">
                    <thead>
                        <tr>
                            <th>Tingkat</th>
                            <th>Kelas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($datakelas as $id_k => $md) {
                        ?>
                            <tr>
                                <td><?php echo $md['tingkat']; ?></td>
                                <td><?php echo implode(', ', $md['kelas']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm tombol-data" onclick="tambahJ_Kelas(<?php echo $md['id'] ?>)"><i class="more material-icons">add</i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#remove<?php echo $id_k ?>"><i class="more material-icons">backspace</i></button>
                                    <button type="button" class="btn btn-danger btn-sm tombol-data" onclick="remove(<?php echo $md['id'] ?>, 'all')"><i class="more material-icons">delete</i></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <?php foreach ($nm as $r) : ?>
        <div class="modal fade" id="upData<?php echo $r['name']; ?>" tabindex="-1" role="dialog" aria-labelledby="upDataLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rekeningModalLabel">Import Data <?php echo $r['name']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../import/<?php echo $r['app_name']; ?>?i_name=<?php echo $r['name']; ?>" method="post" enctype="multipart/form-data">
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

<?php foreach ($datakelas as $id_k => $md) {
    $id_m = $md['id'];
    $naa = $conn->query("SELECT k.id as id_k, k.name as kelas, md.id
    FROM kelas as k
    inner join master_data as md on k.id_md = md.id WHERE k.id_md = $id_m");
?>
    <div class="modal fade" id="remove<?php echo $id_k ?>" tabindex="-1" role="dialog" aria-labelledby="removeLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Remove</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tingkat" class="form-label">Jenjang</label>
                        <input type="text" class="form-control" id="tingkat" name="tingkat" value="<?php echo $md['tingkat']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="remove-tags" class="form-label">Kelas</label>
                        <?php foreach ($naa as $kl) { ?>
                            <div class="input-group mb-2">
                                <input id="remove-tags" name="tags_remove" class="form-control" value="<?php echo $kl['kelas'] ?>" readonly>
                                <button class="btn btn-outline-danger" type="button" onclick="hapusK('<?php echo $kl['id_k'] ?>','byOne')">
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

<div class="modal fade" id="add_class" tabindex="-1" role="dialog" aria-labelledby="add_classLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../mod/data/m-data?action=add" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <input type="text" class="form-control" id="jenjang" name="jenjang" list="master-data">
                        <input type="hidden" name="id_m" id="id_m">
                        <datalist id="master-data">
                            <?php foreach ($m_d as $f) { ?>
                                <option data-id="<?php echo $f['id'] ?>"><?php echo $f['name'] ?></option>
                            <?php } ?>
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="number" class="form-control" id="kelas" name="kelas">
                    </div>
                    <div class="mb-3">
                        <label for="j_kelas" class="form-label">Jumlah Kelas</label>
                        <input type="number" class="form-control" id="j_kelas" name="j_kelas">
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

<!-- form cek -->
<div class="modal fade" id="cekDataModal" tabindex="-1" role="dialog" aria-labelledby="cekDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cekDataModalLabel">Cek Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../import/cekdata" method="post" enctype="multipart/form-data">
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

<?php
// require '../tem/foot.php';

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/script2.js"></script>
<script src="../assets/js/repag.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/alert.js"></script>
<script src="../assets/js/import.js"></script>
<script>
    function hapusK(id, act) {
        window.location = '../mod/setting/delete-kelas?id=' + id + '&action=' + act;
    }
</script>
</body>

</html>
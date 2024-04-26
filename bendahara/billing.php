<?php
session_start();
$judul = "Setting";
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';
require '../config/conn.php';

$status = isset($_GET['status']) ? $_GET['status'] : '';
require '../helper/alert.php';
$id_u = $_SESSION['id'];
$thn = $_SESSION['thn_ajaran'];

$nm = $conn->query("SELECT * FROM spp WHERE thn_ajaran = '$thn'");
$m_d = $conn->query("SELECT id, name FROM master_data WHERE jenis = 'Diniyah' or name = 'TK'");

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

    .bx-plus,
    .bx-pencil,
    .bx-minus {
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
        <div class="col-md-12">
            <div class="col-md-12 d-flex justify-content-between mb-2">
                <h2 class="h2">Data Payment</h2>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#add_bill"><i class="bx bx-plus"></i> Bill</button>
            </div>
            <div class="table-responsive shadow p-3 mb-5 bg-white rounded">
                <table class="table table-hover2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenjang</th>
                            <th>Domisili</th>
                            <th>Pendaftaran</th>
                            <th>Gedung</th>
                            <th>Infaq Al-ittihad</th>
                            <th>Bapenta</th>
                            <th>Dansos</th>
                            <th>Hari Jadi</th>
                            <th>Total</th>
                            <th>Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($nm as $r) : ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $r['name'] ?></td>
                                <td><?php echo $r['jenjang'] ?></td>
                                <td><?php echo $r['dom'] ?></td>
                                <td>Rp. <?php echo number_format($r['pangkal'], 0, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($r['gedung'], 0, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($r['pembangunan'], 0, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($r['ianah'], 0, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($r['dansos'], 0, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($r['hari_jadi'], 0, ',', '.') ?></td>
                                <td>Rp. <?php echo number_format($r['total'], 0, ',', '.') ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#upData<?php echo $r['id_spp']; ?>"><i class="bx bx-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm" onclick="hapusK(<?php echo $r['id_spp']; ?>)"><i class="bx bx-minus"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php foreach ($nm as $r) : ?>
            <div class="modal fade" id="upData<?php echo $r['id_spp']; ?>" tabindex="-1" role="dialog" aria-labelledby="upDataLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rekeningModalLabel">Edit Bill</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../mod/payment/opt-billing?action=edit" method="post">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_spp" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_spp" id="nama_spp" value="<?php echo $r['name'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="jenjang" class="form-label">Jenjang</label>
                                    <input type="text" class="form-control" id="jenjang" name="jenjang" list="master-data" value="<?php echo $r['jenjang'] ?>">
                                    <input type="hidden" name="id_spp" id="id_spp" value="<?php echo $r['id_spp'] ?>">
                                    <datalist id="master-data">
                                        <?php foreach ($m_d as $f) { ?>
                                            <option value="<?php echo $f['name'] ?>" data-id="<?php echo $f['id'] ?>">
                                            <?php } ?>
                                    </datalist>
                                </div>
                                <div class="mb-3">
                                    <label for="dom" class="form-label">Domisili</label>
                                    <select class="form-control" name="dom" id="dom">
                                        <option value="<?php echo $r['dom'] ?>" selected><?php echo $r['dom'] ?></option>
                                        <option value="PPK">PPK</option>
                                        <option value="LPPK">LPPK</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="pangkal_<?php echo $r['id_spp'] ?>" class="form-label">Uang Pangkal</label>
                                    <input type="text" class="form-control" id="pangkal_<?php echo $r['id_spp'] ?>" name="uang_pangkal" value="<?php echo "Rp. " . number_format($r['pangkal'], 0, ',', '.') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="gedung_<?php echo $r['id_spp'] ?>" class="form-label">Uang Gedung</label>
                                    <input type="text" class="form-control" id="gedung_<?php echo $r['id_spp'] ?>" name="uang_gedung" value="<?php echo "Rp. " . number_format($r['gedung'], 0, ',', '.') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="pembangunan_<?php echo $r['id_spp'] ?>" class="form-label">Uang Pembangunan</label>
                                    <input type="text" class="form-control" id="pembangunan_<?php echo $r['id_spp'] ?>" name="uang_pembangunan" value="<?php echo "Rp. " . number_format($r['pembangunan'], 0, ',', '.') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="ianah_<?php echo $r['id_spp'] ?>" class="form-label">I'anah Maslahah</label>
                                    <input type="text" class="form-control" id="ianah_<?php echo $r['id_spp'] ?>" name="uang_ianah" value="<?php echo "Rp. " . number_format($r['ianah'], 0, ',', '.') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="dansos_<?php echo $r['id_spp'] ?>" class="form-label">Dansos</label>
                                    <input type="text" class="form-control" id="dansos_<?php echo $r['id_spp'] ?>" name="uang_dansos" value="<?php echo "Rp. " . number_format($r['dansos'], 0, ',', '.') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="hari_jadi_<?php echo $r['id_spp'] ?>" class="form-label">Hari Jadi</label>
                                    <input type="text" class="form-control" id="hari_jadi_<?php echo $r['id_spp'] ?>" name="uang_hari_jadi" value="<?php echo "Rp. " . number_format($r['hari_jadi'], 0, ',', '.') ?>">
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
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            console.log(document.getElementById('gedung_<?php echo $r['id_spp'] ?>'));

            function formatRupiah(angka, prefix) {
                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix === undefined ? rupiah : rupiah ? 'Rp. ' + rupiah : '';
            }

            function updateRupiahFormat(inputId) {
                var inputElement = document.getElementById(inputId);
                if (inputElement) {
                    inputElement.value = formatRupiah(inputElement.value, 'Rp. ');
                }
            }
            document.getElementById('pangkal_<?php echo $r['id_spp'] ?>').addEventListener('keyup', function() {
                updateRupiahFormat('pangkal_<?php echo $r['id_spp'] ?>');
            });

            document.getElementById('gedung_<?php echo $r['id_spp'] ?>').addEventListener('keyup', function() {
                updateRupiahFormat('gedung_<?php echo $r['id_spp'] ?>');
            });

            document.getElementById('pembangunan_<?php echo $r['id_spp'] ?>').addEventListener('keyup', function() {
                updateRupiahFormat('pembangunan_<?php echo $r['id_spp'] ?>');
            });

            document.getElementById('ianah_<?php echo $r['id_spp'] ?>').addEventListener('keyup', function() {
                updateRupiahFormat('ianah_<?php echo $r['id_spp'] ?>');
            });

            document.getElementById('dansos_<?php echo $r['id_spp'] ?>').addEventListener('keyup', function() {
                updateRupiahFormat('dansos_<?php echo $r['id_spp'] ?>');
            });

            document.getElementById('hari_jadi_<?php echo $r['id_spp'] ?>').addEventListener('keyup', function() {
                updateRupiahFormat('hari_jadi_<?php echo $r['id_spp'] ?>');
            });
        });
    </script>
<?php endforeach; ?>

<div class="modal fade" id="add_bill" tabindex="-1" role="dialog" aria-labelledby="add_billLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add Bill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../mod/payment/opt-billing?action=add" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_spp" class="form-label">Nama Pembayaran</label>
                        <input type="text" class="form-control" id="nama_spp" name="nama_spp">
                    </div>
                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <input type="text" class="form-control" id="jenjang" name="jenjang" list="master-data">
                        <input type="hidden" name="id_m" id="id_m">
                        <datalist id="master-data">
                            <?php foreach ($m_d as $f) { ?>
                                <option value="<?php echo $f['name'] ?>" data-id="<?php echo $f['id'] ?>">
                                <?php } ?>
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="dom" class="form-label">Domisili</label>
                        <select class="form-control" name="dom" id="dom">
                            <option value="PPK">PPK</option>
                            <option value="LPPK">LPPK</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pangkal" class="form-label">Uang Pangkal</label>
                        <input type="text" class="form-control" id="pangkal" name="uang_pangkal">
                    </div>
                    <div class="mb-3">
                        <label for="gedung" class="form-label">Uang Gedung</label>
                        <input type="text" class="form-control" id="gedung" name="uang_gedung">
                    </div>
                    <div class="mb-3">
                        <label for="pembangunan" class="form-label">Uang Pembangunan</label>
                        <input type="text" class="form-control" id="pembangunan" name="uang_pembangunan">
                    </div>
                    <div class="mb-3">
                        <label for="ianah" class="form-label">I'anah Maslahah</label>
                        <input type="text" class="form-control" id="ianah" name="uang_ianah">
                    </div>
                    <div class="mb-3">
                        <label for="dansos" class="form-label">Dansos</label>
                        <input type="text" class="form-control" id="dansos" name="uang_dansos">
                    </div>
                    <div class="mb-3">
                        <label for="hari_jadi" class="form-label">Hari Jadi</label>
                        <input type="text" class="form-control" id="hari_jadi" name="uang_hari_jadi">
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
// require '../tem/foot.php';

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/script2.js"></script>
<script src="../assets/js/repag.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/alert.js"></script>
<script src="../assets/js/import.js"></script>
<script>
    function hapusK(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Bill akan dihapus",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = '../mod/payment/opt-billing?id=' + id + '&action=dell';
            }
        })
    }
</script>
<script>
    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : rupiah ? 'Rp. ' + rupiah : '';
    }

    function updateRupiahFormat(inputId) {
        var inputElement = document.getElementById(inputId);
        if (inputElement) {
            inputElement.value = formatRupiah(inputElement.value, 'Rp. ');
        }
    }

    document.getElementById('pangkal').addEventListener('keyup', function() {
        updateRupiahFormat('pangkal');
    });

    document.getElementById('gedung').addEventListener('keyup', function() {
        updateRupiahFormat('gedung');
    });

    document.getElementById('pembangunan').addEventListener('keyup', function() {
        updateRupiahFormat('pembangunan');
    });

    document.getElementById('ianah').addEventListener('keyup', function() {
        updateRupiahFormat('ianah');
    });

    document.getElementById('dansos').addEventListener('keyup', function() {
        updateRupiahFormat('dansos');
    });

    document.getElementById('hari_jadi').addEventListener('keyup', function() {
        updateRupiahFormat('hari_jadi');
    });
</script>


</body>

</html>
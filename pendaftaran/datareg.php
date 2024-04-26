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
require '../vendor/autoload.php';

date_default_timezone_set('Asia/Jakarta');

use GeniusTS\HijriDate\Date;

$hijriNow = Date::now();
$year = $hijriNow->year;

$thn = $_SESSION['thn_ajaran'];

$pesan = isset($_GET['status']) ? $_GET['status'] : '';
$Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';

$a = $conn->query("SELECT id, nama, ayah, jenjang_din, kls_din, jenjang_am, tanggal_reg
FROM registrasi order by tanggal_reg DESC");

// $m_d = $conn->query("SELECT id, name FROM master_data WHERE jenis = 'Diniyah' or name = 'TK'");
// $sp = $conn->query("SELECT id_spp, name, jenjang FROM spp");

?>
<style>
    .bx-plus {
        font-size: 12px;
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
    <div class="table-container">
        <!-- <button class="btn btn-info btn-sm m-3" data-bs-toggle="modal" data-bs-target="#add_class"><i class="bx bx-plus"></i> Bill</button> -->
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. REg</th>
                    <th>Nama</th>
                    <th>Jenjang</th>
                    <th>Wali</th>
                    <th>Tanggal Req</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomer = 1;
                foreach ($a as $d) :
                    if ($d['jenjang_am'] === 'TK') {
                        $jenjang = $d['jenjang_am'];
                    } else {
                        $jenjang = $d['kls_din'] . ' ' . $d['jenjang_din'];
                    }
                ?>
                    <tr>
                        <td><?php echo $nomer++ ; ?></td>
                        <td><?php echo $d['id'] ; ?></td>
                        <td><?php echo $d['nama'] ?></td>
                        <td><?php echo $jenjang ?></td>
                        <td><?php echo $d['ayah'] ?></td>
                        <td><?php echo $d['tanggal_reg'] ?></td>
                        <td>
                            <!-- <button class="btn btn-warning btn-sm" onclick="cetak('<?php echo $d['id_not']; ?>', '<?php echo $d['nama'] ?>')"><i class="bx bx-printer" style="font-size: 14px;"></i></button> -->
                            <!-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $d['ids']; ?>"><i class="bx bx-edit" style="font-size: 14px;"></i></button> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </form>
</div>

<!-- Modal -->

<style>
    .user-input {
        text-align: center;
        align-items: center;
    }

    input[type="text"] {
        border: 1px solid #ccc;
        padding: 5px;
    }

    #diskon-input,
    #pembayaran {
        border: 1px solid #ccc;
        padding: 2px;
    }

    .select-container {
        position: relative;
        display: inline-block;
    }

    select {
        appearance: none;
        padding: 3px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        width: auto;
    }

    select option {
        padding: 3px;
        font-size: 16px;
    }

    #santriList {
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        z-index: 1;
        background-color: #fff;
        width: 100%;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #santriList option {
        padding: 10px 15px;
        cursor: pointer;
        transition: background-color 0.2s;
        font-size: 14px;
    }

    #santriList option:hover {
        background-color: #f0f0f0;
    }
</style>

<div class="modal fade" id="add_class" tabindex="-1" role="dialog" aria-labelledby="add_classLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add Billing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="id_c" class="form-label">Id Calon Santri</label>
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

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header custom-modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../mod/payment/add-payment-b" method="post" id="myForm">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- bkg -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer custom-modal-footer">
                    <button type="submit" class="btn btn-primary" id="save-button">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require '../tem/foot.php';
?>

<script src="../assets/js/table.js"></script>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/madrosiyah.js"></script>
<script src="../assets/js/script2.js"></script>
<script src="../assets/js/alert.js"></script>
<script src="../assets/js/rupiah.js"></script>

<script>
    function formatRupiah(id) {
        var input = document.getElementById(id);
        var value = input.value;
        value = value.replace("Rp. ", "").replace(/\./g, "");

        var formattedValue = "Rp. " + Number(value).toLocaleString("id-ID");

        input.value = formattedValue;
    }
</script>

<script>
    $(document).ready(function() {
        $("#ids").keypress(function(e) {
            if (e.which == 13) {
                e.preventDefault();
                $("#btnLanjut").click();
            }
        });

        $("#btnLanjut").click(function() {
            var id_c = $("#id_c").val();
            var type = $("input[name='type-pembayaran']:checked").val();

            $.ajax({
                type: "POST",
                url: "../mod/payment/cc-payment-b",
                data: {
                    id_c: id_c,
                },
                success: function(data) {
                    $("#myModal .modal-body").html(data);
                    $("#myModal").modal('show');
                    $("#pembayaran").focus();
                },
                error: function() {
                    alert("Terjadi kesalahan.");
                }
            });
        });
    });
</script>

<script>
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function removeParameterFromURL(parameter) {
        var url = window.location.href;
        var urlparts = url.split('?');
        if (urlparts.length >= 2) {
            var prefix = encodeURIComponent(parameter) + '=';
            var pars = urlparts[1].split(/[&;]/g);

            for (var i = pars.length; i-- > 0;) {
                if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                }
            }

            url = urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
            window.history.replaceState(null, document.title, url);
        }
    }

    var id_not = getParameterByName('id_not');

    if (id_not) {
        Swal.fire({
            title: 'Pembayaran berhasil!',
            text: 'Cetak nota?',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                var printUrl = "../print/payment/nota?" +
                    "id_not=" + id_not;
                window.open(printUrl, "_blank");
                removeParameterFromURL('id_not');
            } else {
                removeParameterFromURL('id_not');
            }
        });
    }

    function cetak(id_not, name) {
        Swal.fire({
            title: 'Cetak nota ' + name + ' ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                var printUrl = "../print/payment/nota?" +
                    "id_not=" + id_not;
                window.open(printUrl, "_blank");
            }
        });
    }
</script>

</body>

</html>
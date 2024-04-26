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

$a = $conn->query("SELECT s.ids, s.nama, s.dom, s.dusun, s.desa, s.kecamatan, s.ayah, s.kls_din, s.jenjang_din, s.foto, b.*, sp.jenjang, sp.total, sp.id_spp, bb.tanggal as date2, bb.payment as pay2, n.id_not, n.thn_ajaran
FROM nota as n
inner join payments1 as b on n.id_pay1 = b.id_pay
left join payments2 as bb on n.id_pay2 = bb.id_pay
inner join spp as sp on n.id_spp = sp.id_spp
inner join santri as s on n.ids = s.ids
WHERE n.thn_ajaran = '$thn' order by tanggal DESC
");

$m_d = $conn->query("SELECT id, name FROM master_data WHERE jenis = 'Diniyah' or name = 'TK'");
$sp = $conn->query("SELECT id_spp, name, jenjang FROM spp");
$sans = $conn->query("SELECT ids, nama, kls_din, jenjang_din, dom, no_kamar FROM santri");

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
        <button class="btn btn-info btn-sm m-3" data-bs-toggle="modal" data-bs-target="#add_class"><i class="bx bx-plus"></i> Bill</button>
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>ID Santri</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Pembayaran 1</th>
                    <th>Tanggal</th>
                    <th>Pembayaran 2</th>
                    <th>Diskon</th>
                    <th>Sisa</th>
                    <th>Act</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$a) {
                    echo $conn->error;
                }
                $nomer = 1;
                foreach ($a as $d) :
                    if ($d['jenjang'] === 'TK') {
                        $jenjang = $d['jenjang'];
                    } else {
                        $jenjang = $d['kls_din'] . ' ' . $d['jenjang_din'];
                    }
                ?>
                    <tr>
                        <td><?php echo $nomer++; ?></td>
                        <td class="gambar"><img src="../assets/uploads/sans/<?php echo $d['foto'] ?>" alt=""></td>
                        <td><?php echo $d['ids']; ?></td>
                        <td><?php echo $d['nama'] ?></td>
                        <td><?php echo $jenjang ?></td>
                        <td><?php echo $d['tanggal'] ?></td>
                        <td>Rp. <?php echo number_format($d['payment'], 0, ',', '.') ?></td>
                        <td><?php echo $d['date2'] ?></td>
                        <td>Rp. <?php if ($d['pay2']){echo number_format($d['pay2'], 0, ',', '.');} ?></td>
                        <td><?php echo $d['diskon'] ?> %</td>
                        <td>Rp. <?php echo number_format($d['sisa'], 0, ',', '.') ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="cetak('<?php echo $d['id_not']; ?>', '<?php echo $d['nama'] ?>')"><i class="bx bx-printer" style="font-size: 14px;"></i></button>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#myModal<?php echo $d['ids']; ?>"><i class="bx bx-edit" style="font-size: 14px;"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </form>
</div>

<!-- Modal -->
<?php foreach ($a as $d) :
    if ($d['jenjang'] === 'TK') {
        $jenjang = $d['jenjang'];
    } else {
        $jenjang = $d['kls_din'] . ' ' . $d['jenjang_din'];
    } ?>
    <div class="modal fade" id="myModal<?php echo $d['ids']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pembayaran <?php echo $d['nama']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../mod/payment/up-payment" method="post" enctype="multipart/form-data" id="myForm">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 upload-container">
                                    <img src="../assets/uploads/sans/<?php echo $d['foto'] ?>" class="img-fluid" id="fotoS_<?php echo $d['ids'] ?>">
                                </div>
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-striped scrollable">
                                                <tbody>
                                                    <tr>
                                                        <th>Id Santri</th>
                                                        <td><span> <?php echo $d['ids']; ?> </span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <td><span> <?php echo $d['nama']; ?> </span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Wali</th>
                                                        <td><span> <?php echo $d['ayah'] ?></span> </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kelas</th>
                                                        <td><span> <?php echo $jenjang; ?> </span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Payment 1</th>
                                                        <td>
                                                            <input type="hidden" class="fomr-control" name="ids" value="<?php echo $d['ids']; ?>">
                                                            <input type="hidden" class="fomr-control" name="id_spp" value="<?php echo $d['id_spp']; ?>">
                                                            <input type="hidden" class="fomr-control" name="id_not" value="<?php echo $d['id_not']; ?>">
                                                            <input type="hidden" class="fomr-control" name="id_pay" value="<?php echo $d['id_pay']; ?>">
                                                            <input type="text" class="fomr-control" name="payment1" id="payment1_<?php echo $d['ids']; ?>" oninput="formatRupiah('payment1_<?php echo $d['ids']; ?>')" value="<?php echo "Rp. " . number_format($d['payment'], 0, ',', '.'); ?>">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Diskon</th>
                                                        <td>
                                                            <div class="col d-flex" style="width: 60px;">
                                                                <input type="text" class="fomr-control" name="diskon" value="<?php echo $d['diskon']; ?>">
                                                                %
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sisa</th>
                                                        <td><input type="text" class="fomr-control" name="sisa" id="sisa_<?php echo $d['ids']; ?>" value="<?php echo "Rp. " . number_format($d['sisa'], 0, ',', '.'); ?>" readonly> </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Payment 2</th>
                                                        <td><input type="text" class="fomr-control" name="payment2" id="payment2_<?php echo $d['ids']; ?>" value="<?php if ($d['pay2']){ echo "Rp. " + number_format($d['pay2'], 0, ',', '.');} ?>" readonly> </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer custom-modal-footer">
                        <button type="submit" class="btn btn-primary" id="save-button?>">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

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
                <h3 class="form-label">Jenis Pembayaran</h3>
                <div class="mb-3 d-flex">
                    <div class="form-chek">
                        <div class="select-container">
                            <select name="id_spp">
                                <?php $no = 1;
                                foreach ($sp as $spp) : ?>
                                    <option value="<?php echo $spp['id_spp']; ?>"><?php echo $no++ . '. ' . $spp['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-check ml-9">
                        <input class="form-check-input" type="radio" name="type-pembayaran" id="satu" value="satu" checked>
                        <label class="form-check-label" for="satu">
                            Pertama
                        </label>
                    </div>
                    <div class="form-check ml-6">
                        <input class="form-check-input" type="radio" name="type-pembayaran" id="dua" value="dua">
                        <label class="form-check-label" for="dua">
                            Kedua
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="ids" class="form-label">Id Santri</label>
                    <input type="text" class="form-control" id="ids" name="ids" list="santriList">
                    <datalist id="santriList">
                        <?php
                        foreach ($sans as $s) {
                            if ($s['dom'] != 'LPPK') {
                                $dom = 'PPK';
                            } else {
                                $dom = 'LPPK';
                            }
                        ?>
                            <option value="<?php echo $s['ids']; ?>"><?php echo $s['ids']; ?> | <?php echo $s['nama']; ?> | <?php echo $s['kls_din'] . ' ' . $s['jenjang_din']; ?> | <?php echo $dom; ?></option>
                        <?php } ?>
                    </datalist>
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
            <form action="../mod/payment/add-payment" method="post" id="myForm">
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
            var idSantri = $("#ids").val();
            var selectedSPP = $("select[name='id_spp']").val();
            var type = $("input[name='type-pembayaran']:checked").val();

            $.ajax({
                type: "POST",
                url: "../mod/payment/cc-payment",
                data: {
                    ids: idSantri,
                    id_spp: selectedSPP,
                    type: type
                },
                success: function(data) {
                    $("#myModal .modal-body").html(data);
                    $("#myModal").modal('show');
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
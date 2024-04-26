<?php
require __DIR__ . '/../../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_c = $_POST['id_c'];

    $sql = "SELECT * FROM registrasi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_c);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['jenjang_am'] === 'TK'){
            $jenjang = $row['jenjang_am'];
        } else {
            $jenjang = $row['jenjang_din'];
        }
        $dom = $row['dom'];
        $domm = (strpos(strtolower($dom), 'lppk') !== false) ? "LPPK" : "PPK";

        session_start();
        $thn = $_SESSION['thn_ajaran'];

        $sp = $conn->prepare("SELECT id_spp, name, jenjang, dom, total FROM spp WHERE jenis = 'baru' AND jenjang = ? AND dom = ? AND thn_ajaran = ?");
        $sp->bind_param("sss", $jenjang, $domm, $thn);
        $sp->execute();
        $res = $sp->get_result();

        if ($res->num_rows > 0) {
            $r = $res->fetch_assoc();
        } else {
            // $dt = array($jenjang, $domm, $thn); . implode(", ", $dt)
            die("Tidak ada data billing.");
        }

        $total = $r['total'];
        $id_pay = '';
        $dis = '';

        $htmlContent = '<table class="table table-striped scrollable">';
        $htmlContent .= '<tbody>';
        $htmlContent .= '<tr><th>Id Santri</th><td><span>' . $row['id'] . '</span></td></tr>';
        $htmlContent .= '<tr><th>Nama</th><td><span>' . $row['nama'] . '</span></td></tr>';
        $htmlContent .= '<tr><th>Kelas</th><td><div class="user-input"><span>' . $row['kls_din'] . ' ' . $row['jenjang_din'] . '</span><span class="ml-2"> | Domisili :</span><div class="select-container ml-3"><select><option value="' . $row['id'] . '">' . $domm . '</option></select></div></div></td></tr>';
        $htmlContent .= '<tr><th>Alamat</th><td><span>' . $row['dusun'] . ' ' . $row['desa'] . ' ' . $row['kecamatan'] . ' ' . '</span></td></tr>';
        $htmlContent .= '<tr><th>Wali</th><td><span>' . $row['ayah'] . '</span></td></tr>';
        $htmlContent .= '<tr><th>Total Tagihan</th><td>';
        $htmlContent .= '<span style="font-weight: bold;">Rp. ' . number_format($total, 0, ',', '.') . '</span>';
        $htmlContent .= '<div class="select-container ml-3"><select><option value="' . $r['id_spp'] . '">' . $r['name'] . '</option></select></div>';
        $htmlContent .= '<div class="select-container ml-3"><select><option value="' . $r['id_spp'] . '">' . $r['dom'] . '</option></select></div>';
        $htmlContent .= '</td></tr>';
        $htmlContent .= '<tr><th>Diskon %</th><td><input type="text" name="diskon-input" id="diskon-input" ' . $dis . '> %</td></tr>';
        $htmlContent .= '<tr><th>Pembayaran</th><td><input type="text" name="pembayaran" id="pembayaran"> <span id="sisa-pembayaran"> Sisa :  </span></td></tr>';
        $htmlContent .= '<tr><th>Kembali</th><td><span id="kembali"> </span></td></tr>';
        $htmlContent .= '<input type="hidden" name="id" value=' . $row['id'] . '>';
        $htmlContent .= '<input type="hidden" name="id_spp" value=' . $r['id_spp'] . '>';
        $htmlContent .= '<input type="hidden" name="id_pay" value=' . $id_pay . '>';
        $htmlContent .= '<input type="hidden" id="total-hidden" name="total" value="">';
        $htmlContent .= '<input type="hidden" id="sisa-hidden" name="sisa" value="">';
        $htmlContent .= '<input type="hidden" id="kembali-hidden" name="kembali" value="">';
        $htmlContent .= '</tbody>';

        echo $htmlContent;
    } else {
        die("Tidak ada data dengan ID $id_c");
    }
} else {
    die("Metode request tidak valid.");
}
$conn->close();
?>


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

    document.getElementById('pembayaran').addEventListener('keyup', function () {
        updateRupiahFormat('pembayaran');
    });
</script>
<script>
    $(document).ready(function () {
        function hapusFormatRupiah(input) {
            return input.replace(/[\D]/g, '');
        }

        function hitungSisa() {
            var total = <?php echo $total; ?>;
            var pembayaran = parseFloat(hapusFormatRupiah($("#pembayaran").val())) || 0;
            var diskon = parseFloat($("#diskon-input").val()) || 0;

            if (diskon > 0) {
                totalIn = total - (total * (diskon / 100));
            } else {
                totalIn = total
            }

            var totalSetelahDiskon = total - (total * (diskon / 100));
            var sisa = totalSetelahDiskon - pembayaran;

            var kembali = sisa < 0 ? Math.abs(sisa) : 0;
            if (pembayaran >= totalSetelahDiskon) {
                sisa = 0;
            }

            $("#total-hidden").val(totalIn);
            $("#sisa-hidden").val(sisa);
            $("#kembali-hidden").val(kembali);

            $("#sisa-pembayaran").text("Sisa: Rp. " + sisa.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'));
            $("#kembali").text("Rp. " + kembali.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'));
        }

        $("#pembayaran").on("input", function () {
            hitungSisa();
        });

        $("#diskon-input").on("input", function () {
            hitungSisa();
        });

        hitungSisa();
    });

</script>
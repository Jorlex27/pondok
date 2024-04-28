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

$pesan = isset($_GET['status']) ? $_GET['status'] : '';

$id_u = $_SESSION['id'];
$thn = $_SESSION['thn_ajaran'];

$md = $conn->query("SELECT name FROM master_data WHERE app_name IN ('sekretariat', 'diniyah') UNION
SELECT name FROM master_data WHERE name = 'TK'");
$s = $conn->query("SELECT thn_ajaran FROM nota GROUP BY thn_ajaran ORDER BY thn_ajaran DESC");
$h = $conn->query("SELECT h.*, u.name, s.nama, p1.payment as p1, p2.payment as p2
FROM history_pay as h 
inner join user as u on h.id_u = u.id
inner join santri as s on h.ids = s.ids
left join payments1 as p1 on h.id_pay1 = p1.id_pay
left join payments2 as p2 on h.id_pay2 = p2.id_pay
WHERE h.thn_ajaran = '$thn' order by tanggal DESC
");
?>
<link rel="stylesheet" href="../assets/css/bendahara.css">

<style>
    .table-header {
        position: sticky;
        top: 0;
        background-color: white;
    }
</style>
<!-- Insights -->
<div class="content">
    <main>
        <ul class="insights">
            <li>
                <div class="container">
                    <div class="head-history">
                        <i class='bx bx-history'></i>
                        <h1 class="m-6">History</h1>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr class="table-header">
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Pembayaran</th>
                                <th>Nominal</th>
                                <th>Penerima</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($h as $y) :
                                if ($y['jenis'] === 'Pertama') {
                                    $pp = number_format($y['p1'], 0, ',', '.');
                                } else {
                                    $pp = number_format($y['p2'], 0, ',', '.');
                                }
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $y['nama'] ?></td>
                                    <td><?php echo $y['jenis'] ?></td>
                                    <td>Rp. <?php echo $pp ?></td>
                                    <td><?php echo $y['name'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </li>
            <li>
                <div class="item select-container">
                    <select id="selector" style="text-align: center;">
                        <?php foreach ($s as $ss) :
                            $thn_ajaran = $ss['thn_ajaran'];
                        ?>
                            <option value="<?php echo $thn_ajaran ?>"><?php echo $thn_ajaran ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <canvas id="chart1"></canvas>
                <div class="data-item">
                    <div class="item">
                        <span class="barbar">h</span>
                        <div class="bar-item">
                            <span>Payments 1</span>
                            <span id="data-pay1"></span>
                        </div>
                    </div>
                    <div class="item">
                        <span class="barbar2">h</span>
                        <div class="bar-item">
                            <span>Payments 2</span>
                            <span id="data-pay2"></span>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item select-container">
                    <select id="selector2" style="text-align: center;">
                        <?php foreach ($md as $ss) : ?>
                            <option value="<?php echo $ss['name'] ?>"><?php echo $ss['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <canvas id="chart2"></canvas>
                <div class="data-item">
                    <div class="item">
                        <span class="barbar3">h</span>
                        <div class="bar-item">
                            <span>Lunas</span>
                            <span id="data-lunas"></span>
                        </div>
                    </div>
                    <div class="item">
                        <span class="barbar4">h</span>
                        <div class="bar-item">
                            <span>Belum Lunas</span>
                            <span id="data-belum"></span>
                        </div>
                    </div>
                    <div class="item">
                        <span class="barbar5">h</span>
                        <div class="bar-item">
                            <span>Tidak Bayar</span>
                            <span id="data-tidak"></span>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <!-- End of Insights -->

        <div class="bottom-data">

        </div>
    </main>
</div>

<?php
// require '../tem/foot.php';
// require '../helper/toastr.php';
?>
<script src="../assets/js/hed.js"></script>
<script src="../assets/js/script2.js"></script>
<script src="../assets/js/reminders.js"></script>
<script src="../assets/js/alert.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- <script>
    var chart3;
    var dataChart3 = {
        labels: ['Syawal', 'Dzul Qo`dah', 'Dzul Hijjah', 'Muharrom', 'Shofar', 'Robi`ul Awal' ],
        datasets: [{
            data: [170, 100, 200, 219, 300, 60],
            backgroundColor: ['#088395', '#35A29F', '#35A40F', '#29A98F']
        }]
    };

    var ctx2 = document.getElementById('chart3').getContext('2d');
    chart3 = new Chart(ctx2, {
        type: 'bar',
        data: dataChart3,
        options: {
            plugins: {
                legend: {
                    display: false,
                },
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';
                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '';
                        return label + ': ' + value;
                    }
                }
            }
        }
    });

    function updateChartAndData3(data) {
        chart3.data.labels = Object.keys(data);
        chart3.data.datasets[0].data = Object.values(data);
        chart3.update();
    }

    function fetchData3() {
        var selectedValue = document.getElementById('selector3').value;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../mod/bendum/getData3.php?selectedValue=' + selectedValue, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    var data = JSON.parse(xhr.responseText);

                    updateChartAndData3(data);
                } catch (error) {
                    console.error('Kesalahan dalam menguraikan data JSON: ' + error);
                }
            } else {
                console.error('Kesalahan saat mengambil data dari server.');
            }
        };

        xhr.send();
    }
</script> -->

<script>
    var chart1;
    var dataChart1 = {
        labels: ['Payments 1', 'Payments 2'],
        datasets: [{
            data: [170, 100],
            label: "Rp.",
            backgroundColor: ['#088395', '#35A29F']
        }]
    };

    var ctx2 = document.getElementById('chart1').getContext('2d');

    chart1 = new Chart(ctx2, {
        type: 'doughnut',
        data: dataChart1,
        options: {
            plugins: {
                legend: {
                    display: false,
                },
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';
                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '';
                        return label + value;
                    }
                }
            }
        }
    });

    var chart2;
    var dataChart2 = {
        labels: ['Lunas', 'Belum', 'Tidak'],
        datasets: [{
            data: [170, 70, 20],
            backgroundColor: ['#3A4D39', '#4F6F52', '#739072']
        }]
    };
    var ctx2 = document.getElementById('chart2').getContext('2d');
    chart2 = new Chart(ctx2, {
        type: 'doughnut',
        data: dataChart2,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';
                        var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] || '';
                        return label + ': ' + value;
                    }
                }
            }
        }
    });

    function updateChartAndData(data) {
        chart1.data.datasets[0].data = data;
        chart1.update();
        document.getElementById('data-pay1').textContent = formatRupiah(data[0]);
        document.getElementById('data-pay2').textContent = formatRupiah(data[1]);

    }

    function updateChartAndData2(data) {
        chart2.data.datasets[0].data = data;
        chart2.update();
        document.getElementById('data-lunas').textContent = data[0];
        document.getElementById('data-belum').textContent = data[1];
        document.getElementById('data-tidak').textContent = data[2];
    }

    function fetchData() {
        var selectedValue = document.getElementById('selector').value;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../mod/bendum/getData?selectedValue=' + selectedValue, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    var data = JSON.parse(xhr.responseText);

                    updateChartAndData([data.pay1, data.pay2]);
                } catch (error) {
                    console.error('Kesalahan dalam menguraikan data JSON: ' + error);
                }
            } else {
                console.error('Kesalahan saat mengambil data dari server.');
            }
        };

        xhr.send();
    }

    function fetchData2() {
        var thn_ajaran = document.getElementById('selector').value;
        var selectedValue = document.getElementById('selector2').value;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../mod/bendum/getData2?selectedValue=' + selectedValue + '&thn=' + thn_ajaran, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    var data = JSON.parse(xhr.responseText);

                    updateChartAndData2([data.sudah, data.belum, data.tidak]);
                } catch (error) {
                    console.error('Kesalahan dalam menguraikan data JSON: ' + error);
                }
            } else {
                console.error('Kesalahan saat mengambil data dari server.');
            }
        };

        xhr.send();
    }

    window.onload = function() {
        fetchData();
        fetchData2();
        // fetchData3();
    };

    document.getElementById('selector').addEventListener('change', fetchData);
    document.getElementById('selector2').addEventListener('change', fetchData2);
    // document.getElementById('selector3').addEventListener('change', fetchData3);


    function formatRupiah(angka) {
        var number_string = angka.toString();
        var sisa = number_string.length % 3;
        var rupiah = number_string.substr(0, sisa);
        var ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return "Rp. " + rupiah;
    }

    var angka1 = 50000;
    var angka2 = 1000000;

    var formatted1 = formatRupiah(angka1);
    var formatted2 = formatRupiah(angka2);

    console.log(formatted1); // Output: "Rp. 50.000"
    console.log(formatted2); // Output: "Rp. 1.000.000"
</script>

</body>

</html>
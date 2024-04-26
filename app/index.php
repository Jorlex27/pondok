<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../index.php');
}
$judul = "يَرْفَعِ اللَّهُ الَّذِينَ آمَنُوا مِنْكُمْ وَالَّذِينَ أُوتُوا الْعِلْمَ دَرَجَاتٍ";
require '../tem/head.php';
require '../tem/nav.php';
require '../tem/header.php';
require '../config/conn.php';
require '../helper/nb_i.php';
require '../helper/alert.php';

$pesan = isset($_GET['status']) ? $_GET['status'] : '';

$id_u = $_SESSION['id'];
$t = $conn->query("SELECT * FROM reminders WHERE id_u = '$id_u' ORDER BY tanggal, status ASC");
$s = $conn->query("SELECT name FROM master_data WHERE app_name IN ('sekretariat', 'diniyah', 'ammiyah')");
?>

<link rel="stylesheet" href="../assets/css/index.css">

<!-- Insights -->
<div class="content">
    <main>
        <ul class="insights">
            <li>
                <div class="item select-container">
                    <select id="selector">
                        <?php foreach ($s as $ss) : ?>
                            <option value="<?php echo $ss['name'] ?>"><?php echo $ss['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <canvas id="chart1"></canvas>
                <div class="item">
                    <span class="barbar">h</span>
                    <div class="bar-item">
                        <span>PPK</span>
                        <span id="data-ppk"></span>
                    </div>
                </div>
                <div class="item">
                    <span class="barbar2">h</span>
                    <div class="bar-item">
                        <span>LPPK</span>
                        <span id="data-lppk"></span>
                    </div>
                </div>
            </li>
            <li>
                <div class="item select-container">
                    <select id="selector2">
                        <?php foreach ($s as $ss) : ?>
                            <option value="<?php echo $ss['name'] ?>"><?php echo $ss['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <canvas id="chart2"></canvas>
                <div class="item">
                    <span class="barbar3">h</span>
                    <div class="bar-item">
                        <span>Banin</span>
                        <span id="data-banin"></span>
                    </div>
                </div>
                <div class="item">
                    <span class="barbar4">h</span>
                    <div class="bar-item">
                        <span>Banat</span>
                        <span id="data-banat"></span>
                    </div>
                </div>
            </li>
            <li>
                <span>بسم الله الرحمن الرحيم</span>
            </li>
        </ul>
        <!-- End of Insights -->

        <div class="bottom-data">
            <div class="orders">
                <div class="header">
                    <i class='bx bx-chart'></i>
                    <h3>Data Santri</h3>
                    <div class="item select-container">
                        <select id="selector3">
                            <option value="Diniyah">Diniyah</option>
                            <option value="Ammiyah">Ammiyah</option>
                        </select>
                    </div>
                </div>
                <div class="data-list">
                    <canvas id="chart3"></canvas>
                </div>
            </div>

            <!-- Reminders -->
            <div class="reminders">
                <div class="header">
                    <i class='bx bx-note'></i>
                    <h3>Reminders</h3>
                    <button type="button" id="toggle-button" class="btn btn-sm tombol"><i class='bx bx-plus'></i></button>
                </div>
                <div class="task-list">
                    <form action="../mod/setting/task.php" method="post" id="task-form">
                        <li class="not-completed">
                            <div class="task-title">
                                <input type="text" class="new-task-input-date" name="tanggal" id="datepicker"> |
                                <input type="text" class="new-task-input" id="input-task" name="task" placeholder="Enter a new task..." autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-sm"></button>
                            <button type="button" class="btn btn-sm tombol" id="icon-hapus"><i class='bx bx-minus-circle'></i></button>
                        </li>
                    </form>
                    <?php
                    foreach ($t as $r) :
                        $tanggl = $r['tanggal'];
                        $tanggalIndonesia = date("d", strtotime($tanggl)) . " " . $bulanIndonesia2[date("m", strtotime($tanggl))] . " " . date("Y", strtotime($tanggl));
                        if ($r['status'] == true) {
                            $tanda = 'completed';
                            $icon = 'bx-check-circle';
                        } else {
                            $tanda = 'not-completed';
                            $icon = 'bx-x-circle';
                        }
                    ?>
                        <li class="<?php echo $tanda; ?>">
                            <div class="task-title">
                                <button type="button" class="btn btn-sm tombol" onclick="sudah('sudah','<?php echo $r['id']; ?>')"><i class='bx <?php echo $icon; ?> x_icon'></i><i class='bx bx-check-circle check_icon'></i> </button>
                                <span><?php echo $tanggalIndonesia; ?></span>
                                <span><?php echo $r['task']; ?></span>
                            </div>
                            <button type="button" class="btn btn-sm tombol" onclick="sudah('hapus','<?php echo $r['id']; ?>')"><i class='bx bx-minus-circle delete-icon'></i></button>
                        </li>
                    <?php endforeach; ?>
                </div>
            </div>
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

<script>
    var chart3;
    var dataChart3 = {
        labels: ['Sekretariat', 'Sifir', 'PK', 'Pasca PK', 'IBT', 'Ts', 'MAD', ],
        datasets: [{
            data: [170, 100, 200, 219, 300, 60, 242],
            backgroundColor: ['#088395', '#35A29F', '#35A40F', '#29A98F', '#35F29F']
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
        xhr.open('GET', '../mod/app/getData3.php?selectedValue=' + selectedValue, true);

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
</script>

<script>
    var chart1;

    var dataChart1 = {
        labels: ['PPK', 'LPPK'],
        datasets: [{
            data: [170, 100],
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
                        return label + ': ' + value;
                    }
                }
            }
        }
    });

    var chart2;
    var dataChart2 = {
        labels: ['Banin', 'Banat'],
        datasets: [{
            data: [170, 70],
            backgroundColor: ['#e28743', '#eab676']
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
        document.getElementById('data-ppk').textContent = data[0];
        document.getElementById('data-lppk').textContent = data[1];
    }

    function updateChartAndData2(data) {
        chart2.data.datasets[0].data = data;
        chart2.update();
        document.getElementById('data-banin').textContent = data[0];
        document.getElementById('data-banat').textContent = data[1];
    }

    function fetchData() {
        var selectedValue = document.getElementById('selector').value;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../mod/app/getData?selectedValue=' + selectedValue, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    var data = JSON.parse(xhr.responseText);

                    updateChartAndData([data.ppk, data.lppk]);
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
        var selectedValue = document.getElementById('selector2').value;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../mod/app/getData2?selectedValue=' + selectedValue, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    var data = JSON.parse(xhr.responseText);

                    updateChartAndData2([data.banin, data.banat]);
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
        fetchData3();
    };

    document.getElementById('selector').addEventListener('change', fetchData);
    document.getElementById('selector2').addEventListener('change', fetchData2);
    document.getElementById('selector3').addEventListener('change', fetchData3);
</script>

</body>

</html>
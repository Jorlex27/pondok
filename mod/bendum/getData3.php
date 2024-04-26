    <?php
require __DIR__ . '/../../config/conn.php';
require __DIR__ . '/../../vendor/autoload.php';

$selectedValue = $_GET['selectedValue'];

date_default_timezone_set('Asia/Jakarta');
use GeniusTS\HijriDate\Hijri;

function convertToHijri($dateMasehi) {
    $hijri = Hijri::convertToHijri($dateMasehi);
    return $hijri->format('m Y');
}

$dateMasehiNow = date('Y-m-d');
$dateMasehi6MonthsAgo = date('Y-m-d', strtotime('-5 months', strtotime($dateMasehiNow)));

$months = array();

$currentDate = strtotime($dateMasehiNow);

while ($currentDate >= strtotime($dateMasehi6MonthsAgo)) {
    $bulanTahun = convertToHijri(date('Y-m-d', $currentDate));
    $months[] = $bulanTahun;
    $currentDate = strtotime('-1 month', $currentDate);
}

foreach ($months as $month) {
    list($bulan, $tahun) = explode(' ', $month);
    $bulanTahunArray[] = array('bulan' => $bulan, 'tahun' => $tahun);
}

$bulanHijri = array(
    "01" => "Muharrom",
    "02" => "Shofar",
    "03" => "Robi'ul Awal",
    "04" => "Robi'ul Akhir",
    "05" => "Jumadal Ula",
    "06" => "Jumadal Akhir",
    "07" => "Rojab",
    "08" => "Sya'ban",
    "09" => "Romadlan",
    "10" => "Syawal",
    "11" => "Dzul Qo'dah",
    "12" => "Dzul Hijjah"
);

$responseBulanan = array();
$responseBulanan2 = array();

foreach ($bulanTahunArray as $item) {
    $bulan = $item['bulan'];
    $tahun = $item['tahun'];

    $bulanHijriName = $bulanHijri[$bulan];

    $c = $conn->prepare("SELECT SUM(payment) as p1 FROM payments1 WHERE MONTH(thn_ajaran) = ?");
    $c->bind_param("i", $bulan);

    $c->execute();
    $result = $c->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        $totalPayment = $row['p1'];
    } else {
        $totalPayment = 0;
    }

    $responseBulanan[$bulanHijriName] = $totalPayment;

    $cc = $conn->prepare("SELECT SUM(payment) as p2 FROM payments2 WHERE MONTH(thn_ajaran) = ?");
    $cc->bind_param("i", $bulan);

    $cc->execute();
    $result2 = $cc->get_result();

    if ($result2) {
        $r = $result2->fetch_assoc();
        $totalPayment2 = $r['p2'];
    } else {
        $totalPayment2 = 0;
    }

    $responseBulanan2[$bulanHijriName] = $totalPayment2;
}


$jsonResponseBulanan = json_encode($responseBulanan);
$jsonResponseBulanan2 = json_encode($responseBulanan2);

// echo "Bulanan:\n";
// echo $jsonResponseBulanan;
// echo "\nTahunan:\n";
// echo $jsonResponseBulanan2;

if($selectedValue === "pay1"){
    $response = $jsonResponseBulanan;
}else{
    $response = $jsonResponseBulanan2;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
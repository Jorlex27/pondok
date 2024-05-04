<?php
use Ramsey\Uuid\Uuid;
use Respect\Validation\Rules\Length;

require __DIR__ . '/../vendor/autoload.php';
$host = "153.92.13.204";
$user = "u462981871_pondok";
$pass = "Norali12";
$database = "u462981871_pondokku";

$conn2 = mysqli_connect($host, $user, $pass, $database);
if (!$conn2) {
    die("Connection Failed:" . mysqli_connect_error());
}

// $host = "localhost";
// $user = "root";
// $pass = "";
// $database = "pondok_on";

// $conn2 = mysqli_connect($host, $user, $pass, $database);
// if (!$conn2) {
//   die("Connection Failed:" . mysqli_connect_error());
// }


$ids = '202404327';

/*
1. cek bedeh jek santrenah
*/

// ceksantri($ids, $conn2);

/*
2. hapusRegistrasi saja
*/

// hapusRegistrasi($ids, $conn2);

/*
3. hapus pembayaran dan data-nya
*/

// hapus($ids, $conn2);


function ceksantri($ids, $conn2)
{
    $a = $conn2->query("SELECT * FROM santri WHERE ids = '$ids'");

    if ($a->num_rows > 0) {
        echo "ada" . "\n";
    } else {
        echo "tadek";
    }
    foreach ($a as $row) {
        echo $row['nama'] . "\n";
        echo $row['gender'] . "\n";
        echo $row['dom'] . "\n";
    }
}

function hapus($ids, $conn2)
{
    try {
        // santri
        $s = $conn2->query("DELETE FROM santri WHERE ids = '$ids'");
        if (!$s) {
            throw new Exception("santri");
        }

        // payments1
        $d = $conn2->query("DELETE FROM payments1 WHERE ids = '$ids'");
        if (!$d) {
            throw new Exception("Payments1");
        }

        // nota
        $f = $conn2->query("DELETE FROM nota WHERE ids = '$ids'");
        if (!$f) {
            throw new Exception("nota");
        }

        // history_pay
        $c = $conn2->query("DELETE FROM history_pay WHERE ids = '$ids'");
        if (!$c) {
            throw new Exception("history");
        }

        echo "Yap";

    } catch (\Exception $e) {
        echo "NO" . $e->getMessage();
    }
}

function hapusRegistrasi($ids, $conn2)
{
    $s = $conn2->query("DELETE FROM registrasi WHERE id = '$ids'");
    if (!$s) {
        echo "Tak ning hapus";
    } else {
        echo "Mareh e hapus";
    }
}

// $idr = "d2d4a964-3107-42ea-9556-d8ca2bdc5c1c";

// $id_c = $idr;
// $sql = "SELECT * FROM registrasi WHERE id = ?";
// $stmt = $conn2->prepare($sql);
// $stmt->bind_param('i', $id_c);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();

//     echo $row['nama'] . "\n";
//     echo $row['gender'] . "\n";
//     echo $row['dom'] . "\n";

//     if ($row['jenjang_am'] === 'TK') {
//         $jenjang = $row['jenjang_am'];
//     } else {
//         $jenjang = $row['jenjang_din'];
//     }
//     $dom = $row['dom'];
//     $domm = (strpos(strtolower($dom), 'lppk') !== false) ? "LPPK" : "PPK";

//     $thn = "1445/1446";

//     $sp = $conn2->prepare("SELECT id_spp, name, jenjang, dom, total FROM spp WHERE jenis = 'baru' AND jenjang = ? AND dom = ? AND thn_ajaran = ?");
//     $sp->bind_param("sss", $jenjang, $domm, $thn);
//     $sp->execute();
//     $res = $sp->get_result();

//     if (!$sp) {
//         echo $conn2->error;
//     }

//     if ($res->num_rows > 0) {
//         $r = $res->fetch_assoc();
//         $total = $r['total'];
//         echo $total;
//     } else {
//         die("Tidak ada data billing.");
//     }
// } else {
//     die('Data registrasi tidak ditemukan.');
// }

function dataRegistrasi($conn2)
{
    $data = $conn2->query('SELECT * FROM registrasi')->fetch_all(MYSQLI_ASSOC);
    if (!$data) {
        return $conn2->error;
    }
    return $data;
}

function cekDataReg($id, $conn2)
{
    $data = $conn2->query("SELECT * FROM registrasi WHERE id = '$id'");
    if (!$data) {
        return $conn2->error;
    }
    return $data;
}

function deleteDataReg($id, $conn2)
{
    $d = $conn2->query("DELETE FROM registrasi WHERE id = '$id'");
    if (!$d) {
        return $conn2->error;
    }
    return "ok";
}

function updateDataReg($id, $conn2, $idB)
{
    $d = $conn2->query("UPDATE registrasi SET id = '$idB' WHERE id = '$id'");
    if (!$d) {
        return $conn2->error;
    }
    return "ok";
}

function updatePerDataReg($id, $conn2, $item, $itemBaru)
{
    $d = $conn2->query("UPDATE registrasi SET $item = '$itemBaru' WHERE id = '$id'");
    if (!$d) {
        return $conn2->error;
    }
    return "$item sudah di rubah ke $itemBaru";
}

// $data = dataRegistrasi($conn2);

// // echo '<pre>';
// // print_r($data);
// // echo '</pre>';

// foreach ($data as $row) {
//     echo $row['id']. "<br>";
//     // echo gettype(intval($row['id'])). "\n";
//     echo $row['nama']. "<br>";

// }

// echo count($data);

// echo deleteDataReg(1797220004198065, $conn2);

// echo updatePerDataReg("1797220122194811", $conn2, "dom", "LPPK");
// $dataR = cekDataReg("1797220122194811", $conn2)->fetch_assoc();

// echo '<pre>';
// print_r($dataR);
// echo '</pre>';


// $id = "1587945649854645";
// echo updateDataReg("d5bc5455-c8fe-4102-a0a1-eaeef4e4e1e4", $conn2, $id);

$thn = date("Y");
$month = date("m");
// echo substr($ids,4,2);
// echo $thn . "\n";
// echo $month . "\n";
// $c = $conn2->query("SELECT * FROM santri WHERE SUBSTRING(ids, 1, 4) = '$thn' AND SUBSTRING(ids, 4, 2) >= '$month'");

// if (!$c) {
//     echo "Error: " . $conn2->error;
// } else {
//     if ($c->num_rows > 0) {
//         while ($row = $c->fetch_assoc()) {
//             echo $row['ids'] . "\n";
//         }
//     } else {
//         echo "Tidak ada baris yang cocok dengan kriteria.";
//     }
// }


// $m_d = $conn2->query("SELECT id, name FROM master_data WHERE jenis = 'Diniyah' or name = 'TK'");
// $sp = $conn2->query("SELECT id_spp, name, jenjang FROM spp");
// $sans = $conn2->query("SELECT ids, nama, kls_din, jenjang_din, dom, no_kamar FROM santri");

// $no = 1;
// foreach ($sp as $spp):
//     echo $spp['id_spp'] . "\n";
//     echo $no++ . '. ' . $spp['name'];
// endforeach;

// foreach ($sans as $s) {
//     if ($s['dom'] != 'LPPK') {
//         $dom = 'PPK';
//     } else {
//         $dom = 'LPPK';
//     }

//     echo $s['kls_din'] . ' ' . $s['jenjang_din'] . "\n";
//     echo $s['nama'] . "\n";
//     echo $s['ids'] . "\n";
//     echo $s['ids'] . "\n";
// }

$id = [202404290, 202404343, 202404328];

foreach ($id as $i) {
    $dataS = cekDataSantri($i, $conn2)->fetch_assoc();
    echo "ID: " . $dataS['ids'] . ", Name: " . $dataS['nama']."<br>";
}

function cekDataSantri($id, $conn2)
{
    $data = $conn2->query("SELECT * FROM santri WHERE ids = '$id'");
    if (!$data) {
        return $conn2->error;
    }
    $out = $data->num_rows > 0 ? $data : "tidak ada data";
    return $out;
}

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
//     die("Connection Failed:" . mysqli_connect_error());
// }


$json_data = '[
    {
        "ids": 202305072,
        "nama": "MUSLIHAH",
        "kls_din": 1,
        "jenjang_din": "TSANAWIYAH",
        "dom": "AL-MALIKIYAH",
        "no_kamar": 3,
        "tahun_masuk": 2023,
        "no_kk": "3527142212110174",
        "nik": "352714450810000",
        "tempat_lahir": "SAMPANG",
        "tanggal": 5,
        "bulan": 8,
        "tahun": 2010,
        "gender": "WANITA",
        "agama": "ISLAM",
        "dusun": "NYEK-NYEK",
        "desa": "KARANGPENANG OLOH",
        "kecamatan": "KARANGPENANG",
        "kabupaten": "SAMPANG",
        "provinsi": "JAWA TIMUR",
        "anak_ke": 4,
        "jumlah_saudara": 4,
        "gol_darah": "O",
        "ayah": "MUDALI",
        "nik_a": "3527140406650002",
        "tl_a": "SAMPANG",
        "tgl_a": 4,
        "bulan_a": 6,
        "tahun_a": 1965,
        "pendidikan-a": "TAMAT SD",
        "pekerjaan_a": "PETANI",
        "ibu": "HAFIDAH",
        "nik_i": "3527145008690001",
        "tl_i": "SAMPANG",
        "tgl_i": 10,
        "bulan_i": 8,
        "tahun_i": 1969,
        "pendidikan_i": "TAMAT SD",
        "pekerjaan_i": "PETANI",
        "no_hp": "085336452883",
        "status": "AKTIF"
       },
       {
        "ids": "202305134",
        "nama": "SULAIMAH",
        "kls_din": 2,
        "jenjang_din": "TSANAWIYAH",
        "dom": "AL-MALIKIYAH",
        "no_kamar": 4,
        "tahun_masuk": 2023,
        "no_kk": "3527140310100179",
        "nik": "3527144708060001",
        "tempat_lahir": "SAMPANG",
        "tanggal": 7,
        "bulan": 8,
        "tahun": 2006,
        "gender": "WANITA",
        "agama": "ISLAM",
        "dusun": "ANGSANAH BARAT ",
        "desa": "TLAMBAH",
        "kecamatan": "KARANGPENANG",
        "kabupaten": "SAMPANG",
        "provinsi": "JAWA TIMUR",
        "anak_ke": 1,
        "jumlah_saudara": 2,
        "gol_a": "O",
        "ayah": "MOCH HASIB",
        "nik_a": "3527142108800003",
        "tl_a": "SAMPANG",
        "tgl_a": 21,
        "bulan_a": 8,
        "tahun_a": 1980,
        "pendidikan_a": "BELUM TAMAT SD",
        "pekerjaan_a": "PETANI",
        "ibu": "MUTIKAH",
        "nik_i": "3527146406850002",
        "tl_i": "SAMPANG",
        "tgl_i": 14,
        "bulan_i": 5,
        "tahun_i": 1985,
        "pendidikan_i": "BELUM TAMAT SD",
        "pekerjaan_i": "PETANI",
        "no_hp": "082333053003",
        "status": "AKTIF"
       },
    //    {
    //     "ids": "202405478",
    //     "nama": "MOH. WILDAN AFIF",
    //     "kelas_din": 1,
    //     "jenjang_din": "TSANAWIYAH",
    //     "dom": "PPK",
    //     "no_kamar": 0,
    //     "tahun_masuk": 2024,
    //     "no_kk": "3527111612150005",
    //     "nik": "3527113011100001",
    //     "tempat_lahir": "SAMPANG",
    //     "tanggal": 30,
    //     "bulan": 11,
    //     "tahun": 2010,
    //     "gender": "PRIA",
    //     "agama": "ISLAM",
    //     "dusun": "BUNGBEDUK",
    //     "desa": "TOBAI TENGAH",
    //     "kecamatan": "SOKOBANAH",
    //     "kabupaten": "SAMPANG",
    //     "provinsi": "JAWA TIMUR",
    //     "anak_ke": 2,
    //     "jumlah_saudara": 3,
    //     "gol_darah": "O",
    //     "ayah": "HANNAN",
    //     "nik_a": "3527112011790004",
    //     "tl_a": "SAMPANG",
    //     "tgl_a": 20,
    //     "bulan_a": 11,
    //     "tahun_a": 1979,
    //     "pendidikan_a": "SLTP\/SEDERAJAT",
    //     "pekerjaan-a": "KARIAWAN SWASTA",
    //     "ibu": "KUNTUM",
    //     "nik_i": "3527115607800001",
    //     "tl_i": "SAMPANG",
    //     "tgl_i": 16,
    //     "bulan_i": 7,
    //     "tahun_i": 1980,
    //     "pendidikan_i": "TAMAT SD",
    //     "pekerjaan_i": "KARIAWAN SWASTA",
    //     "no_hp": "085966555572",
    //     "status": "AKTIF"
    //    },
    //    {
    //     "ids": "202405461",
    //     "nama": "SYAMSUL ARIFIN",
    //     "kls_din": 1,
    //     "jenjang_din": "TSANAWIYAH",
    //     "dom": "PPK",
    //     "no_kamar": 0,
    //     "tahun_masuk": 2024,
    //     "no_kk": "3527112604180009",
    //     "nik": "3527110101110003",
    //     "tempat_lahir": "SAMPANG",
    //     "tanggal": 1,
    //     "bulan": 1,
    //     "tahun": 2011,
    //     "gender": "PRIA",
    //     "agama": "ISLAM",
    //     "dusun": "BUNGBEDUK",
    //     "desa": "TOBAI TENGAH",
    //     "kecamatan": "SOKOBANAH",
    //     "kabupaten": "SAMPANG",
    //     "provinsi": "JAWA TIMUR",
    //     "anak_ke": 1,
    //     "jumlah_saudara": 1,
    //     "gol_darah": "O",
    //     "ayah": "SYAIFUL",
    //     "nik_a": "3527112009780009",
    //     "tl_a": "SAMPANG",
    //     "tgl_a": 20,
    //     "bulan_a": 9,
    //     "tahun_a": 1978,
    //     "pendidikan_a": "BELUM TAMAT SD",
    //     "pekerjaan_a": "PETANI",
    //     "ibu": "NIPAH",
    //     "nik_i": "3527116909810003",
    //     "tl_i": "SAMPANG",
    //     "tgl_i": 29,
    //     "bulan_i": 9,
    //     "tahun_i": 1981,
    //     "pendidikan_i": "TAMAT SD",
    //     "pekerjaan_i": "WIRASWASTA",
    //     "no_hp": "083861506880",
    //     "status": "AKTIF"
    //    },
    //    {
    //     "ids": "202405462",
    //     "nama": "M. ALAIKAS SALAM",
    //     "jenjang_din": "SIFIR",
    //     "dom": "LPPK",
    //     "No_kamar": 0,
    //     "tahun_masuk": 2024,
    //     "no_kk": "3527140103190001",
    //     "nik": "3527141101180000",
    //     "tempat_lahir": "SAMPANG",
    //     "tanggal": 11,
    //     "bulan": 1,
    //     "tahun": 2018,
    //     "gender": "PRIA",
    //     "agama": "ISLAM",
    //     "dusun": "TLAMBAH TENGAH",
    //     "desa": "TLAMBAH",
    //     "kecamatan": "KARANGPENANG",
    //     "kabupaten": "SAMPANG",
    //     "provinsi": "JAWA TIMUR",
    //     "anak_ke": 1,
    //     "jumlah_saudara": 2,
    //     "gol_darah": "O",
    //     "ayah": "SIBLY",
    //     "nik_a": "3527140408880006",
    //     "tl_a": "SAMPANG",
    //     "tgl_a": 4,
    //     "bulan_a": 8,
    //     "tahun_a": 1988,
    //     "pendidikan_a": "TAMAT SD",
    //     "pekerjaan_a": "WIRASWASTA",
    //     "ibu": "FAUZAH",
    //     "nik_i": "3527145406910004",
    //     "tl_i": "SAMPANG",
    //     "tgl_i": 14,
    //     "bulan_i": 6,
    //     "tahun_i": 1991,
    //     "pendidikan_i": "SLTP\/SEDERAJAT",
    //     "pekerjaan_i": "MENGURUS RUMAH TANGGA",
    //     "no_hp": "081992032819",
    //     "status": "AKTIF"
    //    }
      ]';

$array_data = json_decode($json_data, true);

foreach ($array_data as $data) {
    $ids = $data['ids'];
    $nama = $data['nama'];
    $kls_din = $data['kls_din'];
    $jenjang_din = $data['jenjang_din'];
    $dom = $data['dom'];
    $no_kamar = $data['no_kamar'];
    $tahun_masuk = $data['tahun_masuk'];
    $no_kk = $data['no_kk'];
    $nik = $data['nik'];
    $tempat_lahir = $data['tempat_lahir'];
    $tanggal = $data['tanggal'];
    $bulan = $data['bulan'];
    $tahun = $data['tahun'];
    $gender = $data['gender'];
    $agama = $data['agama'];
    $dusun = $data['dusun'];
    $desa = $data['desa'];
    $kecamatan = $data['kecamatan'];
    $kabupaten = $data['kabupaten'];
    $provinsi = $data['provinsi'];
    $anak_ke = $data['anak_ke'];
    $jumlah_saudara = $data['jumlah_saudara'];
    $gol_darah = $data['gol_darah'];
    $ayah = $data['ayah'];
    $nik_a = $data['nik_a'];
    $tl_a = $data['tl_a'];
    $tgl_a = $data['tgl_a'];
    $bulan_a = $data['bulan_a'];
    $tahun_a = $data['tahun_a'];
    $pendidikan_a = $data['pendidikan_a'];
    $pekerjaan_a = $data['pekerjaan_a'];
    $ibu = $data['ibu'];
    $nik_i = $data['nik_i'];
    $tl_i = $data['tl_i'];
    $tgl_i = $data['tgl_i'];
    $bulan_i = $data['bulan_i'];
    $tahun_i = $data['tahun_i'];
    $pendidikan_i = $data['pendidikan_i'];
    $pekerjaan_i = $data['pekerjaan_i'];
    $no_hp = $data['no_hp'];
    $status = $data['status'];

    $insert = $conn2->query("INSERT INTO santri (ids, nama, kls_din, jenjang_din, dom, no_kamar, tahun_masuk, no_kk, nik, tempat_lahir, tanggal,
                bulan, tahun, gender, agama, dusun, desa, kecamatan, kabupaten, provinsi, anak_ke, jumlah_saudara, gol_darah, ayah, nik_a, tl_a, tgl_a, bulan_a, 
                tahun_a, pendidikan_a, pekerjaan_a, ibu, nik_i, tl_i, tgl_i, bulan_i, tahun_i, pendidikan_i, pekerjaan_i, no_hp, status)
                VALUES ('$ids', '$nama', '$kls_din', '$jenjang_din', '$dom', '$no_kamar', '$tahun_masuk', '$no_kk', '$nik', '$tempat_lahir', '$tanggal', 
                '$bulan', '$tahun', '$gender', '$agama', '$dusun', '$desa', '$kecamatan', '$kabupaten', '$provinsi', '$anak_ke', '$jumlah_saudara', 
                '$gol_darah', '$ayah', '$nik_a', '$tl_a', '$tgl_a', '$bulan_a', '$tahun_a', '$pendidikan_a', '$pekerjaan_a', '$ibu', '$nik_i', '$tl_i', 
                '$tgl_i', '$bulan_i', '$tahun_i', '$pendidikan_i', '$pekerjaan_i', '$no_hp', '$status')");
    echo 'ok >>>>' .$ids . "\n";
}


// print_r($array_data);

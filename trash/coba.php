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


$json_data = '[
    {

     "NIS": 202305072,
     "NAMA": "MUSLIHAH",
     "KELAS": 1,
     "JENJANG": "TSANAWIYAH",
     "DOMISILI": "AL-MALIKIYAH",
     "NO KAMAR": 3,
     "TAHUN MASUK": 2023,
     "NO. KK": "3527142212110174",
     "NIK SANTRI": "352714450810000",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 5,
     "BLN": 8,
     "THN": 2010,
     "JENIS KELAMIN": "WANITA",
     "AGAMA": "ISLAM",
     "DUSUN": "NYEK-NYEK",
     "DESA": "KARANGPENANG OLOH",
     "KECAMATAN": "KARANGPENANG",
     "KABUPATEN": "SAMPANG",
     "PROVINSI": "JAWA TIMUR",
     "ANAK KE": 4,
     "JUMLAH SAUDARA": 4,
     "GOL. DARAH": "O",
     "AYAH": "MUDALI",
     "NIK AYAH": "3527140406650002",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 4,
     "BLN": 6,
     "THN": 1965,
     "PENDIDIKAN TERAKHIR": "TAMAT SD",
     "PEKERJAAN": "PETANI",
     "IBU": "HAFIDAH",
     "NIK": "3527145008690001",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 10,
     "BLN": 8,
     "THN": 1969,
     "PENDIDIKAN TERAKHIR": "TAMAT SD",
     "PEKERJAAN": "PETANI",
     "NO HP": "085336452883",
     "STATUS": "AKTIF"
    },
    {
     "NO": 2,
     "NIS": "202305134",
     "NAMA": "SULAIMAH",
     "KELAS": 2,
     "JENJANG": "TSANAWIYAH",
     "DOMISILI": "AL-MALIKIYAH",
     "NO KAMAR": 4,
     "TAHUN MASUK": 2023,
     "NO. KK": "3527140310100179",
     "NIK SANTRI": "3527144708060001",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 7,
     "BLN": 8,
     "THN": 2006,
     "JENIS KELAMIN": "WANITA",
     "AGAMA": "ISLAM",
     "DUSUN": "ANGSANAH BARAT ",
     "DESA": "TLAMBAH",
     "KECAMATAN": "KARANGPENANG",
     "KABUPATEN": "SAMPANG",
     "PROVINSI": "JAWA TIMUR",
     "ANAK KE": 1,
     "JUMLAH SAUDARA": 2,
     "GOL. DARAH": "O",
     "AYAH": "MOCH HASIB",
     "NIK AYAH": "3527142108800003",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 21,
     "BLN": 8,
     "THN": 1980,
     "PENDIDIKAN TERAKHIR": "BELUM TAMAT SD",
     "PEKERJAAN": "PETANI",
     "IBU": "MUTIKAH",
     "NIK": "3527146406850002",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 14,
     "BLN": 5,
     "THN": 1985,
     "PENDIDIKAN TERAKHIR": "BELUM TAMAT SD",
     "PEKERJAAN": "PETANI",
     "NO HP": "082333053003",
     "STATUS": "AKTIF"
    },
    {
     "NO": 3,
     "NIS": "202405460",
     "NAMA": "MOH. WILDAN AFIF",
     "KELAS": 1,
     "JENJANG": "TSANAWIYAH",
     "DOMISILI": "PPK",
     "NO KAMAR": 0,
     "TAHUN MASUK": 2024,
     "NO. KK": "3527111612150005",
     "NIK SANTRI": "3527113011100001",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 30,
     "BLN": 11,
     "THN": 2010,
     "JENIS KELAMIN": "PRIA",
     "AGAMA": "ISLAM",
     "DUSUN": "BUNGBEDUK",
     "DESA": "TOBAI TENGAH",
     "KECAMATAN": "SOKOBANAH",
     "KABUPATEN": "SAMPANG",
     "PROVINSI": "JAWA TIMUR",
     "ANAK KE": 2,
     "JUMLAH SAUDARA": 3,
     "GOL. DARAH": "O",
     "AYAH": "HANNAN",
     "NIK AYAH": "3527112011790004",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 20,
     "BLN": 11,
     "THN": 1979,
     "PENDIDIKAN TERAKHIR": "SLTP\/SEDERAJAT",
     "PEKERJAAN": "KARIAWAN SWASTA",
     "IBU": "KUNTUM",
     "NIK": "3527115607800001",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 16,
     "BLN": 7,
     "THN": 1980,
     "PENDIDIKAN TERAKHIR": "TAMAT SD",
     "PEKERJAAN": "KARIAWAN SWASTA",
     "NO HP": "085966555572",
     "STATUS": "AKTIF"
    },
    {
     "NO": 4,
     "NIS": "202405461",
     "NAMA": "SYAMSUL ARIFIN",
     "KELAS": 1,
     "JENJANG": "TSANAWIYAH",
     "DOMISILI": "PPK",
     "NO KAMAR": 0,
     "TAHUN MASUK": 2024,
     "NO. KK": "3527112604180009",
     "NIK SANTRI": "3527110101110003",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 1,
     "BLN": 1,
     "THN": 2011,
     "JENIS KELAMIN": "PRIA",
     "AGAMA": "ISLAM",
     "DUSUN": "BUNGBEDUK",
     "DESA": "TOBAI TENGAH",
     "KECAMATAN": "SOKOBANAH",
     "KABUPATEN": "SAMPANG",
     "PROVINSI": "JAWA TIMUR",
     "ANAK KE": 1,
     "JUMLAH SAUDARA": 1,
     "GOL. DARAH": "O",
     "AYAH": "SYAIFUL",
     "NIK AYAH": "3527112009780009",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 20,
     "BLN": 9,
     "THN": 1978,
     "PENDIDIKAN TERAKHIR": "BELUM TAMAT SD",
     "PEKERJAAN": "PETANI",
     "IBU": "NIPAH",
     "NIK": "3527116909810003",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 29,
     "BLN": 9,
     "THN": 1981,
     "PENDIDIKAN TERAKHIR": "TAMAT SD",
     "PEKERJAAN": "WIRASWASTA",
     "NO HP": "083861506880",
     "STATUS": "AKTIF"
    },
    {
     "NO": 5,
     "NIS": "202405462",
     "NAMA": "M. ALAIKAS SALAM",
     "JENJANG": "SIFIR",
     "DOMISILI": "LPPK",
     "NO KAMAR": 0,
     "TAHUN MASUK": 2024,
     "NO. KK": "3527140103190001",
     "NIK SANTRI": "3527141101180000",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 11,
     "BLN": 1,
     "THN": 2018,
     "JENIS KELAMIN": "PRIA",
     "AGAMA": "ISLAM",
     "DUSUN": "TLAMBAH TENGAH",
     "DESA": "TLAMBAH",
     "KECAMATAN": "KARANGPENANG",
     "KABUPATEN": "SAMPANG",
     "PROVINSI": "JAWA TIMUR",
     "ANAK KE": 1,
     "JUMLAH SAUDARA": 2,
     "GOL. DARAH": "O",
     "AYAH": "SIBLY",
     "NIK AYAH": "3527140408880006",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 4,
     "BLN": 8,
     "THN": 1988,
     "PENDIDIKAN TERAKHIR": "TAMAT SD",
     "PEKERJAAN": "WIRASWASTA",
     "IBU": "FAUZAH",
     "NIK": "3527145406910004",
     "TEMPAT LAHIR": "SAMPANG",
     "TGL": 14,
     "BLN": 6,
     "THN": 1991,
     "PENDIDIKAN TERAKHIR": "SLTP\/SEDERAJAT",
     "PEKERJAAN": "MENGURUS RUMAH TANGGA",
     "NO HP": "081992032819",
     "STATUS": "AKTIF"
    }
   ]';

/*
<pre>Array
(
    [ids] => 202305158
    [id_d] => 0
    [id_d1] => 0
    [id_a] => 
    [id_m] => 0
    [nama] => ANIS
    [asal_sekolah] => 
    [jurusan_sekolah_asal] => 
    [npsn] => 0
    [nsm] => 0
    [nisn] => 0
    [tahun_masuk] => 2023
    [thn_masuk_d] => 
    [thn_masuk_a] => 
    [thn_masuk_m] => 
    [no_kk] => 3527112110190009
    [nik] => 3527115303100004
    [tempat_lahir] => SAMPANG
    [tanggal] => 13
    [bulan] => 3
    [tahun] => 2010
    [gender] => WANITA
    [agama] => ISLAM
    [dusun] => TOBINGKAR
    [desa] => TOBAIH TENGAN
    [kecamatan] => SOKOBANAH
    [kabupaten] => SAMPANG
    [provinsi] => JAWA TIMUR
    [kode_pos] => 
    [anak_ke] => 1
    [jumlah_saudara] => 2
    [gol_darah] => 
    [ayah] => HAKIP
    [status_a] => 
    [nik_a] => 3527111003802009
    [tl_a] => SAMPANG
    [tgl_a] => 10
    [bulan_a] => 3
    [tahun_a] => 1980
    [pendidikan_a] => BELUM TAMAT SD
    [pekerjaan_a] => PETANI
    [ibu] => HOSIAH
    [status_i] => 
    [nik_i] => 3527115705840005
    [tl_i] => SAMPANG
    [tgl_i] => 17
    [bulan_i] => 5
    [tahun_i] => 1984
    [pendidikan_i] => TAMAT SD
    [pekerjaan_i] => MENGURUS RUMAH TANGGA
    [kls_din] => 
    [jenjang_din] => PK
    [kls_am] => 
    [jenjang_am] => 
    [dom] => PK
    [no_kamar] => 
    [tlpn] => 
    [no_hp] => 083891024087
    [status_nikah] => 
    [email] => 
    [foto] => 
    [status] => AKTIF
*/

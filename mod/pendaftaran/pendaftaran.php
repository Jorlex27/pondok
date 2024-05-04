<?php

use Ramsey\Uuid\Uuid;
use Respect\Validation\Rules\Uppercase;

require __DIR__ . '../../../config/conn.php';
require __DIR__ . '../../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = array(
        'nama' => $_POST['nama'],
        'no_nik' => $_POST['no_nik'],
        'nisn' => $_POST['nisn'],
        'gender' => $_POST['gender'],
        'anak_ke' => $_POST['anak_ke'],
        'jumlah_saudara' => $_POST['jumlah_saudara'],
        'gol_darah' => $_POST['gol_darah'],
        'dom' => $_POST['dom'],
        'tempat_lahir' => $_POST['tempat_lahir'],
        'tanggal_lahir' => $_POST['tanggal_lahir'],
        'bulan_lahir' => $_POST['bulan_lahir'],
        'tahun_lahir' => $_POST['tahun_lahir'],
        'diniyah' => strtoupper($_POST['diniyah']),
        'kelas_din' => isset($_POST['kelas_din']) ? $_POST['kelas_din'] : '',
        'ammiyah' => strtoupper($_POST['ammiyah']),
        'kelas_am' => isset($_POST['kelas_am']) ? $_POST['kelas_am'] : '',
        'kk' => $_POST['kk'],
        'nik_ayah' => $_POST['nik_ayah'],
        'nama_ayah' => $_POST['nama_ayah'],
        'tempat_lahir_ayah' => $_POST['tempat_lahir_ayah'],
        'tanggal_lahir_ayah' => $_POST['tanggal_lahir_ayah'],
        'bulan_lahir_ayah' => $_POST['bulan_lahir_ayah'],
        'tahun_lahir_ayah' => $_POST['tahun_lahir_ayah'],
        'pekerjaan_ayah' => $_POST['pekerjaan_ayah'],
        'pendidikan_ayah' => $_POST['pendidikan_ayah'],
        'nik_ibu' => $_POST['nik_ibu'],
        'nama_ibu' => $_POST['nama_ibu'],
        'tempat_lahir_ibu' => $_POST['tempat_lahir_ibu'],
        'tanggal_lahir_ibu' => $_POST['tanggal_lahir_ibu'],
        'bulan_lahir_ibu' => $_POST['bulan_lahir_ibu'],
        'tahun_lahir_ibu' => $_POST['tahun_lahir_ibu'],
        'pekerjaan_ibu' => $_POST['pekerjaan_ibu'],
        'pendidikan_ibu' => $_POST['pendidikan_ibu'],
        'dusun' => $_POST['dusun'],
        'desa' => $_POST['desa'],
        'kecamatan' => $_POST['kecamatan'],
        'kabupaten' => $_POST['kabupaten'],
        'provinsi' => $_POST['provinsi'],
        'no_hp' => $_POST['no_hp']
    );

    try {
        $id = uniqid();
        $id = hexdec($id);
        $id = str_pad($id, 10, "0", STR_PAD_LEFT);
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO registrasi (id, nama, nik, nisn, gender, anak_ke, jumlah_saudara, gol_darah, dom, tempat_lahir, tanggal, bulan, tahun, jenjang_din, kls_din, jenjang_am, kls_am, no_kk, nik_a, ayah, tl_a, tgl_a, bulan_a, tahun_a, pekerjaan_a, pendidikan_a, nik_i, ibu, tl_i, tgl_i, bulan_i, tahun_i, pekerjaan_i, pendidikan_i, dusun, desa, kecamatan, kabupaten, provinsi, no_hp, tanggal_reg)
        VALUES ('$id', '{$data['nama']}', '{$data['no_nik']}', '{$data['nisn']}', '{$data['gender']}', '{$data['anak_ke']}', '{$data['jumlah_saudara']}', '{$data['gol_darah']}', '{$data['dom']}', '{$data['tempat_lahir']}', '{$data['tanggal_lahir']}', '{$data['bulan_lahir']}', '{$data['tahun_lahir']}', '{$data['diniyah']}', '{$data['kelas_din']}', '{$data['ammiyah']}', '{$data['kelas_am']}', '{$data['kk']}', '{$data['nik_ayah']}', '{$data['nama_ayah']}', '{$data['tempat_lahir_ayah']}', '{$data['tanggal_lahir_ayah']}', '{$data['bulan_lahir_ayah']}', '{$data['tahun_lahir_ayah']}', '{$data['pekerjaan_ayah']}', '{$data['pendidikan_ayah']}', '{$data['nik_ibu']}', '{$data['nama_ibu']}', '{$data['tempat_lahir_ibu']}', '{$data['tanggal_lahir_ibu']}', '{$data['bulan_lahir_ibu']}', '{$data['tahun_lahir_ibu']}', '{$data['pekerjaan_ibu']}', '{$data['pendidikan_ibu']}', '{$data['dusun']}', '{$data['desa']}', '{$data['kecamatan']}', '{$data['kabupaten']}', '{$data['provinsi']}', '{$data['no_hp']}', '$date')";

        if ($conn->query($sql) === TRUE) {
            $response = array("status" => "success", "message" => "Formulir berhasil dikirim", "id" => $id);
        } else {
            $response = array("status" => "error", "message" => "Terjadi kesalahan saat menambahkan data ke tabel registrasi: " . $conn->error);
        }

        $conn->close();
    } catch (Exception $e) {
        $response = array("status" => "error", "message" => "Terjadi kesalahan: " . $e->getMessage());
    }

    echo json_encode($response);
}


?>

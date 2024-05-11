<?php

require "conn.php";
function updatePerDataSantri($id, $conn2, $item, $itemBaru){
    $d = $conn2->query("UPDATE santri SET $item = '$itemBaru' WHERE ids = '$id'");
    if (!$d) {
        return $conn2->error;
    }
    return "$item sudah di rubah ke $itemBaru";
}


echo updatePerDataSantri("2022050082", $conn2, "jenjang_din", "TSANAWIYAH");


/*
Array
(
    [ids] => 2022050145
    [id_d] => 0
    [id_d1] => 0
    [id_a] => 
    [id_m] => 0
    [nama] => KASUMATUS SOLIHA
    [asal_sekolah] => 
    [jurusan_sekolah_asal] => 
    [npsn] => 0
    [nsm] => 0
    [nisn] => 0
    [tahun_masuk] => 
    [thn_masuk_d] => 
    [thn_masuk_a] => 
    [thn_masuk_m] => 
    [no_kk] => 
    [nik] => 
    [tempat_lahir] => SAMPANG
    [tanggal] => 8
    [bulan] => 9
    [tahun] => 2003
    [gender] => WANITA
    [agama] => ISLAM
    [dusun] => PROBUNGAN
    [desa] => LEPELLE
    [kecamatan] => ROBATAL
    [kabupaten] => SAMPANG
    [provinsi] => JAWA TIMUR
    [kode_pos] => 
    [anak_ke] => 0
    [jumlah_saudara] => 0
    [gol_darah] => 
    [ayah] => ALM.MUDIN
    [status_a] => 
    [nik_a] => 
    [tl_a] => 
    [tgl_a] => 0
    [bulan_a] => 0
    [tahun_a] => 0
    [pendidikan_a] => 
    [pekerjaan_a] => 
    [ibu] => DJAMINA
    [status_i] => 
    [nik_i] => 
    [tl_i] => 
    [tgl_i] => 0
    [bulan_i] => 0
    [tahun_i] => 0
    [pendidikan_i] => 
    [pekerjaan_i] => 
    [kls_din] => 3
    [jenjang_din] => TSANAWIYAH
    [kls_am] => 
    [jenjang_am] => 
    [dom] => AS-SYAFI'IYAH
    [no_kamar] => 02
    [tlpn] => 
    [no_hp] => '6287838022225
    [status_nikah] => 
    [email] => 
    [foto] => 
    [status] => AKTIF
)
*/
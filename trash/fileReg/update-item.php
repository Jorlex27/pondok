<?php

require "conn.php";
function updatePerDataReg($id, $conn2, $item, $itemBaru){
    $d = $conn2->query("UPDATE registrasi SET $item = '$itemBaru' WHERE id = '$id'");
    if (!$d) {
        return $conn2->error;
    }
    return "$item sudah di rubah ke $itemBaru";
}

echo updatePerDataReg("1797474525354561", $conn2, "dusun", "TANAONG");

/*
Array
(
    [id] => 1797220122194811
    [nama] => COBA
    [nisn] => 
    [no_kk] => 12454
    [nik] => 1234
    [tempat_lahir] => LJLJL
    [tanggal] => 2
    [bulan] => 3
    [tahun] => 4
    [gender] => 
    [dusun] => HHJHJH
    [desa] => MBBMN
    [kecamatan] => BNMBM
    [kabupaten] => MNBN
    [provinsi] => NBNMB
    [kode_pos] => 
    [anak_ke] => 1
    [jumlah_saudara] => 1
    [gol_darah] => 
    [ayah] => KKKL
    [status_a] => 
    [nik_a] => 2356
    [tl_a] => HGJHGJ
    [tgl_a] => 1
    [bulan_a] => 2
    [tahun_a] => 1
    [pendidikan_a] => JHKHJK
    [pekerjaan_a] => 212KJHJHJK
    [ibu] => 123456
    [status_i] => 
    [nik_i] => 1221212
    [tl_i] => HGHGHG
    [tgl_i] => 1
    [bulan_i] => 2
    [tahun_i] => 3
    [pendidikan_i] => JHJJH
    [pekerjaan_i] => 12JKKH
    [kls_din] => 
    [jenjang_din] => SHIFIR
    [kls_am] => 
    [jenjang_am] => TK
    [dom] => L
    [no_kamar] => 
    [no_hp] => 08121231545
    [foto] => 
    [status] => 
    [tanggal_reg] => 2024-04-24 12:44:31
)
*/
<?php
require __DIR__ . '/../../config/conn.php';

$selectedValue = $_GET['selectedValue'];

$sql = "SELECT
    COUNT(ids) AS total_santri,
    SUM(CASE WHEN jenjang_din like '%sifir%' and gender like '%pria%' THEN 1 ELSE 0 END) AS sifir_l,
    SUM(CASE WHEN jenjang_din like '%ibtidaiyah%' and gender like '%pria%' THEN 1 ELSE 0 END) AS ibt_l,
    SUM(CASE WHEN jenjang_din LIKE '%tsanawiyah%' and gender like '%pria%' THEN 1 ELSE 0 END) AS ts_l,
    SUM(CASE WHEN jenjang_din LIKE '%aliyah%' and gender like '%pria%' THEN 1 ELSE 0 END) AS mad_l,
    SUM(CASE WHEN jenjang_din LIKE '%pk%' and gender like '%pria%' THEN 1 ELSE 0 END) AS pk_l,
    SUM(CASE WHEN jenjang_din LIKE '%pasca%' and gender like '%pria%' THEN 1 ELSE 0 END) AS pasca_l,
    SUM(CASE WHEN jenjang_am LIKE '%tk%' and gender like '%pria%' THEN 1 ELSE 0 END) AS tk_l,
    SUM(CASE WHEN jenjang_am LIKE '%mi%' and gender like '%pria%' THEN 1 ELSE 0 END) AS mi_l,
    SUM(CASE WHEN jenjang_am LIKE '%mts%' and gender like '%pria%' THEN 1 ELSE 0 END) AS mts_l,
    SUM(CASE WHEN jenjang_am LIKE '%smp%' and gender like '%pria%' THEN 1 ELSE 0 END) AS smp_l,
    SUM(CASE WHEN jenjang_am LIKE '%ma%' and gender like '%pria%' THEN 1 ELSE 0 END) AS ma_l,
    SUM(CASE WHEN jenjang_am LIKE '%smk%' and gender like '%pria%' THEN 1 ELSE 0 END) AS smk_l,
    SUM(CASE WHEN jenjang_am LIKE '%mahasiswa%' and gender like '%pria%' THEN 1 ELSE 0 END) AS mahasiswa_l,
    SUM(CASE WHEN jenjang_din like '%sifir%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS sifir_p,
    SUM(CASE WHEN jenjang_din like '%ibtidaiyah%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS ibt_p,
    SUM(CASE WHEN jenjang_din LIKE '%tsanawiyah%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS ts_p,
    SUM(CASE WHEN jenjang_din LIKE '%aliyah%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS mad_p,
    SUM(CASE WHEN jenjang_din LIKE '%pk%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS pk_p,
    SUM(CASE WHEN jenjang_din LIKE '%pasca%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS pasca_p,
    SUM(CASE WHEN jenjang_am LIKE '%tk%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS tk_p,
    SUM(CASE WHEN jenjang_am LIKE '%mi%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS mi_p,
    SUM(CASE WHEN jenjang_am LIKE '%mts%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS mts_p,
    SUM(CASE WHEN jenjang_am LIKE '%smp%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS smp_p,
    SUM(CASE WHEN jenjang_am LIKE '%ma%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS ma_p,
    SUM(CASE WHEN jenjang_am LIKE '%smk%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS smk_p,
    SUM(CASE WHEN jenjang_am LIKE '%mahasiswa%' and gender like '%wanita%' THEN 1 ELSE 0 END) AS mahasiswa_p
    FROM santri WHERE status = 'Aktif';
";

$result = $conn->query($sql);

if ($result) {
    $data = $result->fetch_assoc();
    if ($selectedValue == 'Diniyah') {
        $response = array(
            'Sekretaraiat' => $data['total_santri'],
            'Sifir L' => $data['sifir_l'],
            'Sifir P' => $data['sifir_p'],
            'PK L' => $data['pk_l'],
            'PK P' => $data['pk_p'],
            'Pasca PK L' => $data['pasca_l'],
            'Pasca PK P' => $data['pasca_p'],
            'IBT L' => $data['ibt_l'],
            'IBT P' => $data['ibt_p'],
            'Ts L' => $data['ts_l'],
            'Ts P' => $data['ts_p'],
            'MAD L' => $data['mad_l'],
            'MAD P' => $data['mad_p']
        );
    } else {
        $response = array(
            'TK L' => $data['tk_l'],
            'TK P' => $data['tk_p'],
            'MI L' => $data['mi_l'],
            'MI P' => $data['mi_p'],
            'MTs L' => $data['mts_l'],
            'MTs P' => $data['mts_p'],
            'SMP L' => $data['smp_l'],
            'SMP P' => $data['smp_p'],
            'MA L' => $data['ma_l'],
            'MA P' => $data['ma_p'],
            'SMK L' => $data['smk_l'],
            'SMK P' => $data['smk_p'],
            'Mahasiswa L' => $data['mahasiswa_l'],
            'Mahasiswa P' => $data['mahasiswa_p']
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo "Kesalahan dalam mengambil data dari database.";
}


$conn->close();

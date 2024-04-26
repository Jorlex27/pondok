<?php
$result = $conn->query("SELECT ru.id_r, r.name as jabatan, m.name as apps, u.id as id_u, u.username, u.name as u_name
FROM user as u
left join role_u As ru on u.id = ru.id_u
left join role as r on ru.id_r = r.id
left join app as a on u.id = a.id_u
left join master_data as m on a.id_md = m.id
");
// if (!$result) {
//     echo $conn->error;
// }
$dataByRole = array();
while ($row = $result->fetch_assoc()) {
    $id_u = $row['id_u'];
    $id_r = $row['id_r'];
    $uname = $row['username'];
    $u_name = $row['u_name'];
    $jabatan = $row['jabatan'];
    $apps = $row['apps'];
    if (!isset($dataByRole[$id_u])) {
        $dataByRole[$id_u] = array(
            'id_u' => $id_u,
            'id_r' => $id_r,
            'username' => $uname,
            'u_name' => $u_name,
            'jabatan' => $jabatan,
            'jabatan' => array(),
            'apps' => array(),
        );
    }
    $jabatanUnique = array();
    $appsUnique = array();

    foreach ($dataByRole[$id_u]['jabatan'] as $existingJabatan) {
        $jabatanUnique[$existingJabatan] = true;
    }

    foreach ($dataByRole[$id_u]['apps'] as $existingApps) {
        $appsUnique[$existingApps] = true;
    }

    if (!isset($jabatanUnique[$jabatan])) {
        $dataByRole[$id_u]['jabatan'][] = $jabatan;
    }

    if (!isset($appsUnique[$apps])) {
        $dataByRole[$id_u]['apps'][] = $apps;
    }
}

$j = $conn->query("SELECT * FROM role");
$role = array();
while ($r = $j->fetch_assoc()) {
    $role[] = $r;
}
$role_json = json_encode($role);

$m = $conn->query("SELECT id, name FROM master_data WHERE name NOT IN ('jabatan', 'Admin')");
$data = array();
while ($row = $m->fetch_assoc()) {
    $data[] = $row;
}
$data_json = json_encode($data);

?>
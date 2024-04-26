<?php
require '../config/conn.php';
$id_u = $_SESSION['id'];
$role = $_SESSION['role'];
$role_array = array(
  'Bendahara Umum',
  'Wakil Bendahara Umum I',
  'Wakil Bendahara Umum II',
  'Bendahara Banat'
);
if (in_array($role, $role_array)) {
  $home = "../bendahara/bendahara";
} else {
  $home = "../app/";
}

$queryJenis = "SELECT DISTINCT m.jenis
              FROM app as a
              INNER JOIN master_data as m ON a.id_md = m.id
              WHERE a.id_u = '$id_u'
              ORDER BY m.id";

$resultJenis = $conn->query($queryJenis);
$appJenis = array();

while ($rowJenis = $resultJenis->fetch_assoc()) {
  $jenis = $rowJenis['jenis'];
  $queryData = "SELECT m.id, m.app_name as apps, m.link, m.name, m.kolom
                  FROM app as a
                  INNER JOIN master_data as m ON a.id_md = m.id
                  WHERE a.id_u = '$id_u' AND m.jenis = '$jenis'
                  ORDER BY m.id ASC";

  $resultData = $conn->query($queryData);
  $hasilJenisIni = array();

  while ($rowData = $resultData->fetch_assoc()) {
    $hasilJenisIni[] = $rowData;
  }

  $appJenis[$jenis] = $hasilJenisIni;
}

?>
<style>

</style>

<body>
  <div class="sidebar close">
    <div class="logo-details">
      <img src="../assets/images/pondok.png" alt="">
      <!-- <i class='bx bxl-airbnb'></i> -->
      <span class="logo_name">Karangdurin</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="<?php echo $home ?>">
          <i class='bx bx-grid-alt'></i>
          <span class="link_name">Home</span>
        </a>
        <ul class="sub-menu ">
          <li><a class="link_name" href="<?php echo $home ?>">Home</a></li>
        </ul>
      </li>
      <?php foreach ($appJenis as $jenis => $hasil) { ?>
        <li>
          <div class="icon-link">
            <a>
              <?php
              $jenis_icons = [
                'Diniyah' => ['icon' => 'bx bxs-data', 'text' => 'Madrosiah'],
                'Ammiyah' => ['icon' => 'bx bx-data', 'text' => 'Ammiyah'],
                'Sekretariat' => ['icon' => 'bx bx-home', 'text' => 'Sekretariat'],
                'Setting' => ['icon' => 'bx bx-cog', 'text' => 'Setting'],
                'History' => ['icon' => 'bx bx-history', 'text' => 'History'],
                'Bendahara' => ['icon' => 'bx bx-wallet', 'text' => 'Bendahara'],
                'Registrasi' => ['icon' => 'bx bxs-user-plus', 'text' => 'Registrasi'],
                'Komisi 1' => ['icon' => 'bx bxl-microsoft', 'text' => 'Daerah A'],
              ];

              if (isset($jenis_icons[$jenis])) {
                $icon_class = $jenis_icons[$jenis]['icon'];
                $text = $jenis_icons[$jenis]['text'];

                echo "<i class='$icon_class'></i>";
                echo "<span class='link_name'>$text</span>";
              }
              ?>
            </a>
            <i class='bx bxs-chevron-down arrow'></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name menu-item" href="#"><?php echo $jenis; ?></a></li>
            <?php foreach ($hasil as $w) { ?>
              <li><a
                  href="../<?php echo $w['link']; ?>/<?php echo $w['apps']; ?>?Apdata=<?php echo $w['name'] ?>"><?php echo $w['name'] ?></a>
              </li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>
    </ul>
  </div>
</body>
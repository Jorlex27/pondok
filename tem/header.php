<?php
require '../config/conn.php';
$id_u = $_SESSION['id'];
$g = $conn->prepare("SELECT u.name, p.foto FROM user as u left join pengurus as p on u.id_p = p.id_p WHERE u.id = ? ");
$g->bind_param("i", $id_u);
$g->execute();
$rg = $g->get_result();

if ($rg) {
  $data = $rg->fetch_assoc();
  $name = $data['name'];
  $foto = $data['foto'];
}
?>

<link rel="stylesheet" href="../assets/css/loading.css">
<div class="loading-container" id="loader">
  <div class="loading"></div>
</div>

<script>
  var loader = document.getElementById("loader");
  var menuItems = document.querySelectorAll(".menu-item");
  window.addEventListener("load", function() {
    loader.style.display = "none";
  })
</script>

<section class="home-section">
  <header class="cool-header">
    <i class='bx bx-menu'></i>
    <div class="home-content">
      <i class="iconmonstr-menu"></i>
      <?php
      $Apdata = isset($_GET['Apdata']) ? $_GET['Apdata'] : '';
      if (basename($_SERVER['PHP_SELF']) === 'index') {
        $j_baru = "dashboard";
        $judul = "يَرْفَعِ اللَّهُ الَّذِينَ آمَنُوا مِنْكُمْ وَالَّذِينَ أُوتُوا الْعِلْمَ دَرَجَاتٍ";
      } else {
        $j_baru = "text";
        $judul = $Apdata;
      }
      ?>
      <span class="<?php echo $j_baru; ?>"><?php echo $judul; ?></span>
    </div>
    <div class="profile">
      <div class="detail">
        <span><?php echo $name; ?></span>
        <span><?php echo $_SESSION['role']; ?></span>
      </div>
      <div class="profile-dropdown">
        <img src="../assets/uploads/pengurus/<?php echo $foto; ?>" alt="../assets/images/profile-1.jpg" id="profileImage">
        <div class="dropdown-content" id="dropdownContent">
          <div class="item">
            <a href="../login/profile?Apdata=Profile">
              <i class='bx bxs-user-detail'></i>
              <span class="link_name">Profile</span>
            </a>
            <a href="../login/logout.php">
              <i class='bx bx-log-out'></i>
              <span class="link_name">Keluar</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="halaman-utama">
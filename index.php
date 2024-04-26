<?php
require './config/conn.php';
if (isset($_POST['submit'])) {
  $user = $_POST['username'];
  $pw = $_POST['password'];

  $stmt = $conn->prepare("SELECT r.name as jabatan, r.gender, u.id as id_u, u.username, u.name as u_name, u.password
    FROM user as u
    left join role_u As ru on u.id = ru.id_u
    left join role as r on ru.id_r = r.id
    left join pengurus as p on u.id_p = p.id_p
    WHERE u.username = ?");
  $stmt->bind_param("s", $user);
  $stmt->execute();
  $result = $stmt->get_result();

  $th = $conn->prepare("SELECT thn from thn_ajaran");
  $th->execute();
  $res = $th->get_result();
  $row = $res->fetch_assoc();
  $thn = $row['thn'];

  if ($result->num_rows > 0) {
    $a = $result->fetch_assoc();
    if (password_verify($pw, $a['password'])) {
      session_start();
      $_SESSION['username'] = $a['username'];
      $_SESSION['name'] = $a['u_name'];
      $_SESSION['id'] = $a['id_u'];
      $_SESSION['role'] = $a['jabatan'];
      $_SESSION['gender'] = $a['gender'];
      $_SESSION['ket'] = $a['ket'];
      $_SESSION['thn_ajaran'] = $thn;
      $_SESSION['login'] = true;

      $role_array = array(
        'Bendahara Umum', 'Wakil Bendahara Umum I', 'Wakil Bendahara Umum II', 'Bendahara Banat'
      );
      if(in_array($_SESSION['role'], $role_array)){
        $home = "./bendahara/bendahara";
      }else{
        $home = "./app";
      }
      header('Location: '.$home.'');
      exit;
    } else {
      header("Location: index?status=pw");
      exit;
    }
  } else {
    header("Location: index?status=nouser");
    exit;
  }
}
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
  header('Location: ./app');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/login.css">
  <link rel="stylesheet" href="./assets/toastr-2.1.1/build/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./assets/toastr-2.1.1/build/toastr.min.js"></script>
  <title>Login</title>
</head>
<body>
  <div class="login-container">
    <div class="logo">
      <img src="./assets/images/pondok.png" alt="Logo">
    </div>
    <div class="login-form">
      <h2>Login</h2>
      <form method="post">
        <input type="text" class="form-control" id="username" name="username" placeholder="username" autofocus required autocomplete="nope" />
        <input type="password" class="form-control" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required autocomplete="nope" />
        <button type="submit" name="submit">Login</button>
      </form>
    </div>
  </div>

  <script>
    var urlParams = new URLSearchParams(window.location.search);
    var statusParam = urlParams.get('status');

    if (statusParam === 'nouser') {
      toastr.error('Username tidak ada');
    } else if (statusParam === 'pw') {
      toastr.error('Password salah')
    }
  </script>
</body>

</html>
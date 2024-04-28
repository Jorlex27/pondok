<?php
session_start();
session_unset();
setcookie('session_token', '', time() - 3600, '/');
session_destroy();
header('Location: ../index');
exit;
?>

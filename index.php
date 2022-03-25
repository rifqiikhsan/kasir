<?php
if(empty($err)){
    $_SESSION['admin_username'] = $username;
    $_SESSION['admin_akses'] = $akses;
    header("location:admin_depan.php");
    exit();
}
session_start();
session_destroy();
header("location:login.php");
?>
<?php
session_start();
include ("inc_koneksi.php");
if(!isset($_SESSION['admin_username'])){
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Halaman Depan</title>
</head>
<body>
    <section id="navbar">
    <div class="container">
        <nav>
            <h1>HALAMAN DEPAN/</h1>
            <ul>
                <li><a href="admin_depan.php">HALAMAN DEPAN</a></li>
                
                <?php if(in_array("admin", $_SESSION['admin_akses'])) { ?>
                <li><a href="admin/index.php">HALAMAN ADMIN</a></li>
                <?php } ?>
                <?php if(in_array("kasir", $_SESSION['admin_akses'])) { ?>
                <li><a href="kasir/index.php">HALAMAN KASIR</a></li>
                <?php } ?>
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </nav>
 </section>

 <section id="kelompok">
     <div class="container">
         <h2 class="judul">APLIKASI KASIR RUMAH MAKAN</h2>
         <img class="pp" src="img/logo.jpg">
         <h2>KELOMPOK 1 XI RPL 1</h2>
         <h3>Anggota : </h3>
         <p>-Rifqi ikhsan rizkillah</p>
         <p>-Nindya dwi lestari</p>
         <p>-Siti nurlela</p>
         <p>-Willy ramadhan</p>
     </div>
 </section>
</body>
</html>

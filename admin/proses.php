<?php
// Load file koneksi.php
include "../inc_koneksi.php";

// Ambil Data yang Dikirim dari Form
$namaproduk = $_POST['namaproduk'];
$deskripsi = $_POST['deskripsi'];
$stock = $_POST['stock'];
$harga = $_POST['harga'];
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];

// Rename nama fotonya dengan menambahkan tanggal dan jam upload


// Set path folder tempat menyimpan fotonya
$path = "images/".$foto;

// Proses upload
if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
  // Proses simpan ke Database

  $sql = mysqli_query($koneksi,"insert into produk(namaproduk,deskripsi,harga,stock,foto) values ('$namaproduk','$deskripsi','$harga','$stock','$foto')");

  if($sql){ // Cek jika proses simpan ke database sukses atau tidak
    // Jika Sukses, Lakukan :
    header("location: stock.php"); // Redirect ke halaman index.php
  }else{
    // Jika Gagal, Lakukan :
    echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
    echo "<br><a href='stock.php'>Kembali Ke Form</a>";
  }
}else{
  // Jika gambar gagal diupload, Lakukan :
  echo "Maaf, Gambar gagal untuk diupload.";
  echo "<br><a href='stock.php'>Kembali Ke Form</a>";
}
?>
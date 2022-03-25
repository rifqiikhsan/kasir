<?php
include "../koneksi.php";
$nama_file = $_FILES['produk']['gambar'];
$tmp_file = $_FILES['gambar']['tmp_name']
$path = "images/".$nama_file;
if(move_uploaded_file($tmp_file,$path)){
    
}
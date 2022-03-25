<?php
$db_host   = "localhost";
$db_user   = "root";
$db_pass   = "";
$db_name   = "multiuser";

$koneksi   = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
if(!$koneksi){
    die("koneksi gagal");
}



// if(isset($_POST['tambahbarang'])){
//     $namaproduk = $_POST['namaproduk'];
//     $deskripsi = $_POST['deskripsi'];
//     $stock = $_POST['stock'];
//     $harga = $_POST['harga'];
//     $lokasi_file = $_FILES['gambar']['tmp_name'];
//       $foto_file = $_FILES['gambar']['name'];
//       $tipe_file = $_FILES['gambar']['type'];
//       $ukuran_file = $_FILES['gambar']['size'];

//       $direktori = "gambar/$foto_file";


//       $sql = null;
//       $MAX_FILE_SIZE = 1000000;
//       //100kb
//       if ($ukuran_file > $MAX_FILE_SIZE) {
//         // header("Location:url?page=form_produk&status=1");
//         exit();
//       }
//       $sql = null;
//       if ($ukuran_file > 0) {
//         move_uploaded_file($lokasi_file, $direktori);
//       }
    	
//     $insert = mysqli_query($koneksi,"insert into produk(namaproduk,deskripsi,harga,stock,gambar) values ('$namaproduk','$deskripsi','$harga','$stock','$foto_file')");
//             if($insert){
//                 header('location:stock.php');
//             }
//             else{
//                 echo '
//                 <script>alert("gagal menambah barang baru");
//                 windows.location.href="stock.php"
//                 </script>
//                 ';
//             }
//         }


if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($koneksi,"insert into pelanggan(namapelanggan,notelp,alamat) values ('$namapelanggan','$notelp','$alamat')");

    if($insert){
        header('location:pelanggan.php');
    }
    else{
        echo '
        <script>alert("gagal menambah pelanggan baru");
        windows.location.href="pelanggan.php"
        </script>
        ';
    }
}

if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($koneksi,"insert into pesanan(idpelanggan) values ('$idpelanggan')");

    if($insert){
        header('location:index.php');
    }
    else{
        echo '
        <script>alert("gagal menambah pesanan baru");
        windows.location.href="index.php"
        </script>
        ';
    }
}


//produk dipilih di pesanan 
if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty'];

    //menghitung stock sekarang
    $hitung1 = mysqli_query($koneksi,"select * from produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock']; //stock barang saat ini

    
    if($stocksekarang>=$qty){

        //kurangi stocknya dengan jumlah yang akan di keluarkan
        $selisih = $stocksekarang-$qty;

        $insert = mysqli_query($koneksi,"insert into detailpesanan(idpesanan,idproduk,qty) values ('$idp','$idproduk','$qty')");
        $update = mysqli_query($koneksi,"update produk set stock='$selisih' where idproduk='$idproduk'");

    if($insert&&$update){
        header('location:view.php?idp='.$idp);
    }else{
        echo '
        <script>alert("gagal menambah pesanan baru");
        windows.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }
 } else{
        echo '
        <script>alert("gagal menambah pesanan baru");
        windows.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }
}
    

//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    //cari tau stock sekarang
$caristock = mysqli_query($koneksi,"select * from produk where idproduk='$idproduk'");
$caristock2 = mysqli_fetch_array($caristock);
$stocksekarang = $caristock2['stock'];

//hitung
$newstock = $stocksekarang + $qty;

    $insert = mysqli_query($koneksi,"insert into masuk(idproduk,qty) values('$idproduk','$qty')");
    $update = mysqli_query($koneksi,"update produk set stock='$newstock' where idproduk='$idproduk'");

    if($insert&&$update){
        header('location:masuk.php');
    }else{
        echo '
        <script>alert("gagal");
        windows.location.href="masuk.php"
        </script>
        ';
    }
}

//hapus produk pesanan
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp'];
    $idpr = $_POST['idpr'];
    $idpesanan = $_POST['idpesanan'];

    //cek qty sekarang
    $cek1 = mysqli_query($koneksi,"select * from detailpesanan where iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //cek stock sekarang
    $cek3 = mysqli_query($koneksi,"select * from produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stocksekarang = $cek4['stock'];

    $hitung = $stocksekarang + $qtysekarang;

    $update = mysqli_query($koneksi,"update produk set stock='$hitung' where idproduk='$idpr'");//update stock
    $hapus = mysqli_query($koneksi,"delete from detailpesanan where idproduk='$idpr' and iddetailpesanan='$idp'");

    if($update&&$hapus){
        header('location:view.php?idp='.$idpesanan);
    }
    else{
        echo '
        <script>alert("gagal menghapus barang ");
        windows.location.href="view.php?idp='.$idpesanan.'"
        </script>
        ';
    }
}

if(isset($_POST['editbarang'])){
    $np = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp'];//idproduk

    $query=mysqli_query($koneksi,"update produk set namaproduk='$np', deskripsi='$desc', harga='$harga' where idproduk='$idp'");
    if($query){
        header('location:stock.php');
    }
    else{
        echo '
        <script>alert("gagal mengedit barang");
        windows.location.href="stock.php"
        </script>
        ';
    }
}

//hapus barang
if(isset($_POST['hapusbarang'])){
    $idp = $_POST['idp'];

    if(is_file("images/".$data['foto'])){ // Jika foto ada
    unlink("images/".$data['foto']);
    }
    $query = mysqli_query($koneksi,"delete from produk where idproduk='$idp'");

    if($query){
        
        header('location:stock.php');

    }
    else{
        echo '
        <script>alert("gagal menghapus barang");
        windows.location.href="stock.php"
        </script>
        ';
    }
}

//edit pelanggan
if(isset($_POST['editpelanggan'])){
    $np = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $idpl = $_POST['idpl'];//idpelanggan

    $query=mysqli_query($koneksi,"update pelanggan set namapelanggan='$np', notelp='$notelp', alamat='$alamat' where idpelanggan='$idpl'");
    if($query){
        header('location:pelanggan.php');
    }
    else{
        echo '
        <script>alert("gagal mengedit pelanggan");
        windows.location.href="pelanggan.php"
        </script>
        ';
    }
}

//hapus pelanggan
if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl'];

    $query = mysqli_query($koneksi,"delete from pelanggan where idpelanggan='$idpl'");

    if($query){
        header('location:pelanggan.php');
    }
    else{
        echo '
        <script>alert("gagal menghapus pelanggan");
        windows.location.href="pelanggan.php"
        </script>
        ';
    }
}

//edit data barang masuk
if(isset($_POST['editdatabarangmasuk'])){
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];
    
    //cari tau qty sekarang
$caritau = mysqli_query($koneksi,"select * from masuk where idmasuk='$idm'");
$caritau2 = mysqli_fetch_array($caritau);
$qtysekarang = $caritau2['qty'];

//cari tau stock sekarang
$caristock = mysqli_query($koneksi,"select * from produk where idproduk='$idp'");
$caristock2 = mysqli_fetch_array($caristock);
$stocksekarang = $caristock2['stock'];

if($qty >= $qtysekarang){
    //kalo inputan user lebih besar dari pada qty yg tercatat
    $selisih = $qty-$qtysekarang;
    $newstock = $stocksekarang+$selisih;
    $query1=mysqli_query($koneksi,"update masuk set qty='$qty' where idmasuk='$idm'");
    $query2=mysqli_query($koneksi,"update produk set stock='$newstock' where idproduk='$idp'");

    if($query1 && $query2){
        header('location:masuk.php');
    }
    else{
        echo '
        <script>alert("gagal");
        windows.location.href="masuk.php"
        </script>
        ';
    }
}else{
    //kalo lebih kecil
    $selisih = $qtysekarang-$qty;
    $newstock = $stocksekarang-$selisih;
    $query1=mysqli_query($koneksi,"update masuk set qty='$qty' where idmasuk='$idm'");
    $query2=mysqli_query($koneksi,"update produk set stock='$newstock' where idproduk='$idp'");

    if($query1&&$query2){
        header('location:masuk.php');
    }
    else{
        echo '
        <script>alert("gagal");
        windows.location.href="masuk.php"
        </script>
        ';
    }

}

}

//hapus data barang masuk
if(isset($_POST['hapusdatabarangmasuk'])){
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari tau qty sekarang
$caritau = mysqli_query($koneksi,"select * from masuk where idmasuk='$idm'");
$caritau2 = mysqli_fetch_array($caritau);
$qtysekarang = $caritau2['qty'];

//cari tau stock sekarang
$caristock = mysqli_query($koneksi,"select * from produk where idproduk='$idp'");
$caristock2 = mysqli_fetch_array($caristock);
$stocksekarang = $caristock2['stock'];

    $newstock = $stocksekarang-$qtysekarang;
    $query1=mysqli_query($koneksi,"delete from masuk where idmasuk='$idm'");
    $query2=mysqli_query($koneksi,"update produk set stock='$newstock' where idproduk='$idp'");

    if($query1&&$query2){
        header('location:masuk.php');
    }
    else{
        echo '
        <script>alert("gagal");
        windows.location.href="masuk.php"
        </script>
        ';
    }
}

//hapus pesanan
if(isset($_POST['hapuspesanan'])){
    $idpesanan = $_POST['idpesanan'];

    $cekdata = mysqli_query($koneksi,"select * from detailpesanan dp where idpesanan='$idpesanan'");

    while($ok=mysqli_fetch_array($cekdata)){
        //balikin stock
        $qty= $ok['qty'];
        $idproduk = $ok['idproduk'];
        $iddp =$ok['iddetailpesanan'];

        //cari tau stock sekarang
        $caristock = mysqli_query($koneksi,"select * from produk where idproduk='$idproduk'");
        $caristock2 = mysqli_fetch_array($caristock);
        $stocksekarang = $caristock2['stock'];

        $newstock = $stocksekarang + $qty;
        $queryupdate = mysqli_query($koneksi,"update produk set stock='$newstock' where idproduk='$idproduk'");

        //hapus data
        $querydelete=mysqli_query($koneksi,"delete from detailpesanan where iddetailpesanan='$iddp'");

    }

    $query = mysqli_query($koneksi,"delete from pesanan where idpesanan='$idpesanan'");

    if($queryupdate && $querydelete && $query){
        header('location:index.php');
    }
    else{
        echo '
        <script>alert("gagal menghapus pelanggan");
        windows.location.href="index.php"
        </script>
        ';
    }
}

//edit data detail pesanan
if(isset($_POST['editdetailpesanan'])){
    $qty = $_POST['qty'];
    $iddp = $_POST['iddp'];
    $idpr = $_POST['idpr'];
    $idp = $_POST['idp'];
    
    //cari tau qty sekarang
$caritau = mysqli_query($koneksi,"select * from detailpesanan where iddetailpesanan='$iddp'");
$caritau2 = mysqli_fetch_array($caritau);
$qtysekarang = $caritau2['qty'];

//cari tau stock sekarang
$caristock = mysqli_query($koneksi,"select * from produk where idproduk='$idpr'");
$caristock2 = mysqli_fetch_array($caristock);
$stocksekarang = $caristock2['stock'];

if($qty >= $qtysekarang){
    //kalo inputan user lebih besar dari pada qty yg tercatat
    $selisih = $qty-$qtysekarang;
    $newstock = $stocksekarang-$selisih;
    $query1=mysqli_query($koneksi,"update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
    $query2=mysqli_query($koneksi,"update produk set stock='$newstock' where idproduk='$idpr'");

    if($query1 && $query2){
        header('location:view.php?idp='.$idp);
    }
    else{
        echo '
        <script>alert("gagal");
        windows.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }
}else{
    //kalo lebih kecil
    $selisih = $qtysekarang-$qty;
    $newstock = $stocksekarang+$selisih;
    $query1=mysqli_query($koneksi,"update detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
    $query2=mysqli_query($koneksi,"update produk set stock='$newstock' where idproduk='$idpr'");

    if($query1&&$query2){
        header('location:view.php?idp='.$idp);
    }
    else{
        echo '
        <script>alert("gagal");
        windows.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }

}

}


?>

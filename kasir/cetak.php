<?php
   session_start();
include ("../inc_koneksi.php");
if(!isset($_SESSION['admin_username'])){
    header("location:login.php");
}
$idp=$_GET['idp'];
if(isset($_GET['idp'])){
    $idp=$_GET['idp'];
    $iddp1 = mysqli_query($koneksi,"select * from detailpesanan");
    $iddp2 = mysqli_fetch_array($iddp1);
    $iddp = $iddp2['iddetailpesanan'];

    $ambilnamapelanggan = mysqli_query($koneksi,"select * from pesanan p,pelanggan pl where p.idpelanggan=pl.idpelanggan and p.idpesanan='$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np['namapelanggan'];
}
else{
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Kasir - Pesanan</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-warning">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Aplikasi kasir </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-dark" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
            
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark bg-warning" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading text-dark">Menu</div>
                            <a class="nav-link text-dark active" href="index.php">
                                <div class="sb-nav-link-icon text-dark"><i class="fas fa-cart-plus"></i></div>
                                Transaksi
                            </a>
                            <a class="nav-link text-white" href="pelanggan.php">
                                <div class="sb-nav-link-icon text-dark"><i class="fas fa-address-card"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link text-white" href="stock.php">
                                <div class="sb-nav-link-icon text-dark"><i class="fas fa-clipboard-list"></i></div>
                                Daftar Menu
                            </a>
                            <a class="nav-link text-white" href="../admin_depan.php">
                                Halaman depan
                            </a>
                            <a class="nav-link text-white" href="../logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4 bg-white">
                        <h1 class="mt-4 text-dark">Data Pesanan : <?=$idp;?></h1>
                        <h4 class="mt-2 text-dark mb-0">Nama Pelanggan : <?=$namapel;?></h4>

                        <div class="float-right"> <h3 class="mb-0 mt-4">Invoice #<?=$iddp;?></h3>
                                Date: <?php echo date('d M, Y') ?></div>
                           

                            <div class="card-body">
                                <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="center">No</th>
                                                <th>Nama Menu</th>
                                                <th class="right">Harga</th>
                                                <th class="center">Qty</th>
                                                <th class="right">SubTotal</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $get = mysqli_query($koneksi,"select * from detailpesanan p, produk pr where p.idproduk=pr.idproduk and idpesanan='$idp'");

                                    $i= 1;

                                    while($p=mysqli_fetch_array($get)){
                                        $qty =$p['qty'];
                                        $harga = $p['harga'];
                                        $subtotal = $qty*$harga;
                                        $namaproduk = $p['namaproduk'];
                                        $deskripsi = $p['deskripsi'];
                                        $total[] = $harga * $qty;
                                        ?>
                                                <tr>
                                                    <td><?=$i++;?></td>
                                                    <td><?=$namaproduk;?> - <?=$deskripsi;?></td>
                                                    <td><?=$harga;?></td>
                                                    <td><?=$qty;?></td>
                                                    <td>Rp<?=number_format($subtotal);?></td>
                                                </tr>
                                             <?php
                                        };// end of while

                                    ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                                <div class="row">
                                    <div class="col-4 mt-4 mb-4 ml-auto">
                                        <table class="table table-clear">
                                            <tbody>
                                                <tr>
                                                    <td class="left">
                                                        <strong class="text-dark">Total Bayar</strong>
                                                    </td>
                                                    <td class="right">
                                                        <strong class="text-dark">Rp<?=array_sum($total);?></strong>
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                    <form>
                                                    <td class="left">
                                                        <strong class="text-dark">Uang Bayar</strong>
                                                    </td>
                                                    <td class="right">
                                                        <input type="number" id="input_form" class="form-control"placeholder="masukan uang bayar">
                                                    </td>
                                                    <td>
                                                        <button id="tombol_form" class="btn btn-success">bayar</button>
                                                    </td>
                                                </form>
                                                </tr>
                                                <tr>
                                                    <td class="left">
                                                        <strong class="text-dark">Kembalian :<span id="hasil"></span></strong>
                                                    </td>
                                                    
                                                </tr> -->
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                             </div>

                </main>
            
                
            </div>
        </div>
         <script>
            // document.gerElementById("tombol_form").addEventListener("click",tampilkan_nilai_form);
            // function tampilkan_nilai_form(){
            //     var nilai_form=document.gerElementById("input_form").value;
            //     document.gerElementById("hasil").innerHTML=nilai_form - $total;
            // }
            print();
        </script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
    </html>
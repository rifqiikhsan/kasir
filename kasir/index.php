<?php
session_start();
include ("../inc_koneksi.php");
if(!isset($_SESSION['admin_username'])){
    header("location:login.php");
}

//hitung jumlah pesanan
$h1 = mysqli_query($koneksi,"select * from pesanan");
$h2 = mysqli_num_rows($h1);//jumlah pesanan


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
        <style>
            #layoutSidenav_content{
                background-color:#273036;
            }
        </style>
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
                    <div class="container-fluid px-4 bg-dark">
                        <h1 class="mt-4 text-white">Data Pesanan</h1>
                        
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jumlah Pesanan : <?=$h2;?></div>
                                </div>
                            </div>
                        </div>
                        
                            <!-- Button to Open the Modal -->
                         <button type="button" class="btn btn-info mb-4" data-toggle="modal" data-target="#myModal">
                            Tambah Pesanan Baru +
                         </button>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pesanan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    <?php
                                    $get = mysqli_query($koneksi,"select * from pesanan p, pelanggan pl where p.idpelanggan=pl.idpelanggan");
                                    $i= 1;

                                    while($p=mysqli_fetch_array($get)){
                                    $idpesanan = $p['idpesanan'];
                                    $tanggal = $p['tanggal'];
                                    $namapelanggan = $p['namapelanggan'];
                                    $alamat = $p['alamat'];
                                    
                                    //hitung jumlah
                                    $hitungjumlah = mysqli_query($koneksi,"select * from detailpesanan where idpesanan='$idpesanan'");
                                    $jumlah = mysqli_num_rows($hitungjumlah);
                                    
                                    ?>
                                        <tr>
                                            <td><?=$idpesanan;?></td>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namapelanggan;?> - <?=$alamat;?></td>
                                            <td><?=$jumlah;?></td>
                                            <td><a href="view.php?idp=<?=$idpesanan;?>" class="btn btn-primary" target="blank">Tampilkan</a></td>
                                        </tr>

                                        

                                        <?php
                                    };// end of while

                                    ?>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-dark mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Rifqi ikhsan 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pesanan Baru</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form method="post">
        <!-- Modal body -->
        <div class="modal-body">
          Pilih Pelanggan
          <select name="idpelanggan" class="form-control">
              <?php
              $getpelanggan = mysqli_query($koneksi,"select * from pelanggan");

              while($pl=mysqli_fetch_array($getpelanggan)){
                $namapelanggan = $pl['namapelanggan'];
                $idpelanggan = $pl['idpelanggan'];
                $alamat = $pl['alamat'];

              
              
              ?>

              <option value="<?=$idpelanggan;?>"><?=$namapelanggan;?> - <?=$alamat;?></option>

              <?php
              }

              ?>
          </select>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="sumbit" class="btn btn-success" name="tambahpesanan">Sumbit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
        </form>

      </div>
    </div>
  </div>
</html>
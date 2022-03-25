<?php
session_start();
include ("../inc_koneksi.php");
if(!isset($_SESSION['admin_username'])){
    header("location:login.php");
}
if(!in_array("admin", $_SESSION['admin_akses'])){
    echo "hayo mau ngapain!! Untuk mengakses halaman ini silakan izin dan minta akun admin login kepada admin:Rifqi_ikhsan";
    exit();
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
        <title>Admin - Menu Masuk</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            #layoutSidenav_content{
                background-color:rgb(61, 61, 61);
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-warning">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Admin Aplikasi kasir</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-black" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
            
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark bg-warning" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading text-dark">Menu</div>
                            <a class="nav-link text-white" href="index.php">
                                <div class="sb-nav-link-icon text-dark"><i class="fas fa-cart-plus"></i></div>
                                Order
                            </a>
                            <a class="nav-link text-white" href="stock.php">
                                <div class="sb-nav-link-icon text-dark"><i class="fas fa-clipboard-list"></i></div>
                                Daftar Menu
                            </a>
                            <a class="nav-link text-dark" href="masuk.php">
                                <div class="sb-nav-link-icon text-dark"><i class="fas fa-box"></i></div>
                                Menu Masuk
                            </a>
                            <a class="nav-link text-white" href="pelanggan.php">
                                <div class="sb-nav-link-icon text-dark"><i class="fas fa-address-card"></i></div>
                                Kelola Pelanggan
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
                        <h1 class="mt-4 text-white">Data Barang Masuk</h1>
                        
                        
                        <!-- Button to Open the Modal -->
                         <button type="button" class="btn btn-info mb-4" data-toggle="modal" data-target="#myModal">
                            Tambah Barang Masuk +
                         </button>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Barang Masuk
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $get = mysqli_query($koneksi,"select * from masuk m,produk p where m.idproduk=p.idproduk");
                                    $i= 1;

                                    while($p=mysqli_fetch_array($get)){
                                    $namaproduk = $p['namaproduk'];
                                    $deskripsi = $p['deskripsi'];
                                    $qty = $p['qty'];
                                    $tanggalmasuk = $p['tanggalmasuk'];
                                    $idmasuk = $p['idmasuk'];
                                    $idproduk = $p['idproduk'];
                                    
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namaproduk;?> - <?=$deskripsi;?></td>
                                            <td><?=$qty;?></td>
                                            <td><?=$tanggalmasuk;?></td>
                                            <td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idmasuk;?>">
                                            edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idmasuk;?>">
                                            delete
                                            </button></td>
                                        </tr>


                                        <div class="modal fade" id="edit<?=$idmasuk;?>">
                                        
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Ubah Data Barang Masuk</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                
                                                <form method="post">
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                <input type="text" name="namaproduk" class="form-control" value="<?=$namaproduk;?> - <?=$deskripsi;?>" disabled>
                                                <input type="number" name="qty" class="form-control mt-2" value="<?=$qty;?>">
                                                <input type="hidden" name="idm" value="<?=$idmasuk;?>">
                                                <input type="hidden" name="idp" value="<?=$idproduk;?>">
                                                </div>
                                                
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                <button type="sumbit" class="btn btn-success" name="editdatabarangmasuk">Sumbit</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                                
                                                </form>

                                            </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="delete<?=$idmasuk;?>">
                                        
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data Barang Masuk</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                
                                                <form method="post">
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus produk ini?
                                                <input type="hidden" name="idp" value="<?=$idproduk;?>">
                                                <input type="hidden" name="idm" value="<?=$idmasuk;?>">
                                                </div>
                                                
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                <button type="sumbit" class="btn btn-success" name="hapusdatabarangmasuk">Sumbit</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                                
                                                </form>

                                            </div>
                                            </div>
                                        </div>

                                        <?php
                                    };// end of while

                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto bg-dark">
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
          <h4 class="modal-title">Tambah Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form method="post">
        <!-- Modal body -->
        <div class="modal-body">
          Pilih barang
          <select name="idproduk" class="form-control">
              <?php
              $getproduk = mysqli_query($koneksi,"select * from produk");

              while($pl=mysqli_fetch_array($getproduk)){
                $namaproduk = $pl['namaproduk'];
                $stock = $pl['stock'];
                $deskripsi = $pl['deskripsi'];
                $idproduk = $pl['idproduk'];

              
              
              ?>

              <option value="<?=$idproduk;?>"><?=$namaproduk;?> - <?=$deskripsi;?> (stock=<?=$stock;?>)</option>

              <?php
              }

              ?>
          </select>
          <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="sumbit" class="btn btn-success" name="barangmasuk">Sumbit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
        </form>

      </div>
    </div>
  </div>

</html>

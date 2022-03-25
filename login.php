<?php
session_start();
if(isset($_SESSION['admin_username'])){
    header("location:admin_depan.php");
}

include ("inc_koneksi.php");
$username = "";
$password = "";
$err = "";
if(isset($_POST['login'])){
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    if($username == '' or $password == ''){
        $err = "<li>Silakan Masukan Username dan Password</li>";
    }
    if(empty($err)){
        $sql1 = "select * from admin where username = '$username'";
        $q1 = mysqli_query($koneksi,$sql1);
        $r1 = mysqli_fetch_array($q1);
        if($r1['password'] != md5($password)){
            $err= "<li>Akun tidak di temukan</li>";
        }
    }
    if(empty($err)){
        $login_id = $r1['login_id'];
        $sql1 = "select * from admin_akses where login_id = '$login_id'";
        $q1 = mysqli_query($koneksi,$sql1);
        while($r1 = mysqli_fetch_array($q1)){
            $akses[] = $r1['akses_id'];//admin,kasir
        }
        if(empty($akses)){
            $err ="<li>Kamu tidak punya akses ke halaman admin</li>";
        }
    }
    if(empty($err)){
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_akses'] = $akses;
        header("location:admin_depan.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_login.css">
    <title>Aplikasi Kasir - Login</title>
</head>
<body>
    <div id="app">
        <h1>Halaman Login</h1>
        <?php
        if($err){
            echo "<ul>$err</ul>";
        }
        ?>
         <form action="" method="post">
            <label>Username</label>
            <input type="text" value="<?php echo $username ?>"name="username" class="input" placeholder="MASUKAN USERNAME"/><br/><br/>
            <label>Password</label>
            <input type="password" name="password" class="input" placeholder="MASUKAN PASSWORD"/><br/>
            
            <button type="submit" name="login" id="masuk" class="btn btn-primary">
							<i class="fa fa-save"></i> Login
						</button>
        </form> 
        
    </div>
</body>
</html>
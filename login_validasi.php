<?php
session_start();

include 'src/koneksi.php';


$username = $_POST['username'];
$password = md5($_POST['password']);

$login = mysqli_query($koneksi,"SELECT * FROM petugas WHERE username='$username' AND password='$password'")
        or die(mysqli_error());
$cek = mysqli_num_rows($login);

// skrip mengecek apakah username dan password di temukan pada database
if($cek > 0){
    $data = mysqli_fetch_assoc($login);

    if($data['level']=="admin"){ // cek jika user login sebagai admin
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "admin";
        // alihkan ke halaman dashboard admin
        echo '<script language="javascript">alert("Anda berhasil Login Admin!");
        document.location="admin/halaman_admin.php";</script>';

    }else if($data['level']=="petugas"){
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "petugas";
        // alihkan ke halaman petugas
        echo '<script language="javascript">alert("Anda berhasil login petugas!");
        document.location="petugas/halaman_petugas.php";</script>';

    }else{
        //alihkan ke halaman login kembali
        header("location:index.php?pesan=gagal");
    }
}else{
    header("location:index.php?pesan=gagal");
}
?>
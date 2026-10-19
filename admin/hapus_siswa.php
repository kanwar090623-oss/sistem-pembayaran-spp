<?php
include_once "../src/koneksi.php";

if(isset($_GET['nisn'])){
    $nisn   =$_GET['nisn'];

    $sql = mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'");
    if($sql){
        echo "<center> <b> <font color = 'red' size = '4'> <p> Data Berhasil dihapus </p>
        </center> </b> </font> </br>
        <meta http-equiv='refresh' content='2; url=?open=data_siswa'>";
    }
}
else{
    echo "<b> Data yang dihapus tidak ada</b>";
}
?>
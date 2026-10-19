<?php
include_once "../src/koneksi.php";

if(isset($_GET['id_kelas'])){
    $id_kelas   = $_GET['id_kelas'];

    $sql = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");
    if($sql){
        echo "<center> <b> <font color = 'red' size = '4'> <p> Data Berhasil dihapus </p>
        </center> </b> </font> </br>
        <meta http-equiv='refresh' content='2; url=?open=data_kelas'>";
    }
}
else {
    echo "<b>Data yang dihapus tidak ada</b>";
}
?>
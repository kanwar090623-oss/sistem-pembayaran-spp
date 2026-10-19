<?php

// Cek agar session tidak dijalankan dua kali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "../src/koneksi.php";


// =====================================================
// MENGAMBIL ID PETUGAS YANG SEDANG LOGIN
// =====================================================

if (!isset($_SESSION['username'])) {
    die("Session username tidak ditemukan. Silakan login kembali.");
}

$username = mysqli_real_escape_string($koneksi, $_SESSION['username']);

$queryPetugas = mysqli_query(
    $koneksi,
    "SELECT id_petugas FROM petugas 
     WHERE username='$username' 
     LIMIT 1"
);

if (!$queryPetugas) {
    die("Gagal mengambil data petugas: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($queryPetugas) == 0) {
    die("Data petugas tidak ditemukan.");
}

$dataPetugas = mysqli_fetch_assoc($queryPetugas);

$id_petugas = $dataPetugas['id_petugas'];


// =====================================================
// PROSES SIMPAN
// =====================================================

if (isset($_POST['btnSimpan'])) {

    $nisn     = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nis      = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    $alamat   = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_telp  = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $id_spp   = mysqli_real_escape_string($koneksi, $_POST['id_spp']);

    $pesanError = array();


    // =====================================================
    // VALIDASI
    // =====================================================

    if (trim($nisn) == "") {
        $pesanError[] = "Data <b>NISN</b> tidak boleh kosong!";
    }

    if (trim($nis) == "") {
        $pesanError[] = "Data <b>NIS</b> tidak boleh kosong!";
    }

    if (trim($nama) == "") {
        $pesanError[] = "Data <b>NAMA</b> tidak boleh kosong!";
    }

    if (trim($id_kelas) == "") {
        $pesanError[] = "Data <b>KELAS</b> tidak boleh kosong!";
    }

    if (trim($alamat) == "") {
        $pesanError[] = "Data <b>ALAMAT</b> tidak boleh kosong!";
    }

    if (trim($no_telp) == "") {
        $pesanError[] = "Data <b>NOMOR TELEPON</b> tidak boleh kosong!";
    }

    if (trim($id_spp) == "") {
        $pesanError[] = "Data <b>ID SPP</b> tidak boleh kosong!";
    }


    // =====================================================
    // JIKA ADA ERROR
    // =====================================================

    if (count($pesanError) > 0) {

        $noPesan = 0;

        foreach ($pesanError as $pesan_tampil) {

            $noPesan++;

            echo "&nbsp;$noPesan. $pesan_tampil<br>";
        }

        echo "<br>";

    } else {


        // =================================================
        // SIMPAN DATA SISWA
        // =================================================

        $sqlSiswa = mysqli_query($koneksi, "
            INSERT INTO siswa
            (
                nisn,
                nis,
                nama,
                id_kelas,
                alamat,
                no_telp,
                id_spp
            )
            VALUES
            (
                '$nisn',
                '$nis',
                '$nama',
                '$id_kelas',
                '$alamat',
                '$no_telp',
                '$id_spp'
            )
        ");


        if (!$sqlSiswa) {

            echo "
                <center>
                    <h3>Data Gagal Disimpan!</h3>
                    <p style='color:red;'>
                        " . mysqli_error($koneksi) . "
                    </p>
                </center>
            ";

        } else {


            // =================================================
            // DAFTAR BULAN SPP
            // =================================================

            $arraybulan = array(
                "Juli",
                "Agustus",
                "September",
                "Oktober",
                "November",
                "Desember",
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni"
            );


            // Tahun awal
            $tahunsekarang = date('Y');


            // =================================================
            // MEMBUAT 12 TAGIHAN
            // =================================================

            $gagal = false;

            for ($i = 0; $i < count($arraybulan); $i++) {

                $bulan = $arraybulan[$i];


                // Januari sampai Juni masuk tahun berikutnya
                if ($i == 6) {
                    $tahunsekarang++;
                }


                $sqlPembayaran = mysqli_query($koneksi, "
                    INSERT INTO pembayaran
                    (
                        id_petugas,
                        nisn,
                        bulan_tagihan,
                        tahun_tagihan,
                        id_spp,
                        jumlah_bayar
                    )
                    VALUES
                    (
                        '$id_petugas',
                        '$nisn',
                        '$bulan',
                        '$tahunsekarang',
                        '$id_spp',
                        0
                    )
                ");


                if (!$sqlPembayaran) {

                    $gagal = true;

                    echo "
                        <center>
                            <h3>Data Gagal Disimpan!</h3>
                            <p style='color:red;'>
                                Gagal membuat tagihan bulan 
                                <b>$bulan</b>
                            </p>
                            <p style='color:red;'>
                                " . mysqli_error($koneksi) . "
                            </p>
                        </center>
                    ";

                    break;
                }
            }


            // =================================================
            // JIKA SEMUA BERHASIL
            // =================================================

            if (!$gagal) {

                echo "
                    <center>
                        <h3>Data Berhasil Disimpan</h3>
                        
                    </center>
                ";

                echo "
                    <meta http-equiv='refresh'
                    content='2; url=?open=data_siswa'>
                ";

                exit;
            }
        }
    }
}

?>


<form action="halaman_admin.php?open=tambah_siswa" method="post">

<table cellspacing="1" cellpadding="3">

    <tr>
        <td bgcolor="#CCCCCC">
            <strong>TAMBAH DATA SISWA</strong>
        </td>
    </tr>


    <tr>
        <td>NISN</td>
        <td>:</td>
        <td>
            <input
                name="nisn"
                type="text"
                size="10"
                maxlength="10"
            />
        </td>
    </tr>


    <tr>
        <td>NIS</td>
        <td>:</td>
        <td>
            <input
                name="nis"
                type="text"
                size="20"
                maxlength="10"
            />
        </td>
    </tr>


    <tr>
        <td>NAMA</td>
        <td>:</td>
        <td>
            <input
                name="nama"
                type="text"
                size="50"
                maxlength="50"
            />
        </td>
    </tr>


    <tr>
        <td>KELAS</td>
        <td>:</td>
        <td>

            <select name="id_kelas">

                <option value="">
                    -- Pilih Kelas --
                </option>

                <?php

                $tampilkanKelas = mysqli_query(
                    $koneksi,
                    "SELECT * FROM kelas"
                );

                while ($bacaData = mysqli_fetch_array($tampilkanKelas)) {

                    echo "
                        <option value='".$bacaData['id_kelas']."'>
                            ".$bacaData['nama_kelas']."
                        </option>
                    ";
                }

                ?>

            </select>

        </td>
    </tr>


    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>
            <input
                name="alamat"
                type="text"
                size="50"
                maxlength="50"
            />
        </td>
    </tr>


    <tr>
        <td>No. Telepon</td>
        <td>:</td>
        <td>
            <input
                name="no_telp"
                type="text"
                size="50"
                maxlength="50"
            />
        </td>
    </tr>


    <tr>
        <td>Nominal</td>
        <td>:</td>
        <td>

            <select name="id_spp">

                <option value="">
                    -- Pilih Nominal --
                </option>

                <?php

                $tampilkanSPP = mysqli_query(
                    $koneksi,
                    "SELECT * FROM spp"
                );

                while ($bacaData = mysqli_fetch_array($tampilkanSPP)) {

                    echo "
                        <option value='".$bacaData['id_spp']."'>
                            ".$bacaData['nominal']."
                        </option>
                    ";
                }

                ?>

            </select>

        </td>
    </tr>


    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>

            <input
                name="btnSimpan"
                type="submit"
                value="Simpan"
            />

        </td>
    </tr>

</table>

</form>
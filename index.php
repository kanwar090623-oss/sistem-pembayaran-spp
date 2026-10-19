
<html>
<head>

<title>Login SPP Online</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Nunito',sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: #0F172A;
}

.container{
    width:360px;
}

.title{
    text-align:center;
    color:white;
    font-size:34px;
    font-weight:bold;
    margin-bottom:20px;
    text-shadow:2px 2px 5px rgba(0,0,0,.3);
}

.card{
    background: #1E293B;
    padding:35px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.25);
}

.profile{
    display:flex;
    justify-content:center;
    margin-bottom:15px;
}

.profile img{
    width:100px;
    height:100px;
    border-radius:50%;
    border:4px solid white;
    object-fit:cover;
}

.login-text{
    text-align:center;
    font-size:24px;
    font-weight:bold;
    color: white;
    margin-bottom:25px;
}

input{
    width:100%;
    padding:14px;
    margin-bottom:15px;
    border:none;
    border-radius:10px;
    background:#f1f1f1;
    font-size:15px;
    transition:.3s;
}

input:focus{
    outline:none;
    background:white;
    border:2px solid #F39F5A;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background: #2563EB;
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
    margin-top:25px;
}

button:hover{
    background: #1D4ED8;
    transform:scale(1.03);
}

.alert{
    background:#ffdddd;
    color:#d8000c;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
}
.cek-pembayaran{
    margin-top:15px;
    text-align:center;
}

/* Tombol cek pembayaran */
.btn-cek{
    display:block;
    width:100%;
    padding:12px;
    background:#2563EB;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-size:16px;
    font-weight:bold;
    transition:0.3s;
    box-sizing:border-box;
}

.btn-cek:hover{
    background:#1D4ED8;
}


</style>

</head>
<body>

<div class="container">

    <div class="title">
        SPP ONLINE
    </div>

    <div class="card">

        <div class="profile">
            <img src="src/Kucing.jpg" alt="Profile">
        </div>

        <div class="login-text">
            LOGIN
        </div>

        <?php
        if(isset($_GET['pesan'])){
            if($_GET['pesan']=="gagal"){
                echo "<div class='alert'>Username atau Password Salah!</div>";
            }
        }
        ?>

        <form action="login_validasi.php" method="post">

            <input
                type="text"
                name="username"
                placeholder="👤 Username"
                required>

            <input
                type="password"
                name="password"
                placeholder="🔒 Password"
                required>

            <button type="submit" name="login">
                LOGIN
            </button>

            <div class="cek-pembayaran">
        <a href="bayar.php" class="btn-cek">
            CEK PEMBAYARAN
        </a>
       </div>

        </form>

       

    </div>

</div>

</body>
</html>
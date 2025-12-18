<?php
include "koneksi.php";

if (isset($_POST['register'])) {
    $nim       = trim($_POST['nim']);
    $nama      = trim($_POST['nama']);
    $jurusan   = trim($_POST['jurusan']);
    $username  = trim($_POST['username']);
    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password !== $password2) {
        $error = "Password dan konfirmasi password tidak sama";
    } else {
        // cek username di user & admin
        $cek_user  = mysqli_query($koneksi,"SELECT 1 FROM users WHERE username='$username'");
        $cek_admin = mysqli_query($koneksi,"SELECT 1 FROM admin WHERE username='$username'");

        if (mysqli_num_rows($cek_user) > 0 || mysqli_num_rows($cek_admin) > 0) {
            $error = "Username sudah digunakan";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($koneksi,"
                INSERT INTO users (nim,nama,jurusan,username,password)
                VALUES ('$nim','$nama','$jurusan','$username','$hash')
            ");

            $success = "Registrasi berhasil. Silakan login.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register | Perpustakaan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Merriweather:wght@300;400&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Merriweather',serif;
    min-height:100vh;
    background:linear-gradient(135deg,#1B3A2F,#4E342E);
    display:flex;
    align-items:center;
    justify-content:center;
}
.register-box{
    width:950px;
    max-width:95%;
    background:#F5F1E8;
    border-radius:14px;
    display:flex;
    overflow:hidden;
    border:6px double #6D2E2E;
    box-shadow:0 30px 80px rgba(0,0,0,.5);
}
.left{
    width:45%;
    background:linear-gradient(135deg,#6D2E2E,#4E342E);
    color:#F5F1E8;
    padding:60px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}
.left h2{
    font-family:'Playfair Display',serif;
    font-weight:700;
    letter-spacing:1px;
}
.left p{
    opacity:.9;
    margin-top:16px;
}
.right{
    width:55%;
    padding:60px;
    color:#1B3A2F;
}
.form-control{
    background:#EFE7DA;
    border:2px solid #6D2E2E;
    border-radius:6px;
    padding:14px;
    font-family:'Merriweather',serif;
}
.form-control:focus{
    box-shadow:none;
    border-color:#1B3A2F;
}
.btn-main{
    background:#1B3A2F;
    border:none;
    border-radius:6px;
    padding:14px;
    font-family:'Playfair Display',serif;
    font-size:16px;
    color:#F5F1E8;
}
.btn-main:hover{
    background:#6D2E2E;
}
a{
    color:#6D2E2E;
    font-weight:600;
    text-decoration:none;
}
a:hover{
    text-decoration:underline;
}
@media(max-width:768px){
    .register-box{flex-direction:column;}
    .left,.right{width:100%;}
}
</style>
</head>
<body>

<div class="register-box">

    <!-- LEFT -->
    <div class="left">
        <h2>Pendaftaran Anggota</h2>
        <p>
            Bergabunglah dengan perpustakaan digital bernuansa klasik
            untuk mengakses koleksi buku dan layanan akademik.
        </p>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <h3 style="font-family:'Playfair Display',serif;" class="mb-3">
            Register User
        </h3>
        <p class="mb-4">
            Lengkapi data diri dengan benar
        </p>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <div class="alert alert-success text-center">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="nim" class="form-control mb-2" placeholder="NIM" required>
            <input type="text" name="nama" class="form-control mb-2" placeholder="Nama Lengkap" required>
            <input type="text" name="jurusan" class="form-control mb-2" placeholder="Jurusan" required>
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
            <input type="password" name="password2" class="form-control mb-4" placeholder="Konfirmasi Password" required>

            <button type="submit" name="register" class="btn btn-main w-100">
                Register
            </button>
        </form>

        <p class="text-center mt-4 mb-0">
            Sudah punya akun?
            <a href="index.php">Login</a>
        </p>
    </div>

</div>

</body>
</html>

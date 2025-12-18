<?php
include "koneksi.php";

$error = "";
$success = "";

if (isset($_POST['reset'])) {
    $username = trim($_POST['username']);
    $nim      = trim($_POST['nim']);
    $pass1    = $_POST['pass1'];
    $pass2    = $_POST['pass2'];

    if ($pass1 !== $pass2) {
        $error = "Password baru dan konfirmasi tidak sama";
    } else {
        // Cek user berdasarkan username dan NIM
        $q = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND nim='$nim'");
        $cek = mysqli_num_rows($q);

        if ($cek > 0) {
            $user = mysqli_fetch_assoc($q);
            $id_user = $user['id_user'];
            
            // Update password
            $hash = password_hash($pass1, PASSWORD_DEFAULT);
            mysqli_query($koneksi, "UPDATE users SET password='$hash' WHERE id_user='$id_user'");
            
            $success = "Password berhasil direset. Silakan login dengan password baru.";
        } else {
            $error = "Data tidak ditemukan. Pastikan Username dan NIM benar.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Lupa Password | Perpustakaan</title>
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
.login-box{
    width:500px;
    max-width:95%;
    background:#F5F1E8;
    border-radius:14px;
    padding:40px;
    border:6px double #6D2E2E;
    box-shadow:0 30px 80px rgba(0,0,0,.5);
}
h3 {
    font-family:'Playfair Display',serif;
    color:#1B3A2F;
    text-align:center;
    font-weight:700;
}
.form-control{
    background:#EFE7DA;
    border:2px solid #6D2E2E;
    border-radius:6px;
    padding:12px;
    font-family:'Merriweather',serif;
}
.form-control:focus{
    box-shadow:none;
    border-color:#1B3A2F;
}
.btn-submit{
    background:#1B3A2F;
    border:none;
    border-radius:6px;
    padding:12px;
    font-family:'Playfair Display',serif;
    color:#F5F1E8;
    font-size:16px;
}
.btn-submit:hover{
    background:#6D2E2E;
}
a{
    color:#6D2E2E;
    font-weight:600;
    text-decoration:none;
}
a:hover{ text-decoration:underline; }
</style>
</head>
<body>

<div class="login-box">
    <h3 class="mb-4">Reset Password</h3>

    <?php if($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="alert alert-success text-center">
            <?= $success ?>
            <br>
            <a href="index.php" class="btn btn-sm btn-outline-success mt-2">Ke Halaman Login</a>
        </div>
    <?php else: ?>

    <p class="text-center mb-4">Masukkan Username dan NIM untuk verifikasi akun.</p>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" name="nim" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="pass1" class="form-control" required>
        </div>
        <div class="mb-4">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="pass2" class="form-control" required>
        </div>

        <button type="submit" name="reset" class="btn btn-submit w-100 mb-3">
            Reset Password
        </button>

        <div class="text-center">
            <a href="index.php">Batal / Kembali Login</a>
        </div>
    </form>
    <?php endif; ?>

</div>

</body>
</html>

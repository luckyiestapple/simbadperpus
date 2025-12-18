<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // ADMIN
    $q_admin = mysqli_query($koneksi,"SELECT * FROM admin WHERE username='$username'");
    $admin = mysqli_fetch_assoc($q_admin);

    if ($admin && $password === $admin['password']) {
        $_SESSION['login'] = true;
        $_SESSION['role']  = 'admin';
        $_SESSION['id_admin'] = $admin['id_admin'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['nama_admin'] = $admin['nama_admin'];
        header("Location: admin/dashboard.php");
        exit;
    }

    // USER
    $q_user = mysqli_query($koneksi,"SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($q_user);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['role']  = 'user';
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['nim']  = $user['nim'];
        $_SESSION['jurusan']  = $user['jurusan'];
        header("Location: user/dashboard_user.php");
        exit;
    }

    $error = "Username atau password salah";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | Perpustakaan</title>

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
    width:900px;
    max-width:95%;
    background:#F5F1E8;
    border-radius:14px;
    display:flex;
    overflow:hidden;
    border:6px double #6D2E2E; /* bingkai klasik */
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
.link-ganti{
    font-size:14px;          /* lebih kecil */
    color:#7B2D26;           /* coklat elegan */
    font-weight:600;
    text-decoration:none;
    font-family:'Merriweather',serif;
    alignment: center;
}
.link-ganti:hover{
    text-decoration:underline;
    color:#5A1F1A;
}

.form-control:focus{
    box-shadow:none;
    border-color:#1B3A2F;
}
.btn-login{
    background:#1B3A2F;
    border:none;
    border-radius:6px;
    padding:14px;
    font-family:'Playfair Display',serif;
    font-size:16px;
    color:#F5F1E8;
}
.btn-login:hover{
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
    .login-box{flex-direction:column;}
    .left,.right{width:100%;}
}
</style>
</head>
<body>

<div class="login-box">

    <!-- LEFT -->
    <div class="left">
        <h2>The Wonderlust Library</h2>
        <p>
            Sebuah perpustakaan digital bernuansa klasik
            untuk mengelola koleksi buku, peminjaman,
            dan layanan akademik.
        </p>
    </div>

    <!-- RIGHT -->
    <div class="right">
        <h3 class="mb-3" style="font-family:'Playfair Display',serif;">
            Login Akun
        </h3>
        <p class="mb-4">
            Masuk sebagai <b>Admin</b> atau <b>User</b>
        </p>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username"
                   class="form-control mb-3"
                   placeholder="Username" required>

            <input type="password" name="password"
                   class="form-control mb-4"
                   placeholder="Password" required>

            <button type="submit" name="login"
                    class="btn btn-login w-100">
                Login
            </button>
        </form>
         <p class="link_ganti mt-3">
    <a href="ganti_password.php" class="link-ganti">
        Ganti Password
    </a>
</p>
        <p class="text-center mt-3 mb-2">
            Belum punya akun?
            <a href="register.php">Register</a>
        </p>
        
    </div>

</div>

</body>
</html>

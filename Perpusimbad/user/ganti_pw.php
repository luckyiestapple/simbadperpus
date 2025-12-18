<?php
session_start();
include "../koneksi.php";

// proteksi: hanya user login
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$msg = "";
$err = "";

if (isset($_POST['ubah'])) {
    $pw_lama = $_POST['password_lama'];
    $pw_baru = $_POST['password_baru'];
    $pw_konf = $_POST['konfirmasi'];

    if ($pw_baru !== $pw_konf) {
        $err = "Password baru dan konfirmasi tidak sama.";
    } else {
        $q = mysqli_query($koneksi, "SELECT password FROM users WHERE id_user='$id_user'");
        $u = mysqli_fetch_assoc($q);

        if (!password_verify($pw_lama, $u['password'])) {
            $err = "Password lama salah.";
        } else {
            $hash = password_hash($pw_baru, PASSWORD_DEFAULT);
            mysqli_query($koneksi,
                "UPDATE users SET password='$hash' WHERE id_user='$id_user'"
            );
            $msg = "Password berhasil diperbarui.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Ganti Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body">
          <h4 class="mb-3">Ganti Password</h4>

          <?php if($msg): ?>
            <div class="alert alert-success"><?= $msg ?></div>
          <?php endif; ?>
          <?php if($err): ?>
            <div class="alert alert-danger"><?= $err ?></div>
          <?php endif; ?>

          <form method="post">
            <div class="mb-3">
              <label>Password Lama</label>
              <input type="password" name="password_lama"
                     class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Password Baru</label>
              <input type="password" name="password_baru"
                     class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Konfirmasi Password Baru</label>
              <input type="password" name="konfirmasi"
                     class="form-control" required>
            </div>

            <button type="submit" name="ubah"
                    class="btn btn-primary w-100">
              Simpan Password
            </button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

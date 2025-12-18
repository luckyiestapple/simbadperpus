<?php
session_start();
include "../koneksi.php";

$msg = "";
$err = "";

if (isset($_POST['reset_pw'])) {
    $id_user = (int)$_POST['id_user'];
    $pw_baru = trim($_POST['password']);

    if ($pw_baru == "") {
        $err = "Password baru wajib diisi.";
    } else {
        $hash = password_hash($pw_baru, PASSWORD_DEFAULT);
        mysqli_query($koneksi,
            "UPDATE users SET password='$hash' WHERE id_user='$id_user'"
        );
        $msg = "Password berhasil di-reset.";
    }
}

$users = mysqli_query(
    $koneksi,
    "SELECT id_user, nama, username, role FROM users ORDER BY id_user ASC"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin | Reset Password User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Merriweather&display=swap" rel="stylesheet">

<style>
body{
    background:#F4F5F7;
    font-family:'Merriweather',serif;
}
.admin-header{
    background:#1F2937;
    color:#F9FAFB;
    padding:20px 30px;
    display:flex;
    align-items:center;
    justify-content:space-between;
}
.admin-header h4{
    font-family:'Playfair Display',serif;
    margin:0;
}
.card{
    border-radius:12px;
}
.table th{
    background:#E5E7EB;
}
.btn-reset{
    background:#FBBF24;
    border:none;
    font-weight:600;
}
.btn-reset:hover{
    background:#F59E0B;
}
.note{
    font-size:14px;
    color:#6B7280;
}
</style>
</head>
<body>

<!-- HEADER ADMIN -->
<div class="admin-header">
    <h4>Manajemen User</h4>
    <a href="dashboard.php" class="btn btn-outline-light btn-sm">
        ← Kembali ke Dashboard
    </a>
</div>

<div class="container py-4">

    <?php if($msg): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <?php if($err): ?>
        <div class="alert alert-danger"><?= $err ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3" style="font-family:'Playfair Display',serif;">
                Reset Password User
            </h5>

            <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th width="100">Role</th>
                        <th width="280">Reset Password</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($u=mysqli_fetch_assoc($users)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($u['nama']) ?></td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= $u['role'] ?></td>
                        <td>
                            <form method="post" class="d-flex gap-2">
                                <input type="hidden" name="id_user" value="<?= $u['id_user'] ?>">
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-sm"
                                       placeholder="Password baru"
                                       required>
                                <button type="submit"
                                        name="reset_pw"
                                        class="btn btn-reset btn-sm"
                                        onclick="return confirm('Reset password user ini?')">
                                    Reset
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            </div>

            <p class="note mt-3">
                Catatan: Admin hanya dapat mengatur ulang password, tanpa melihat password lama.
            </p>

        </div>
    </div>
</div>

</body>
</html>

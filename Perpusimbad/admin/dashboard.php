<?php
include "cek_admin.php";
include "../koneksi.php";

// hitung data
$total_user   = mysqli_num_rows(mysqli_query($koneksi,"SELECT id_user FROM users"));
$total_buku   = mysqli_num_rows(mysqli_query($koneksi,"SELECT id_buku FROM buku"));
$total_pinjam = mysqli_num_rows(mysqli_query($koneksi,"SELECT id_pinjam FROM peminjaman"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#f5f5f5;
    font-family:Arial, sans-serif;
}
.navbar{
    background:#343a40;
}
.card{
    border:none;
    box-shadow:0 2px 6px rgba(0,0,0,.1);
}
.icon{
    font-size:28px;
    color:#6c757d;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-4">
    <span class="navbar-brand">
        <i class="bi bi-book"></i> Admin Perpustakaan
    </span>
    <div class="ms-auto text-white">
        <?= $_SESSION['nama_admin']; ?>
        <a href="../logout.php" class="btn btn-sm btn-outline-light ms-3">
            Logout
        </a>
    </div>
</nav>

<div class="container py-4">

    <h4 class="mb-4">Dashboard</h4>

    <!-- INFO -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-people icon me-3"></i>
                    <div>
                        <small>Total User</small>
                        <h5><?= $total_user ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-book icon me-3"></i>
                    <div>
                        <small>Total Buku</small>
                        <h5><?= $total_buku ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-arrow-left-right icon me-3"></i>
                    <div>
                        <small>Total Peminjaman</small>
                        <h5><?= $total_pinjam ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MENU -->
    <div class="row g-4">
        <div class="col-md-4">
            <a href="buku.php" class="text-decoration-none text-dark">
                <div class="card p-4 text-center">
                    <i class="bi bi-book fs-3"></i>
                    <p class="mt-2 mb-0">Kelola Buku</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="peminjaman.php" class="text-decoration-none text-dark">
                <div class="card p-4 text-center">
                    <i class="bi bi-arrow-left-right fs-3"></i>
                    <p class="mt-2 mb-0">Data Peminjaman</p>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="user.php" class="text-decoration-none text-dark">
                <div class="card p-4 text-center">
                    <i class="bi bi-people fs-3"></i>
                    <p class="mt-2 mb-0">Data User</p>
                </div>
            </a>
        </div>
    </div>

</div>

</body>
</html>

<?php
session_start();
include "../koneksi.php";

// proteksi user
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* TOTAL PINJAM */
$q_pinjam = mysqli_query($koneksi,"
    SELECT COUNT(*) AS total_pinjam
    FROM peminjaman
    WHERE id_user='$id_user'
");
$total_pinjam = mysqli_fetch_assoc($q_pinjam)['total_pinjam'];

/* TOTAL DENDA */
$q_denda = mysqli_query($koneksi,"
    SELECT SUM(denda) AS total_denda
    FROM peminjaman
    WHERE id_user='$id_user'
");
$total_denda = mysqli_fetch_assoc($q_denda)['total_denda'] ?? 0;

/* RIWAYAT TERAKHIR */
$riwayat = mysqli_query($koneksi,"
    SELECT b.judul, p.tanggal_pinjam, p.tanggal_kembali, p.status, p.denda
    FROM peminjaman p
    JOIN buku b ON p.id_buku=b.id_buku
    WHERE p.id_user='$id_user'
    ORDER BY p.tanggal_pinjam DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard User | Perpustakaan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Merriweather:wght@300;400&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Merriweather',serif;
    min-height:100vh;
    background:linear-gradient(135deg,#1B3A2F,#4E342E);
    color:#1B3A2F;
}

/* NAVBAR */
.navbar-classic{
    background:#4E342E;
    color:#F5F1E8;
    padding:16px 30px;
    border-bottom:4px solid #6D2E2E;
}
.navbar-classic a{
    color:#F5F1E8;
    text-decoration:none;
}

/* CARD */
.card-classic{
    background:#F5F1E8;
    border:4px double #6D2E2E;
    border-radius:14px;
    padding:28px;
    box-shadow:0 25px 60px rgba(0,0,0,.4);
}

/* ICON */
.icon-box{
    width:54px;
    height:54px;
    border-radius:50%;
    background:#6D2E2E;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#F5F1E8;
    font-size:22px;
}

/* BADGE */
.badge-dipinjam{
    background:#C0A16B;
    color:#000;
}
.badge-kembali{
    background:#4CAF50;
    color:#fff;
}

/* BUTTON */
.btn-classic{
    background:#1B3A2F;
    color:#F5F1E8;
    border:none;
    border-radius:6px;
    padding:10px 16px;
    font-family:'Playfair Display',serif;
}
.btn-classic:hover{
    background:#6D2E2E;
    color:#F5F1E8;
}

table th{
    font-family:'Playfair Display',serif;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-classic d-flex justify-content-between">
    <span style="font-family:'Playfair Display',serif;font-size:20px;">
        📚 The Wonderlust Library
    </span>
    <a href="../logout.php">Logout</a>
</nav>

<div class="container py-5">

    <!-- HEADER -->
    <div class="text-center mb-5 text-light">
        <h3 style="font-family:'Playfair Display',serif;">
            Selamat Datang
        </h3>
        <h5 class="mt-2"><?= $_SESSION['nama']; ?></h5>
        <p class="opacity-75 mb-0">
            <?= $_SESSION['nim']; ?> | <?= $_SESSION['jurusan']; ?>
        </p>
    </div>

    <!-- SUMMARY -->
    <div class="row g-4 mb-5">

        <!-- TOTAL PINJAM -->
        <div class="col-md-4">
            <div class="card-classic">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3">📖</div>
                    <div>
                        <p class="mb-1 opacity-75">Total Peminjaman</p>
                        <h4><?= $total_pinjam ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOTAL DENDA -->
        <div class="col-md-4">
            <div class="card-classic">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3">💰</div>
                    <div>
                        <p class="mb-1 opacity-75">Total Denda</p>
                        <h4 class="text-danger">
                            Rp <?= number_format($total_denda,0,',','.') ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- MENU -->
        <div class="col-md-4">
            <div class="card-classic text-center">
                <a href="buku.php" class="btn btn-classic w-100 mb-2">
                    Katalog Buku
                </a>
                <a href="riwayat.php" class="btn btn-outline-dark w-100">
                    Riwayat Lengkap
                </a>
            </div>
        </div>

    </div>

    <!-- RIWAYAT -->
    <div class="card-classic">
        <h5 style="font-family:'Playfair Display',serif;">
            Riwayat Peminjaman Terakhir
        </h5>

        <?php if(mysqli_num_rows($riwayat)==0): ?>
            <p class="opacity-75 mt-3">
                Belum ada riwayat peminjaman.
            </p>
        <?php else: ?>
        <div class="table-responsive mt-3">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($r=mysqli_fetch_assoc($riwayat)): ?>
                    <tr>
                        <td><?= $r['judul']; ?></td>
                        <td><?= $r['tanggal_pinjam']; ?></td>
                        <td><?= $r['tanggal_kembali'] ?? '-'; ?></td>
                        <td>
                            <?php if($r['status']=='dipinjam'): ?>
                                <span class="badge badge-dipinjam">Dipinjam</span>
                            <?php else: ?>
                                <span class="badge badge-kembali">Kembali</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $r['denda'] > 0
                                ? "Rp ".number_format($r['denda'],0,',','.')
                                : "-" ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

</div>

</body>
</html>

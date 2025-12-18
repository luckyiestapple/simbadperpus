<?php
include "cek_admin.php";
include "../koneksi.php";

$buku = mysqli_query($koneksi,"SELECT * FROM buku ORDER BY id_buku DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin | Data Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h4>📚 Data Buku</h4>

    <a href="buku_tambah.php" class="btn btn-primary mb-3">
        + Tambah Buku
    </a>

    <table class="table table-bordered bg-white">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th width="160">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; while($b=mysqli_fetch_assoc($buku)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($b['judul']) ?></td>
                <td><?= htmlspecialchars($b['penulis']) ?></td>
                <td><?= htmlspecialchars($b['penerbit']) ?></td>
                <td><?= htmlspecialchars($b['tahun']) ?></td>
                <td><?= $b['stok'] ?></td>
                <td>
                    <a href="buku_edit.php?id=<?= $b['id_buku'] ?>"
                       class="btn btn-warning btn-sm">Edit</a>
                    <a href="buku_hapus.php?id=<?= $b['id_buku'] ?>"
                       onclick="return confirm('Hapus buku ini?')"
                       class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">⬅ Kembali</a>
</div>

</body>
</html>

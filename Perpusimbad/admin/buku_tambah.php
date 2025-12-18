<?php
include "cek_admin.php";
include "../koneksi.php";

if(isset($_POST['simpan'])){
    $judul   = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $penerbit = trim($_POST['penerbit']);
    $tahun = trim($_POST['tahun']);
    $stok    = (int) $_POST['stok'];

    if($judul=="" || $penulis=="" ||$penerbit=="" || $tahun=="" || $stok < 0){
        $error = "Data tidak valid";
    } else {
        mysqli_query($koneksi,"
            INSERT INTO buku (judul, penulis, penerbit, tahun, stok)
            VALUES ('$judul','$penulis','$penerbit', '$tahun', '$stok')
        ");
        header("Location: buku.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width:500px;">
    <h4>Tambah Buku</h4>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="judul" class="form-control mb-2"
               placeholder="Judul Buku" required>
        <input type="text" name="penulis" class="form-control mb-2"
               placeholder="Penulis" required>
        <input type="text" name="penerbit" class="form-control mb-2"
               placeholder="Penerbit" required>
        <input type="text" name="tahun" class="form-control mb-2"
               placeholder="Tahun" required>
        <input type="number" name="stok" class="form-control mb-3"
               placeholder="Stok" min="0" required>

        <button name="simpan" class="btn btn-primary w-100">
            Simpan
        </button>
    </form>

    <a href="buku.php" class="btn btn-secondary mt-3">⬅ Kembali</a>
</div>

</body>
</html>

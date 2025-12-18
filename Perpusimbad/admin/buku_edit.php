<?php
include "cek_admin.php";
include "../koneksi.php";

$id = $_GET['id'];
$data = mysqli_fetch_assoc(
    mysqli_query($koneksi,"SELECT * FROM buku WHERE id_buku='$id'")
);

if(isset($_POST['update'])){
    $judul   = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $stok    = (int) $_POST['stok'];

    mysqli_query($koneksi,"
        UPDATE buku SET
        judul='$judul',
        penulis='$penulis',
        stok='$stok'
        WHERE id_buku='$id'
    ");
    header("Location: buku.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width:500px;">
    <h4>Edit Buku</h4>

    <form method="POST">
        <input type="text" name="judul" class="form-control mb-2"
               value="<?= htmlspecialchars($data['judul']) ?>" required>
        <input type="text" name="penulis" class="form-control mb-2"
               value="<?= htmlspecialchars($data['penulis']) ?>" required>
        <input type="number" name="stok" class="form-control mb-3"
               value="<?= $data['stok'] ?>" min="0" required>

        <button name="update" class="btn btn-warning w-100">
            Update
        </button>
    </form>

    <a href="buku.php" class="btn btn-secondary mt-3">⬅ Kembali</a>
</div>

</body>
</html>

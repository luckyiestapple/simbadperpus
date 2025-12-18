<?php
session_start();
include "cek_user.php";
include "../koneksi.php";

$id_user = $_SESSION['id_user'];

/* ===== CEK TOTAL DENDA USER ===== */
$q_denda = mysqli_query($koneksi,"
    SELECT SUM(denda) AS total_denda
    FROM peminjaman
    WHERE id_user='$id_user'
");
$row_denda = mysqli_fetch_assoc($q_denda);
$total_denda = $row_denda['total_denda'] ?? 0;

/* ===== SEARCH & PAGINATION ===== */
$limit = 6;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$search_sql = mysqli_real_escape_string($koneksi, $search);

$where = "WHERE stok >= 0";
if ($search !== "") {
    $where .= " AND (judul LIKE '%$search_sql%' OR penulis LIKE '%$search_sql%')";
}

/* ===== TOTAL DATA ===== */
$q_total = mysqli_query($koneksi,"
    SELECT COUNT(*) AS total FROM buku $where
");
$total_data = mysqli_fetch_assoc($q_total)['total'];
$total_page = ceil($total_data / $limit);

/* ===== DATA BUKU ===== */
$buku = mysqli_query($koneksi,"
    SELECT * FROM buku
    $where
    ORDER BY id_buku DESC
    LIMIT $limit OFFSET $offset
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Katalog Buku | Perpustakaan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Merriweather:wght@300;400&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Merriweather',serif;
    background:linear-gradient(135deg,#1B3A2F,#4E342E);
    min-height:100vh;
    color:#1B3A2F;
}
.page-box{
    background:#F5F1E8;
    border:5px double #6D2E2E;
    border-radius:14px;
    padding:30px;
    box-shadow:0 30px 70px rgba(0,0,0,.5);
}
.card-buku{
    background:#EFE7DA;
    border:2px solid #6D2E2E;
    border-radius:10px;
    height:100%;
}
.card-buku h6{
    font-family:'Playfair Display',serif;
}
.btn-classic{
    background:#1B3A2F;
    color:#F5F1E8;
    border:none;
    border-radius:6px;
    font-family:'Playfair Display',serif;
}
.btn-classic:hover{
    background:#6D2E2E;
    color:#F5F1E8;
}
.btn-disabled{
    background:#9CA3AF;
    color:#111827;
    border:none;
    border-radius:6px;
}
.pagination .page-link{
    color:#805A46;
}
.pagination .active .page-link{
    background:#6D2E2E;
    border-color:#6D2E2E;
}
</style>
</head>
<body>

<div class="container py-5">
<div class="page-box">

    <h4 class="mb-3" style="font-family:'Playfair Display',serif;">
        📚 Katalog Buku
    </h4>

    <!-- INFO DENDA -->
    <?php if($total_denda > 0): ?>
        <div class="alert alert-warning">
            ⚠️ Kamu memiliki denda sebesar
            <b>Rp <?= number_format($total_denda,0,',','.') ?></b>.
            Silakan lunasi denda terlebih dahulu sebelum meminjam buku.
        </div>
    <?php endif; ?>

    <!-- SEARCH -->
    <form class="d-flex gap-2 my-3" method="GET">
        <input type="text" name="search" class="form-control"
               placeholder="Cari judul / penulis..."
               value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-classic">Search</button>
        <a href="buku.php" class="btn btn-outline-secondary">Reset</a>
    </form>

    <!-- LIST BUKU -->
    <div class="row g-4">
        <?php if(mysqli_num_rows($buku) == 0): ?>
            <p class="opacity-75">Data buku tidak ditemukan.</p>
        <?php endif; ?>

        <?php while($b = mysqli_fetch_assoc($buku)): ?>
        <div class="col-md-4">
            <div class="card-buku p-3">
                <h6 class="mb-1"><?= htmlspecialchars($b['judul']) ?></h6>
                <small class="opacity-75">
                    Penulis: <?= htmlspecialchars($b['penulis']) ?>
                </small>

                <p class="mt-2 mb-3">
                    Stok: <b><?= $b['stok'] ?></b>
                </p>

                <?php if($total_denda > 0): ?>
                    <button class="btn btn-disabled w-100" disabled>
                        Lunasi Denda
                    </button>

                <?php elseif($b['stok'] > 0): ?>
                  <a href="pinjam.php?id=<?= $b['id_buku'] ?>"
   class="btn btn-classic w-100"
   onclick="return confirmPinjam();">
   Pinjam
</a>


                <?php else: ?>
                    <button class="btn btn-danger w-100" disabled>
                        Stok Habis
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- PAGINATION -->
    <?php if($total_page > 1): ?>
    <nav class="mt-4">
        <ul class="pagination">
            <?php for($i=1; $i<=$total_page; $i++): ?>
                <li class="page-item <?= ($i==$page) ? 'active' : '' ?>">
                    <a class="page-link"
                       href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>

    <a href="dashboard_user.php" class="btn btn-outline-secondary mt-3">
        ⬅ Kembali ke Dashboard
    </a>

</div>
</div>
<script>
function confirmPinjam(){
    return confirm(
        "📚 Batas peminjaman: 5 hari\n" +
        "💰 Denda keterlambatan: Rp 2.000 / hari\n\n" +
        "Lanjutkan peminjaman?"
    );
}
</script>

</body>
</html>

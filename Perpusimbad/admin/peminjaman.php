<?php
include "cek_admin.php";
include "../koneksi.php";

/* ===== SEARCH + PAGINATION ===== */
$limit = 5;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page  = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$search_sql = mysqli_real_escape_string($koneksi, $search);

$where = "";
if ($search !== "") {
    $where = "WHERE u.nama LIKE '%$search_sql%'
              OR b.judul LIKE '%$search_sql%'
              OR p.status LIKE '%$search_sql%'";
}

/* ===== TOTAL DATA ===== */
$q_total = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total
    FROM peminjaman p
    JOIN users u ON p.id_user = u.id_user
    JOIN buku b ON p.id_buku = b.id_buku
    $where
");
$total_data = mysqli_fetch_assoc($q_total)['total'];
$total_page = ceil($total_data / $limit);

/* ===== DATA PEMINJAMAN ===== */
$data = mysqli_query($koneksi, "
    SELECT p.id_pinjam, p.id_user, u.nama, u.nim,
           b.judul, p.tanggal_pinjam, p.tanggal_kembali,
           p.status, p.denda
    FROM peminjaman p
    JOIN users u ON p.id_user = u.id_user
    JOIN buku b ON p.id_buku = b.id_buku
    $where
    ORDER BY p.tanggal_pinjam DESC
    LIMIT $limit OFFSET $offset
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin | Laporan Peminjaman</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
body{background:#0f172a;color:white;font-family:Poppins,sans-serif;}
.card{background:#1e293b;border:none;}
.badge-dipinjam{background:#facc15;color:#000;}
.badge-kembali{background:#22c55e;color:#000;}
</style>
</head>
<body>

<div class="container py-4">
    <h4 class="mb-3">📑 Laporan Peminjaman</h4>

    <!-- SEARCH -->
    <form class="d-flex gap-2 mb-3" method="GET">
        <input type="text" name="search" class="form-control"
               placeholder="Cari user / buku / status..."
               value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-primary">Search</button>
        <a href="peminjaman.php" class="btn btn-secondary">Reset</a>
    </form>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-dark table-bordered align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Buku</th>
                    <th>Pinjam</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi Buku</th>
                    <th>Aksi Denda</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if(mysqli_num_rows($data) == 0){
                echo "<tr><td colspan='10' class='text-center'>Data tidak ditemukan</td></tr>";
            }
            $no = $offset + 1;
            while($r = mysqli_fetch_assoc($data)):
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($r['nama']) ?></td>
                    <td><?= htmlspecialchars($r['nim']) ?></td>
                    <td><?= htmlspecialchars($r['judul']) ?></td>
                    <td><?= $r['tanggal_pinjam'] ?></td>
                    <td><?= $r['tanggal_kembali'] ?? '-' ?></td>
                    <td>
                        <?php if($r['status']=='dipinjam'): ?>
                            <span class="badge badge-dipinjam">Dipinjam</span>
                        <?php else: ?>
                            <span class="badge badge-kembali">Kembali</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($r['denda'] > 0): ?>
                            <span class="text-danger fw-semibold">
                                Rp <?= number_format($r['denda'],0,',','.') ?>
                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($r['status']=='dipinjam'): ?>
                            <a href="kembali.php?id=<?= $r['id_pinjam'] ?>"
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Kembalikan buku ini?')">
                                Kembalikan
                            </a>
                        <?php else: ?>
                            
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($r['denda'] > 0): ?>
                            <a href="lunas_denda.php?id_user=<?= $r['id_user'] ?>"
                               class="btn btn-warning btn-sm"
                               onclick="return confirm('Lunasi semua denda user ini?')">
                                Lunasi
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <?php if($total_page > 1): ?>
    <nav>
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

    <a href="dashboard.php" class="btn btn-outline-light mt-3">⬅ Kembali</a>
</div>

</body>
</html>

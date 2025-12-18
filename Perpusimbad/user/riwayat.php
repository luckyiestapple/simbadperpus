<?php
include "cek_user.php";
include "../koneksi.php";

$id_user = $_SESSION['id_user'];
$batas_pinjam = 7;       // hari
$denda_per_hari = 2000;  // Rp

$data = mysqli_query($koneksi,"
    SELECT 
        b.judul,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status
    FROM peminjaman p
    JOIN buku b ON p.id_buku = b.id_buku
    WHERE p.id_user='$id_user'
    ORDER BY p.tanggal_pinjam DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Peminjaman</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Libre+Baskerville&display=swap" rel="stylesheet">

<style>
body{
    background:#2b2b2b;
    color:#2f1e13;
    font-family:'Libre Baskerville',serif;
    padding:40px;
}
.wrapper{
    background:#f5f1eb;
    border:4px solid #8d6e63;
    padding:35px;
    max-width:900px;
    margin:auto;
    box-shadow:0 20px 40px rgba(0,0,0,.4);
}
h2{
    font-family:'Playfair Display',serif;
    text-align:center;
    margin-bottom:30px;
}
table{
    width:100%;
    border-collapse:collapse;
    font-size:14px;
}
th{
    background:#6d4c41;
    color:#fff;
    padding:10px;
    border:2px solid #5d4037;
}
td{
    padding:10px;
    border:2px solid #a1887f;
    background:#fffaf4;
    text-align:center;
}
.status-pinjam{
    color:#b45309;
    font-weight:bold;
}
.status-kembali{
    color:#166534;
    font-weight:bold;
}
.denda{
    color:#991b1b;
    font-weight:bold;
}
.back{
    margin-top:25px;
    display:inline-block;
    text-decoration:none;
    color:#5d4037;
    font-weight:bold;
}
.back:hover{
    text-decoration:underline;
}
</style>
</head>
<body>

<div class="wrapper">
    <h2>Riwayat Peminjaman Buku</h2>

    <table>
        <tr>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Denda</th>
        </tr>

        <?php while($r = mysqli_fetch_assoc($data)): ?>
        <?php
            $tgl_pinjam = new DateTime($r['tanggal_pinjam']);

            if($r['status'] == 'kembali' && $r['tanggal_kembali']){
                $tgl_kembali = new DateTime($r['tanggal_kembali']);
            } else {
                $tgl_kembali = new DateTime();
            }

            $lama = $tgl_pinjam->diff($tgl_kembali)->days;
            $terlambat = max(0, $lama - $batas_pinjam);
            $denda = $terlambat * $denda_per_hari;
        ?>
        <tr>
            <td><?= htmlspecialchars($r['judul']) ?></td>
            <td><?= $r['tanggal_pinjam'] ?></td>
            <td><?= $r['tanggal_kembali'] ?? '-' ?></td>
            <td class="<?= $r['status']=='dipinjam' ? 'status-pinjam' : 'status-kembali' ?>">
                <?= $r['status'] ?>
            </td>
            <td class="denda">
                <?= $denda > 0 ? 'Rp '.number_format($denda,0,',','.') : '-' ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="dashboard_user.php" class="back">← Kembali ke Dashboard</a>
</div>

</body>
</html>

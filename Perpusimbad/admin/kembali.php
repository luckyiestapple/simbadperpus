<?php
include "cek_admin.php";
include "../koneksi.php";

$id = $_GET['id'];

// ambil data peminjaman
$data = mysqli_fetch_assoc(
    mysqli_query($koneksi, "
        SELECT * FROM peminjaman WHERE id_pinjam='$id'
    ")
);

$tgl_pinjam  = $data['tanggal_pinjam'];
$tgl_kembali = date('Y-m-d');

// hitung lama pinjam (hari)
$hari_pinjam = (strtotime($tgl_kembali) - strtotime($tgl_pinjam)) / (60 * 60 * 24);

// aturan denda
$batas_hari = 5;
$denda_per_hari = 2000;

// hitung denda
if ($hari_pinjam > $batas_hari) {
    $denda = ($hari_pinjam - $batas_hari) * $denda_per_hari;
} else {
    $denda = 0;
}

// update peminjaman
mysqli_query($koneksi, "
    UPDATE peminjaman SET
        status='kembali',
        tanggal_kembali='$tgl_kembali',
        denda='$denda'
    WHERE id_pinjam='$id'
");

// kembalikan stok buku
mysqli_query($koneksi, "
    UPDATE buku SET stok = stok + 1
    WHERE id_buku='{$data['id_buku']}'
");

// kembali ke laporan
header("Location: peminjaman.php");
exit;

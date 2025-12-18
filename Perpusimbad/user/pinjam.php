<?php
session_start();
include "cek_user.php";
include "../koneksi.php";

$id_user = $_SESSION['id_user'];

/* ================= VALIDASI ID BUKU ================= */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: buku.php?msg=invalid");
    exit;
}

$id_buku = (int) $_GET['id'];

/* ================= CEK TOTAL DENDA USER ================= */
$q_denda = mysqli_query($koneksi,"
    SELECT SUM(denda) AS total_denda
    FROM peminjaman
    WHERE id_user='$id_user'
");
$row_denda = mysqli_fetch_assoc($q_denda);
$total_denda = $row_denda['total_denda'] ?? 0;

if ($total_denda > 0) {
    header("Location: buku.php?msg=denda");
    exit;
}

/* ================= CEK DATA BUKU ================= */
$q_buku = mysqli_query($koneksi,"
    SELECT * FROM buku WHERE id_buku='$id_buku'
");
$buku = mysqli_fetch_assoc($q_buku);

if (!$buku) {
    header("Location: buku.php?msg=notfound");
    exit;
}

/* ================= CEK STOK ================= */
if ($buku['stok'] <= 0) {
    header("Location: buku.php?msg=habis");
    exit;
}

/* ================= PROSES PINJAM ================= */
$tgl_pinjam = date('Y-m-d');

$insert = mysqli_query($koneksi,"
    INSERT INTO peminjaman (id_user, id_buku, tanggal_pinjam, status, denda)
    VALUES ('$id_user','$id_buku','$tgl_pinjam','dipinjam',0)
");

if ($insert) {
    // kurangi stok
    mysqli_query($koneksi,"
        UPDATE buku SET stok = stok - 1
        WHERE id_buku='$id_buku'
    ");

    header("Location: buku.php?msg=sukses");
    exit;
} else {
    header("Location: buku.php?msg=gagal");
    exit;
}

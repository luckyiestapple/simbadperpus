<?php
include "cek_admin.php";
include "../koneksi.php";

$id_user = $_GET['id_user'];

// set semua denda user = 0
mysqli_query($koneksi, "
    UPDATE peminjaman
    SET denda = 0
    WHERE id_user = '$id_user'
");

// kembali ke laporan
header("Location: peminjaman.php");
exit;

<?php
include "koneksi.php";
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
    <input type="text" id="search" class="form-control mb-3"
           placeholder="Cari nama / buku / status...">

    <!-- HASIL -->
    <div id="result"></div>

    <a href="dashboard.php" class="btn btn-outline-light mt-3">⬅ Kembali</a>
</div>

<script>
const searchInput = document.getElementById("search");
const resultBox  = document.getElementById("result");

function loadData(keyword = "") {
    fetch("ajax_peminjaman.php?search=" + encodeURIComponent(keyword))
        .then(res => res.text())
        .then(data => {
            resultBox.innerHTML = data;
        });
}

searchInput.addEventListener("keyup", function(){
    loadData(this.value);
});

// load awal
loadData();
</script>

</body>
</html>

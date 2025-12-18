<?php
session_start();

// hapus semua session
$_SESSION = [];
session_destroy();

// balik ke login
header("Location: index.php");
exit;

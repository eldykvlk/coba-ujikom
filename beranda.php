<?php
require 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Beranda</title>
</head>
<body>
    <h1>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
    <ul>
        <li><a href="peminjam.php">Peminjam</a></li>
        <li><a href="stok_buku.php">Stok Buku</a></li>
        <li><a href="transaksi.php">Transaksi</a></li>
    </ul>
    <form method="post" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</body>
</html>

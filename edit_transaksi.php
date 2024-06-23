<?php
include 'koneksi.php';
require 'header.php';

$id = $_GET['id'];
$transaction = $conn->query("SELECT * FROM transaksi WHERE id=$id")->fetch_assoc();
$peminjams = $conn->query("SELECT * FROM peminjam");
$books = $conn->query("SELECT * FROM stok_buku");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $id_peminjam = $_POST['id_peminjam'];
        $id_buku = $_POST['id_buku'];
        $jumlah_pinjam = $_POST['jumlah_pinjam'];
        $tanggal_pinjam = $_POST['tanggal_pinjam'];

        // Cek stok buku
        $result = $conn->query("SELECT jumlah FROM stok_buku WHERE id = $id_buku");
        $row = $result->fetch_assoc();
        if ($row['jumlah'] < $jumlah_pinjam) {
            echo "Jumlah pinjaman melebihi stok yang tersedia!";
        } else {
            $sql = "UPDATE transaksi SET id_peminjam='$id_peminjam', id_buku='$id_buku', jumlah_pinjam='$jumlah_pinjam', tanggal_pinjam='$tanggal_pinjam' WHERE id=$id";
            if ($conn->query($sql)) {
                // Perbarui stok buku
                $conn->query("UPDATE stok_buku SET jumlah = jumlah - $jumlah_pinjam WHERE id = $id_buku");
            }
            header("Location: transaksi.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaksi</title>
</head>
<body>
    <h1>Edit Transaksi</h1>
    <form method="post" action="">
        Peminjam:
        <select name="id_peminjam" required>
            <?php while ($row = $peminjams->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $transaction['id_peminjam']) echo 'selected'; ?>><?php echo $row['nama']; ?></option>
            <?php endwhile; ?>
        </select>
        Buku:
        <select name="id_buku" required>
            <?php
            $books = $conn->query("SELECT * FROM stok_buku");
            while ($row = $books->fetch_assoc()):
                if ($row['jumlah'] > 0 || $row['id'] == $transaction['id_buku']): ?>
                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $transaction['id_buku']) echo 'selected'; ?>><?php echo $row['judul']; ?></option>
                <?php else: ?>
                    <option value="<?php echo $row['id']; ?>" disabled><?php echo $row['judul']; ?> (Habis)</option>
                <?php endif;
            endwhile; ?>
        </select>
        Jumlah Pinjam: <input type="number" name="jumlah_pinjam" min="1" value="<?php echo $transaction['jumlah_pinjam']; ?>" required>
        Tanggal Pinjam: <input type="date" name="tanggal_pinjam" value="<?php echo $transaction['tanggal_pinjam']; ?>" required>
        <button type="submit" name="update">Simpan</button>
    </form>
</body>
</html>

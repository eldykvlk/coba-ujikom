<?php
include 'koneksi.php';
require 'header.php';

$peminjams = $conn->query("SELECT * FROM peminjam");
$books = $conn->query("SELECT * FROM stok_buku");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
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
            $sql = "INSERT INTO transaksi (id_peminjam, id_buku, jumlah_pinjam, tanggal_pinjam) 
                    VALUES ('$id_peminjam', '$id_buku', '$jumlah_pinjam', '$tanggal_pinjam')";
            if ($conn->query($sql)) {
                // Kurangi stok buku
                $conn->query("UPDATE stok_buku SET jumlah = jumlah - $jumlah_pinjam WHERE id = $id_buku");
            }
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $result = $conn->query("SELECT id_buku, jumlah_pinjam FROM transaksi WHERE id = $id");
        $row = $result->fetch_assoc();
        $id_buku = $row['id_buku'];
        $jumlah_pinjam = $row['jumlah_pinjam'];
        $sql = "DELETE FROM transaksi WHERE id=$id";
        if ($conn->query($sql)) {
            // Kembalikan stok buku
            $conn->query("UPDATE stok_buku SET jumlah = jumlah + $jumlah_pinjam WHERE id = $id_buku");
        }
    }
}

$transactions = $conn->query("SELECT transaksi.*, peminjam.nama, stok_buku.judul FROM transaksi
                                JOIN peminjam ON transaksi.id_peminjam = peminjam.id
                                JOIN stok_buku ON transaksi.id_buku = stok_buku.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi</title>
</head>
<body>
    <h1>Transaksi</h1>
    <form method="post" action="">
        Peminjam:
        <select name="id_peminjam" required>
            <?php while ($row = $peminjams->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
            <?php endwhile; ?>
        </select>
        Buku:
        <select name="id_buku" required>
            <?php
            $books = $conn->query("SELECT * FROM stok_buku");
            while ($row = $books->fetch_assoc()):
                if ($row['jumlah'] > 0): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['judul']; ?></option>
                <?php else: ?>
                    <option value="<?php echo $row['id']; ?>" disabled><?php echo $row['judul']; ?> (Habis)</option>
                <?php endif;
            endwhile; ?>
        </select>
        Jumlah Pinjam: <input type="number" name="jumlah_pinjam" min="1" required>
        Tanggal Pinjam: <input type="date" name="tanggal_pinjam" required>
        <button type="submit" name="add">Tambah</button>
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Peminjam</th>
            <th>Buku</th>
            <th>Jumlah Pinjam</th>
            <th>Tanggal Pinjam</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $transactions->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['judul']; ?></td>
            <td><?php echo $row['jumlah_pinjam']; ?></td>
            <td><?php echo $row['tanggal_pinjam']; ?></td>
            <td>
                <form method="get" action="edit_transaksi.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Edit</button>
                </form>
                <form method="post" action="" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

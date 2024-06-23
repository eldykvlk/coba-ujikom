<?php
include 'koneksi.php';
require 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $jumlah = $_POST['jumlah'];
        $sql = "INSERT INTO stok_buku (judul, penulis, jumlah) VALUES ('$judul', '$penulis', '$jumlah')";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM stok_buku WHERE id=$id";
        $conn->query($sql);
    }
}

$books = $conn->query("SELECT * FROM stok_buku");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stok Buku</title>
</head>
<body>
    <h1>Stok Buku</h1>
    <form method="post" action="">
        Judul: <input type="text" name="judul" required>
        Penulis: <input type="text" name="penulis">
        Jumlah: <input type="number" name="jumlah" required>
        <button type="submit" name="add">Tambah</button>
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $books->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['judul']; ?></td>
            <td><?php echo $row['penulis']; ?></td>
            <td><?php echo $row['jumlah']; ?></td>
            <td>
                <form method="get" action="edit_stok_buku.php" style="display:inline;">
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

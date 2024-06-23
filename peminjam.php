<?php
include 'koneksi.php';
require 'header.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $sql = "INSERT INTO peminjam (nama, alamat) VALUES ('$nama', '$alamat')";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM peminjam WHERE id=$id";
        $conn->query($sql);
    }
}

$peminjams = $conn->query("SELECT * FROM peminjam");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Peminjam</title>
</head>
<body>
    <h1>Peminjam</h1>
    <form method="post" action="">
        Nama: <input type="text" name="nama" required>
        Alamat: <input type="text" name="alamat">
        <button type="submit" name="add">Tambah</button>
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $peminjams->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td>
                <form method="get" action="edit_peminjam.php" style="display:inline;">
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

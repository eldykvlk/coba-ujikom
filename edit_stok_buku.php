<?php
include 'koneksi.php';
require 'header.php';

$id = $_GET['id'];
$book = $conn->query("SELECT * FROM stok_buku WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $jumlah = $_POST['jumlah'];
        $sql = "UPDATE stok_buku SET judul='$judul', penulis='$penulis', jumlah='$jumlah' WHERE id=$id";
        $conn->query($sql);
        header("Location: stok_buku.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Stok Buku</title>
</head>
<body>
    <h1>Edit Stok Buku</h1>
    <form method="post" action="">
        Judul: <input type="text" name="judul" value="<?php echo $book['judul']; ?>" required>
        Penulis: <input type="text" name="penulis" value="<?php echo $book['penulis']; ?>">
        Jumlah: <input type="number" name="jumlah" value="<?php echo $book['jumlah']; ?>" required>
        <button type="submit" name="update">Simpan</button>
    </form>
</body>
</html>

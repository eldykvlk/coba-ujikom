<?php
include 'koneksi.php';
require 'header.php';

$id = $_GET['id'];
$peminjam = $conn->query("SELECT * FROM peminjam WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $sql = "UPDATE peminjam SET nama='$nama', alamat='$alamat' WHERE id=$id";
        $conn->query($sql);
        header("Location: peminjam.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Peminjam</title>
</head>
<body>
    <h1>Edit Peminjam</h1>
    <form method="post" action="">
        Nama: <input type="text" name="nama" value="<?php echo $peminjam['nama']; ?>" required>
        Alamat: <input type="text" name="alamat" value="<?php echo $peminjam['alamat']; ?>">
        <button type="submit" name="update">Simpan</button>
    </form>
</body>
</html>

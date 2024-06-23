<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Menggunakan MD5 untuk hashing password

    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: beranda.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        Username: <input type="text" name="username" required>
        Password: <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>

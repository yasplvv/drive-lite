<?php
include '../config/db.php';

if ($_POST) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // <-- DIUBAH: TIDAK DI-HASH

    $conn->query("INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')");
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="container">
<h2>Register</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button class="btn">Register</button>
</form>
<a href="login.php">Login</a>
</div>
</body>
</html>

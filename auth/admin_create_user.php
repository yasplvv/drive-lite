<?php
include '../middleware/auth_check.php';
include '../config/db.php';
if ($_SESSION['user']['role'] !== 'admin') die('Forbidden');

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password']; // sesuai request: NO HASH
$role = $_POST['role'];

$conn->query("INSERT INTO users (username,email,password,role)
VALUES ('$username','$email','$password','$role')");

header('Location: ../dashboard/admin.php');
exit;
?>

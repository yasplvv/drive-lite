<?php
include '../middleware/auth_check.php';
include '../config/db.php';
if ($_SESSION['user']['role'] !== 'admin') die('Forbidden');

$id = intval($_GET['id']);
$f = $conn->query("SELECT is_public FROM files WHERE id=$id")->fetch_assoc();
$new = $f['is_public'] ? 0 : 1;

$conn->query("UPDATE files SET is_public=$new WHERE id=$id");
header('Location: ../dashboard/admin.php');
exit;
?>

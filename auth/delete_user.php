<?php
include '../middleware/auth_check.php';
include '../config/db.php';
if ($_SESSION['user']['role'] !== 'admin') die('Forbidden');

$id = intval($_GET['id']);

$files = $conn->query("SELECT filepath FROM files WHERE user_id=$id");
while($f = $files->fetch_assoc()){
    if (file_exists($f['filepath'])) unlink($f['filepath']);
}

$conn->query("DELETE FROM file_access WHERE user_id=$id");
$conn->query("DELETE FROM files WHERE user_id=$id");
$conn->query("DELETE FROM users WHERE id=$id");

header('Location: ../dashboard/admin.php');
exit;
?>

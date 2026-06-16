<?php
include '../middleware/auth_check.php';
include '../config/db.php';

$id = $_GET['id'];
$user = $_SESSION['user'];

$file = $conn->query("SELECT * FROM files WHERE id=$id")->fetch_assoc();

if (!$file) die('File tidak ditemukan');

$allowed = false;

if ($user['role'] == 'admin') {
    $allowed = true;
} elseif ($file['user_id'] == $user['id']) {
    $allowed = true;
}

if (!$allowed) {
    echo "<script>
        alert('Kamu tidak punya izin menghapus file ini');
        window.location.href = '../dashboard/user.php';
    </script>";
    exit;
}


if (file_exists($file['filepath'])) {
    unlink($file['filepath']);
}

$conn->query("DELETE FROM files WHERE id=$id");
$conn->query("DELETE FROM file_access WHERE file_id=$id");

header('Location: ../dashboard/' . $user['role'] . '.php');
?>
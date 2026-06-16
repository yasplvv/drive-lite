<?php
include '../middleware/auth_check.php';
include '../config/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

$file = $conn->query("SELECT * FROM files WHERE id=$id")->fetch_assoc();

if (!$file) {
    die("File tidak ditemukan");
}

$allowed = false;

// admin bebas
if ($role == 'admin') {
    $allowed = true;
}

// owner
if ($file['user_id'] == $user_id) {
    $allowed = true;
}

// public
if ($file['is_public']) {
    $allowed = true;
}

// akses khusus
$access = $conn->query("
    SELECT * FROM file_access 
    WHERE file_id=$id AND user_id=$user_id
");
if ($access->num_rows > 0) {
    $allowed = true;
}

if (!$allowed) {
    die("Akses ditolak");
}

// download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file['filename']) . '"');
header('Content-Length: ' . filesize($file['filepath']));
readfile($file['filepath']);
exit;
?>

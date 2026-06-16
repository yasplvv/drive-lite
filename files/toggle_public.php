<?php
include '../middleware/auth_check.php';
include '../config/db.php';

$file_id = intval($_GET['id']);
$user_id = $_SESSION['user']['id'];

$file = $conn->query("SELECT * FROM files WHERE id=$file_id")->fetch_assoc();

if (!$file) {
    echo "<script>
        alert('File tidak ditemukan');
        window.history.back();
    </script>";
    exit;
}

// bukan pemilik file
if ($file['user_id'] != $user_id) {
    echo "<script>
        alert('Akses ditolak! Ini bukan file kamu.');
        window.history.back();
    </script>";
    exit;
}

// toggle
$new_status = $file['is_public'] ? 0 : 1;
$conn->query("UPDATE files SET is_public=$new_status WHERE id=$file_id");

header("Location: ../dashboard/user.php");
exit;
?>

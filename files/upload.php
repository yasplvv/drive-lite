<?php
include '../middleware/auth_check.php';
include '../config/db.php';

$user_id = $_SESSION['user']['id'];

if (isset($_FILES['file'])) {

    $name = basename($_FILES['file']['name']);
    $tmp  = $_FILES['file']['tmp_name'];

    $newName = time() . '_' . $name;
    $path = '../uploads/' . $newName;

    // public / private
    $is_public = isset($_POST['is_public']) ? 1 : 0;

    if (move_uploaded_file($tmp, $path)) {
        $conn->query("
            INSERT INTO files (user_id, filename, filepath, is_public)
            VALUES ($user_id, '$name', '$path', $is_public)
        ");
    }

    header('Location: ../dashboard/user.php');
    exit;
}
?>

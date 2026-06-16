
<?php
$conn = new mysqli("localhost", "root", "", "drive_lite");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

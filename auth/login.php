<?php
session_start();
include '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE username='$username'");

    if ($res && $res->num_rows === 1) {
        $user = $res->fetch_assoc();

        // PASSWORD POLOS (TANPA HASH)
        if ($password === $user['password']) {
            $_SESSION['user'] = $user;
            header('Location: ../dashboard/' . $user['role'] . '.php');
            exit;
        } else {
            $error = 'Password salah';
        }
    } else {
        $error = 'User tidak ditemukan';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Drive‑Lite</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            color: #111827;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 2rem;
        }

        p.error {
            color: #dc2626; /* merah tegas */
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        button.btn {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: #2563eb;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }

        button.btn:hover {
            background: #1d4ed8;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #2563eb;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>

    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="btn">Login</button>
    </form>

    <a href="register.php">Belum punya akun? Register</a>
</div>
</body>
</html>

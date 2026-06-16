<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Drive‑Lite</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Reset sederhana */
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            color: #111827; /* teks hitam tegas */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            background: #fff;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 500px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: #1f2937;
        }

        .btn {
            display: inline-block;
            margin: 10px 8px;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            color: #fff;
            background: #2563eb;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        /* Tombol logout / secondary */
        .btn.logout {
            background: #ef4444;
        }
        .btn.logout:hover {
            background: #dc2626;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📁 Drive‑Lite</h1>
    <p>Penyimpanan file ringan berbasis web.</p>

    <?php if(isset($_SESSION['user'])): ?>
        <a href="dashboard/<?=$_SESSION['user']['role']?>.php" class="btn">Dashboard</a>
        <a href="auth/logout.php" class="btn logout">Logout</a>
    <?php else: ?>
        <a href="auth/login.php" class="btn">Login</a>
        <a href="auth/register.php" class="btn logout">Register</a>
    <?php endif; ?>
</div>
</body>
</html>

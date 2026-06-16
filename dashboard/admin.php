<?php
include '../middleware/auth_check.php';
include '../config/db.php';

if ($_SESSION['user']['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak'); location.href='../index.php';</script>";
    exit;
}

$users = $conn->query("SELECT * FROM users ORDER BY id DESC");
$files = $conn->query("
    SELECT files.*, users.username
    FROM files
    JOIN users ON users.id = files.user_id
    ORDER BY files.upload_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
    background: #f4f6f8;
    font-family: 'Segoe UI', sans-serif;
    color: #111827; /* hitam kebiruan (tajam) */
}

h1, h2, h3, h4 {
    color: #111827;
}

p, td, th, span, small, a {
    color: #1f2937;
}

        .wrapper {
            max-width: 1100px;
            margin: 30px auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #111827;
            color: white;
            padding: 20px;
            border-radius: 12px;
        }
        .header a {
            color: white;
            text-decoration: none;
            background: #ef4444;
            padding: 8px 14px;
            border-radius: 8px;
        }
        .card {
            background: white;
            margin-top: 25px;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,.05);
        }
        h3 {
            margin-bottom: 15px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f1f5f9;
            text-align: left;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }
        .public { background: #dcfce7; color: #166534; }
        .private { background: #fee2e2; color: #991b1b; }
        .action a {
            margin-right: 8px;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <div class="header">
        <div>
            <h2>🛠️ Admin Panel</h2>
            <small>Login sebagai <b><?= htmlspecialchars($_SESSION['user']['username']) ?></b></small>
        </div>
        <a href="../auth/logout.php">Logout</a>
    </div>

    <div class="card">
        <h3>➕ Buat Akun Baru</h3>
        <form method="POST" action="../auth/admin_create_user.php">
            <input name="username" placeholder="Username" required><br><br>
            <input name="email" placeholder="Email" required><br><br>
            <input name="password" placeholder="Password" required><br><br>
            <select name="role">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br><br>
            <button>Buat Akun</button>
        </form>
    </div>

    <div class="card">
        <h3>👥 Daftar User</h3>
        <table>
            <tr>
                <th>ID</th><th>Username</th><th>Role</th><th>Aksi</th>
            </tr>
            <?php while($u = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= $u['role'] ?></td>
                <td class="action">
                    <?php if ($u['id'] != $_SESSION['user']['id']): ?>
                        <a href="../auth/delete_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Hapus user ini?')">🗑️ Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>


    <div class="card">
        <h3>📁 Semua File</h3>
        <table>
            <tr>
                <th>File</th><th>Pemilik</th><th>Status</th><th>Aksi</th>
            </tr>
            <?php while($f = $files->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($f['filename']) ?></td>
                <td><?= htmlspecialchars($f['username']) ?></td>
                <td>
                    <span class="badge <?= $f['is_public'] ? 'public' : 'private' ?>">
                        <?= $f['is_public'] ? 'PUBLIC 🌍' : 'PRIVATE 🔒' ?>
                    </span>
                </td>
                <td class="action">
                    <a href="../files/download.php?id=<?= $f['id'] ?>">⬇️</a>
                    <a href="../files/toggle_public_admin.php?id=<?= $f['id'] ?>">🔁</a>
                    <a href="../files/delete.php?id=<?= $f['id'] ?>" onclick="return confirm('Hapus file?')">🗑️</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>

</body>
</html>

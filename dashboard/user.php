<?php
include '../middleware/auth_check.php';
include '../config/db.php';

$user_id = $_SESSION['user']['id'];

/*
 Ambil:
 - file milik sendiri
 - ATAU file public milik user lain
*/
$files = $conn->query("
    SELECT files.*, users.username
    FROM files
    JOIN users ON files.user_id = users.id
    WHERE files.user_id = $user_id
       OR files.is_public = 1
    ORDER BY files.upload_date DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>User Dashboard - Drive‑Lite</title>
<style>
    * { margin:0; padding:0; box-sizing:border-box; }

    body {
        font-family: 'Segoe UI', sans-serif;
        background: #1f2937; /* gelap */
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding-top: 40px;
    }

    .container {
        width: 100%;
        max-width: 800px;
        text-align: center;
    }

    h2 {
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        margin: 5px;
        padding: 10px 20px;
        border-radius: 8px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn:hover { background: #1d4ed8; }

    .btn.logout {
        background: #ef4444;
    }

    .btn.logout:hover { background: #dc2626; }

    .card {
        background: #374151;
        border-radius: 12px;
        padding: 20px;
        margin: 20px auto;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        text-align: center;
    }

    form input[type="file"] {
        width: 80%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #555;
        background: #1f2937;
        color: #fff;
    }

    form label {
        display: block;
        margin-top: 10px;
        color: #fff;
    }

    form button {
        margin-top: 15px;
        padding: 10px 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px auto;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        text-align: center;
    }

    th, td {
        padding: 12px;
        color: #fff;
    }

    th {
        background: #4b5563;
    }

    tr:nth-child(even) { background: #374151; }
    tr:nth-child(odd) { background: #1f2937; }

    .badge {
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
    }

    .public { background: #10b981; color: #fff; }
    .private { background: #ef4444; color: #fff; }

    .action a {
        margin: 0 5px;
        color: #3b82f6;
        text-decoration: none;
    }

    .action a:hover { text-decoration: underline; }

    @media(max-width:600px){
        table, th, td { font-size: 12px; }
        form input[type="file"] { width: 100%; }
        .btn { padding: 8px 16px; font-size: 14px; }
    }
</style>
</head>
<body>
<div class="container">

    <h2>Halo, <?= htmlspecialchars($_SESSION['user']['username']) ?> 👋</h2>
    <a class="btn logout" href="../auth/logout.php">Logout</a>

    <div class="card">
        <h3>📤 Upload File</h3>
        <form action="../files/upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <label><input type="checkbox" name="is_public" value="1"> Jadikan file public</label>
            <button class="btn">Upload</button>
        </form>
    </div>

    <div class="card">
        <h3>📂 Daftar File</h3>
        <table>
            <tr>
                <th>Nama File</th>
                <th>Pemilik</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

        <?php while($f = $files->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($f['filename']) ?></td>
                <td><?= htmlspecialchars($f['username']) ?></td>
                <td>
                    <span class="badge <?= $f['is_public'] ? 'public' : 'private' ?>">
                        <?= $f['is_public'] ? '🌍 Public' : '🔒 Private' ?>
                    </span>
                </td>
                <td class="action">
                    <a href="../files/download.php?id=<?= $f['id'] ?>">⬇️</a>
                    <?php if ($f['user_id'] == $user_id): ?>
                        <a href="../files/toggle_public.php?id=<?= $f['id'] ?>">
                            <?= $f['is_public'] ? '🔒' : '🌍' ?>
                        </a>
                        <a href="../files/delete.php?id=<?= $f['id'] ?>"
                           onclick="return confirm('Yakin hapus file ini?')">🗑️</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </table>
    </div>

</div>
</body>
</html>

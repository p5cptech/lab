<?php
// admin/users.php

require '../config/db.php';
require '../includes/functions.php';

/* Ambil semua user via function */
$users = getAllUsers($pdo);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Management | Admin Panel</title>

<style>
/* ===== BASE ===== */
* {
    box-sizing: border-box;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

body {
    margin: 0;
    padding: 40px;
    background: radial-gradient(circle at top, #0a1b3d, #050b1e);
    color: #ffffff;
}

/* ===== PAGE ===== */
.page-wrapper {
    max-width: 1000px;
    margin: auto;
}

/* ===== CARD ===== */
.card {
    background: rgba(10, 20, 50, 0.95);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 14px;
    padding: 26px;
    box-shadow: 0 25px 50px rgba(0,0,0,.6);
}

.card-title {
    font-size: 22px;
    margin: 0;
}

/* ===== TOP BAR ===== */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

/* ===== BUTTON ===== */
.btn {
    padding: 8px 14px;
    background: linear-gradient(135deg, #5da9ff, #3f7cff);
    color: #000;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}

/* ===== TABLE ===== */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    text-align: left;
    font-size: 13px;
    color: #9fb3ff;
    padding: 12px;
    border-bottom: 1px solid rgba(255,255,255,.1);
}

.table td {
    padding: 14px 12px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    font-size: 14px;
}

.table tr:hover {
    background: rgba(255,255,255,.03);
}

/* ===== ACTION ===== */
.action a {
    margin-right: 12px;
    font-size: 16px;
    text-decoration: none;
}

.action .edit {
    color: #5da9ff;
}

.action .delete {
    color: #ff4d4d;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 700px) {
    body {
        padding: 20px;
    }

    .table th:nth-child(3),
    .table td:nth-child(3) {
        display: none;
    }
}
</style>
</head>

<body>

<div class="page-wrapper">
    <div class="card">

        <div class="top-bar">
            <h2 class="card-title">👥 User Management</h2>
            <a href="register.php" class="btn">➕ Add User</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($users): ?>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['full_name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td class="action">
                        <a href="edit_user.php?id=<?= $u['id'] ?>" class="edit">✏️</a>
                        <a href="delete_user.php?id=<?= $u['id'] ?>"
                           class="delete"
                           onclick="return confirm('Hapus user ini?')">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Tidak ada user</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>

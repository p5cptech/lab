<?php
// ================================
// VULNERABLE USER MANAGEMENT PAGE
// ================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../config/db.php'; // mysqli connection ($conn)

// ❌ VULNERABLE QUERY (no filtering)
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Management | VULN Admin Panel</title>

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
    max-width: 1100px;
    margin: auto;
}

/* ===== CARD ===== */
.card {
    background: rgba(10, 20, 50, 0.95);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 14px;
    padding: 28px;
    box-shadow: 0 25px 50px rgba(0,0,0,.6);
}

.card-title {
    font-size: 22px;
    font-weight: 600;
    margin: 0;
}

/* ===== TOP BAR ===== */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

/* ===== BUTTON ===== */
.btn {
    padding: 9px 16px;
    background: linear-gradient(135deg, #5da9ff, #3f7cff);
    color: #000;
    border-radius: 10px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: .2s;
}

.btn:hover {
    opacity: .9;
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
    padding: 14px 12px;
    border-bottom: 1px solid rgba(255,255,255,.12);
}

.table td {
    padding: 14px 12px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    font-size: 14px;
}

.table tr:hover {
    background: rgba(255,255,255,.04);
}

/* ===== ACTION ===== */
.action a {
    margin-right: 14px;
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
@media (max-width: 768px) {
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
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($users): ?>
                <?php foreach ($users as $u): ?>
                <tr>
                    <!-- ❌ STORED XSS -->
                    <td><?= $u['username'] ?></td>
                    <td><?= $u['full_name'] ?></td>
                    <td><?= $u['email'] ?></td>

                    <!-- ❌ IDOR -->
                    <td class="action">
                        <a href="edit_user.php?id=<?= $u['id'] ?>" class="edit">✏️</a>
                        <a href="delete_user.php?id=<?= $u['id'] ?>" class="delete"
                           onclick="return confirm('Delete user?')">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>

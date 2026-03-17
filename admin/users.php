<?php
session_start();
// Pastikan path config dan core sesuai dengan struktur folder kamu
include '../config/db.php'; 
include '../core/logger.php';

/**
 * LOGIKA GRC & MONITORING (Audit Trail)
 */
if(function_exists('log_activity')) {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    log_activity("Admin Access: Listing all users from IP $ip_address", "INFO");
}

// Query mengambil data user
$sql = "SELECT id, username, email, role, bio, profile_picture, created_at FROM users ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Directory - mrahmatt74 Lab</title>
    <link rel="stylesheet" href="../public/assets/list_user.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="admin-card">
    <div class="header-flex">
        <h2><i class="fas fa-users-cog"></i> User Directory</h2>
        <a href="../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="status-monitor">
        <i class="fas fa-shield-alt"></i> <strong>Wazuh Security Note:</strong> 
        Aktivitas di halaman ini dimonitor secara real-time. Log akses dicatat pada <code>logs/pentest_access.log</code> untuk deteksi anomali.
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>User Details</th>
                <th>Bio & Description</th>
                <th>Role</th>
                <th>Joined Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><span class="text-muted">#<?= $row['id'] ?></span></td>
                    <td>
                        <img src="../public/uploads/profiles/<?= $row['profile_picture'] ?>" 
                             class="profile-img" 
                             onerror="this.src='../public/uploads/profiles/default.png'">
                    </td>
                    <td>
                        <div style="font-weight: 700; color: var(--primary-dark);"><?= $row['username'] ?></div>
                        <div class="text-muted" style="font-size: 0.8rem;"><?= $row['email'] ?></div>
                    </td>
                    <td style="max-width: 250px;">
                        <span style="font-style: italic; color: #555;">
                            <?= $row['bio'] ? '"' . $row['bio'] . '"' : '-' ?>
                        </span>
                    </td>
                    <td>
                        <span class="role-badge <?= ($row['role'] == 'admin') ? 'role-admin' : 'role-user' ?>">
                            <?= $row['role'] ?>
                        </span>
                    </td>
                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                    <td>
                        <div style="display: flex; gap: 12px; align-items: center;">
                            <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn-action" title="Edit User">
                                <img src="../public/assets/fontawesome/svgs/solid/edit.svg" 
                                    style="width: 20px; height: 20px; filter: invert(30%) sepia(15%) saturate(1100%) hue-rotate(110deg) brightness(90%) contrast(90%);" 
                                    alt="Edit">
                            </a>

                            <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn-action" title="Delete User" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                <img src="../public/assets/fontawesome/svgs/solid/delete-left.svg" 
                                    style="width: 60px; height: 60px; filter: invert(20%) sepia(90%) saturate(3000%) hue-rotate(350deg) brightness(90%) contrast(100%);" 
                                    alt="Delete">
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                        <i class="fas fa-folder-open" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                        Belum ada user yang terdaftar di database.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
    &copy; 2026 mrahmatt74 Lab - ADR Group Infrastructure Security
</footer>

</body>
</html>
<?php
session_start();
require_once 'db_connect.php';

// Simple check for Admin role
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$role = $stmt->fetchColumn();

if ($role !== 'admin') {
    die("<div style='color: white; background: #1a1a1a; padding: 50px; text-align: center; height: 100vh; font-family: sans-serif;'><h1>Access Denied</h1><p>This page is reserved for the site owner.</p><a href='index.php' style='color: #00f2fe;'>Back to Home</a></div>");
}

// Fetch all messages
$stmt = $pdo->prepare("SELECT * FROM messages ORDER BY created_at DESC");
$stmt->execute();
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages | Admin | ST Event Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            color: var(--text-primary);
        }

        .admin-table th, .admin-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--glass-border);
        }

        .admin-table th {
            color: var(--accent-primary);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .message-content {
            font-size: 0.9rem;
            line-height: 1.5;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.05);
            padding: 10px;
            border-radius: 8px;
            max-width: 400px;
        }
    </style>
</head>

<body>

    <header>
        <a href="index.php" class="logo">
            <div class="logo-icon">
                <i class="fa-solid fa-gear"></i>
            </div>
            ADMIN Dashboard
        </a>
        <nav class="nav-links">
            <a href="admin_orders.php" class="btn btn-outline"><i class="fa-solid fa-list-check"></i> Orders</a>
            <a href="admin_messages.php" class="btn btn-outline active"><i class="fa-solid fa-envelope"></i> Messages</a>
            <a href="index.php" class="btn btn-outline"><i class="fa-solid fa-house"></i> View Site</a>
            <a href="logout.php" class="btn btn-outline"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </nav>
    </header>

    <main class="container" style="max-width: 1200px; margin-top: 50px;">
        <div class="glass-panel animate-in" style="padding: 30px; border-radius: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h1 class="auth-title" style="margin: 0;">Customer Messages</h1>
                <div style="text-align: right;">
                    <p style="color: var(--accent-primary); font-weight: bold;"><?php echo count($messages); ?></p>
                    <p style="color: var(--text-secondary); font-size: 0.8rem;">Total Messages</p>
                </div>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Sender</th>
                        <th>Contact info</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($messages)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 40px;">No messages received yet.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td>
                                <span style="font-size: 0.9rem; font-weight: bold;"><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></span><br>
                                <span style="font-size: 0.7rem; color: var(--text-secondary);"><?php echo date('h:i A', strtotime($msg['created_at'])); ?></span>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($msg['name']); ?></strong><br>
                                <span style="font-size: 0.8rem; color: var(--text-secondary);"><?php echo htmlspecialchars($msg['email']); ?></span>
                            </td>
                            <td>
                                <span style="color: var(--accent-orange);"><?php echo htmlspecialchars($msg['contact_no']); ?></span>
                            </td>
                            <td>
                                <div class="message-content">
                                    <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>

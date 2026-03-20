<?php
session_start();
require_once 'db_connect.php';

// Simple check for Admin role or specific ID
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$role = $stmt->fetchColumn();

// For now, allow common owner emails or roles
if ($role !== 'admin') {
    die("<div style='color: white; background: #1a1a1a; padding: 50px; text-align: center; height: 100vh; font-family: sans-serif;'><h1>Access Denied</h1><p>This page is reserved for the site owner.</p><a href='index.php' style='color: #00f2fe;'>Back to Home</a></div>");
}

// Fetch all orders with user details and image counts
$stmt = $pdo->prepare("
    SELECT o.*, u.name as user_name, u.email as user_email, COUNT(oi.id) as image_count 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    LEFT JOIN order_images oi ON o.id = oi.order_id 
    GROUP BY o.id 
    ORDER BY o.created_at DESC
");
$stmt->execute();
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | ST Event Management</title>
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

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
        .status-confirmed { background: rgba(0, 123, 255, 0.2); color: #007bff; }
        .status-completed { background: rgba(40, 167, 69, 0.2); color: #28a745; }
        .status-cancelled { background: rgba(220, 53, 69, 0.2); color: #dc3545; }
        .status-done { background: rgba(0, 242, 254, 0.2); color: #00f2fe; }

        .image-preview {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .image-preview img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .image-preview img:hover {
            transform: scale(1.1);
        }

        .status-select {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid var(--glass-border);
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
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
            <a href="admin_orders.php" class="btn btn-outline active"><i class="fa-solid fa-list-check"></i> Orders</a>
            <a href="admin_messages.php" class="btn btn-outline"><i class="fa-solid fa-envelope"></i> Messages</a>
            <a href="index.php" class="btn btn-outline"><i class="fa-solid fa-house"></i> View Site</a>
            <a href="logout.php" class="btn btn-outline"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </nav>
    </header>

    <main class="container" style="max-width: 1200px; margin-top: 50px;">
        <div class="glass-panel animate-in" style="padding: 30px; border-radius: 20px;">
            <?php if(isset($_SESSION['success'])): ?>
                <div style="background: rgba(40, 167, 69, 0.2); color: #28a745; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: bold; border: 1px solid rgba(40, 167, 69, 0.3);">
                    <i class="fa-solid fa-circle-check"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['error'])): ?>
                <div style="background: rgba(220, 53, 69, 0.2); color: #dc3545; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: bold; border: 1px solid rgba(220, 53, 69, 0.3);">
                    <i class="fa-solid fa-circle-xmark"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h1 class="auth-title" style="margin: 0;">Inbound Orders</h1>
                <div style="text-align: right;">
                    <p style="color: var(--accent-primary); font-weight: bold;"><?php echo count($orders); ?></p>
                    <p style="color: var(--text-secondary); font-size: 0.8rem;">Total Requests</p>
                </div>
            </div>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Event Details</th>
                        <th>Status</th>
                        <th>Images</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?><br><span style="font-size: 0.7rem; color: var(--text-secondary);"><?php echo date('M d', strtotime($order['created_at'])); ?></span></td>
                            <td>
                                <strong><?php echo htmlspecialchars($order['user_name']); ?></strong><br>
                                <span style="font-size: 0.8rem; color: var(--text-secondary);"><?php echo htmlspecialchars($order['user_email']); ?></span><br>
                                <span style="font-size: 0.8rem; color: var(--accent-orange);"><?php echo htmlspecialchars($order['contact_no']); ?></span>
                            </td>
                            <td>
                                <span style="text-transform: capitalize; font-weight: bold;"><?php echo str_replace('babyshower', 'Baby Shower', $order['event_type']); ?></span><br>
                                <span style="font-size: 0.8rem;"><i class="fa-solid fa-calendar"></i> <?php echo date('M d, Y', strtotime($order['event_date'])); ?></span><br>
                                <span style="font-size: 0.8rem;"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($order['location']); ?></span>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo $order['status']; ?>">
                                    <?php echo $order['status']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="image-preview">
                                    <?php
                                    // Fetch images for this order
                                    $img_stmt = $pdo->prepare("SELECT image_path FROM order_images WHERE order_id = ?");
                                    $img_stmt->execute([$order['id']]);
                                    $images = $img_stmt->fetchAll();
                                    foreach ($images as $img) {
                                        echo "<img src='" . htmlspecialchars($img['image_path']) . "' onclick=\"window.open(this.src)\" title='Click to view full size'>";
                                    }
                                    if (empty($images)) echo "<span style='color: var(--text-secondary); font-size: 0.8rem;'>None</span>";
                                    ?>
                                </div>
                            </td>
                            <td style="font-size: 0.85rem; max-width: 200px;"><?php echo nl2br(htmlspecialchars($order['description'])); ?></td>
                            <td>
                                <form action="admin_status_handler.php" method="POST" style="display: flex; gap: 5px;">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="status-select">
                                        <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="confirmed" <?php echo $order['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirm</option>
                                        <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Complete</option>
                                        <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancel</option>
                                        <option value="done" <?php echo $order['status'] == 'done' ? 'selected' : ''; ?>>Done</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary" style="padding: 10px 15px; font-size: 0.8rem; min-width: 80px;">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>

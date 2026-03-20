<?php
session_start();
require_once 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login to view your orders.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch orders with their image counts
$stmt = $pdo->prepare("
    SELECT o.*, COUNT(oi.id) as image_count 
    FROM orders o 
    LEFT JOIN order_images oi ON o.id = oi.order_id 
    WHERE o.user_id = ? 
    GROUP BY o.id 
    ORDER BY o.created_at DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | ST Event Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            color: var(--text-primary);
        }

        .orders-table th, .orders-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--glass-border);
        }

        .orders-table th {
            color: var(--accent-primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: capitalize;
        }

        .status-pending { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
        .status-confirmed { background: rgba(0, 123, 255, 0.2); color: #007bff; }
        .status-completed { background: rgba(40, 167, 69, 0.2); color: #28a745; }
        .status-cancelled { background: rgba(220, 53, 69, 0.2); color: #dc3545; }
        .status-done { background: rgba(0, 242, 254, 0.2); color: #00f2fe; }

        .order-row:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .no-orders {
            text-align: center;
            padding: 50px;
            color: var(--text-secondary);
        }
    </style>
</head>

<body>

    <header>
        <a href="index.php" class="logo">
            <div class="logo-icon">
                <i class="fa-solid fa-glass-cheers"></i>
            </div>
            ST Event Management
        </a>
        <nav class="nav-links">
            <a href="index.php" class="btn btn-outline"><i class="fa-solid fa-house"></i> Home</a>
            <a href="about.php" class="btn btn-outline"><i class="fa-regular fa-address-card"></i> About Us</a>
            <a href="my_orders.php" class="btn btn-primary" style="background: rgba(255,255,255,0.1); color: white; box-shadow: none; border: 1px solid var(--glass-border); pointer-events: none;"><i class="fa-solid fa-list-check"></i> My Orders</a>
            <a href="order.php" class="btn btn-primary"><i class="fa-solid fa-cart-shopping"></i> Place Order</a>
            <a href="logout.php" class="btn btn-outline"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </nav>
    </header>

    <main class="container" style="margin-top: 50px;">
        <div class="glass-panel animate-in" style="padding: 40px; border-radius: 20px;">
            <h1 class="auth-title" style="margin-bottom: 20px;">My Orders</h1>
            <p style="color: var(--text-secondary); margin-bottom: 30px;">Track the status of your event booking requests.</p>

            <?php if (empty($orders)): ?>
                <div class="no-orders">
                    <i class="fa-solid fa-box-open" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.5;"></i>
                    <p>You haven't placed any orders yet.</p>
                    <a href="order.php" class="btn btn-primary" style="margin-top: 20px;">Book an Event Now</a>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Event Type</th>
                                <th>Event Date</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Images</th>
                                <th>Placed On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr class="order-row">
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td style="text-transform: capitalize; font-weight: bold;"><?php echo str_replace('babyshower', 'Baby Shower', $order['event_type']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($order['event_date'])); ?></td>
                                    <td><i class="fa-solid fa-location-dot" style="font-size: 0.8rem; margin-right: 5px; color: var(--accent-primary);"></i> <?php echo htmlspecialchars($order['location']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $order['status']; ?>">
                                            <?php echo $order['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fa-regular fa-image"></i> <?php echo $order['image_count']; ?>
                                    </td>
                                    <td style="font-size: 0.85rem; color: var(--text-secondary);">
                                        <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 30px;">
            <a href="index.php" class="btn btn-outline"><i class="fa-solid fa-chevron-left"></i> Back to Home</a>
        </div>
    </main>

</body>

</html>

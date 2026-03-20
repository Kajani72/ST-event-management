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
    $_SESSION['error'] = "Access Denied: You are not authorized to perform this action. Current role: " . $role;
    header("Location: admin_orders.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    if (!$order_id || !$status) {
        $_SESSION['error'] = "Critical Error: Missing order ID or status in request.";
        header("Location: admin_orders.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $result = $stmt->execute([$status, $order_id]);
        
        if ($result) {
            $_SESSION['success'] = "Order #$order_id updated to '$status' successfully!";
        } else {
            $_SESSION['error'] = "Database update failed for Order #$order_id.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "SQL Error: " . $e->getMessage();
    }

    header("Location: admin_orders.php");
    exit();
}
 else {
    header("Location: admin_orders.php");
    exit();
}
?>

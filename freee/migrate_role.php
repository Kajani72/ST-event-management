<?php
require_once 'db_connect.php';

try {
    echo "Starting migration...<br>";
    
    // 1. Add role column
    $pdo->exec("ALTER TABLE users ADD COLUMN role ENUM('customer', 'admin') DEFAULT 'customer' AFTER id");
    echo "Added 'role' column to 'users' table.<br>";

    // 2. Set the first user or a specific user as admin
    // You can change '1' to your user ID
    $pdo->exec("UPDATE users SET role = 'admin' WHERE id = 1");
    echo "Promoted User #1 to Admin.<br>";

    echo "<strong>Migration Successful!</strong><br>";
    echo "<a href='admin_orders.php'>Go to Admin Dashboard</a>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

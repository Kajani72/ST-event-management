<?php
require_once 'db_connect.php';

try {
    echo "Updating status ENUM...<br>";
    $pdo->exec("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'completed', 'cancelled', 'done') DEFAULT 'pending'");
    echo "Success! 'done' status is now available.<br>";
    echo "<a href='admin_orders.php'>Go to Admin Dashboard</a>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

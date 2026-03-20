<?php
require_once 'db_connect.php';
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM orders LIKE 'status'");
    $column = $stmt->fetch();
    echo "<pre>";
    print_r($column);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

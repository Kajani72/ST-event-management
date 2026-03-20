<?php
require_once 'db_connect.php';
try {
    $stmt = $pdo->query('SELECT id, name, email, role FROM users');
    $users = $stmt->fetchAll();
    echo "<pre>";
    print_r($users);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

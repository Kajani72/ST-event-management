<?php
require_once 'db_connect.php';

// Change this to the email you want to promote to Admin
$admin_email = 'kajanisathan@gmail.com'; 

try {
    $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE email = ?");
    $stmt->execute([$admin_email]);
    
    if ($stmt->rowCount() > 0) {
        echo "<div style='font-family: sans-serif; padding: 20px; background: #e6fffa; border: 1px solid #38b2ac; border-radius: 8px; color: #234e52;'>";
        echo "<strong>Success!</strong> The user <strong>$admin_email</strong> is now an Administrator.<br><br>";
        echo "<a href='login.php' style='color: #3182ce;'>Go to Login Page</a>";
        echo "</div>";
    } else {
        echo "<div style='font-family: sans-serif; padding: 20px; background: #fff5f5; border: 1px solid #feb2b2; border-radius: 8px; color: #742a2a;'>";
        echo "<strong>Notice:</strong> No user found with the email <strong>$admin_email</strong>. Please make sure the email is correct and the user has already signed up.";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

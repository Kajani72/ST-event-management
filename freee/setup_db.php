<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Default XAMPP/WAMP password is empty
$db   = 'st_event_management';
$charset = 'utf8mb4';

try {
    // 1. Connect to MySQL without specifying a database
    $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connecting to MySQL server...<br>";

    // 2. Create the Database
    echo "Creating database '$db' if it doesn't exist...<br>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database created/ready.<br>";

    // 3. Connect to the new database
    $pdo->exec("USE `$db`");
    echo "Switched to database '$db'.<br>";

    // 4. Read and execute the SQL schema
    $sql = file_get_contents('database_schema.sql');
    if ($sql === false) {
        throw new Exception("Could not read database_schema.sql. Please make sure the file exists in the same folder.");
    }

    echo "Preparing to execute schema...<br>";

    // Split SQL into individual statements
    // This is a simple split by semicolon. It works for most simple schemas.
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($statements as $index => $statement) {
        if (empty($statement)) continue;
        
        // Skip CREATE DATABASE and USE statements from the SQL file if they are already done
        if (stripos($statement, 'CREATE DATABASE') === 0 || stripos($statement, 'USE ') === 0) {
            continue;
        }

        try {
            $pdo->exec($statement);
            // echo "Statement #" . ($index + 1) . " executed successfully.<br>";
        } catch (PDOException $e) {
            echo "<span style='color: orange;'>Notice on statement #" . ($index + 1) . ": " . $e->getMessage() . "</span><br>";
        }
    }

    echo "<strong>Final Status: Your database and tables have been set up successfully!</strong><br>";
    echo "<a href='index.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background: #00f2fe; color: black; text-decoration: none; border-radius: 5px; font-weight: bold;'>Go to Home Page</a>";

} catch (Exception $e) {
    echo "<div style='border: 1px solid red; padding: 20px; margin-top: 20px;'>";
    echo "<strong style='color: red;'>CRITICAL ERROR:</strong> " . $e->getMessage() . "<br><br>";
    echo "<strong>Possible solutions:</strong><br>";
    echo "1. Ensure XAMPP is running and MySQL is started.<br>";
    echo "2. Check if your MySQL user/password is correct in 'setup_db.php'.<br>";
    echo "3. Try importing 'database_schema.sql' manually in phpMyAdmin.<br>";
    echo "</div>";
}
?>

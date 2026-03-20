<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $contact_no = trim($_POST['contact_no']);
    $message = trim($_POST['message']);

    try {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, contact_no, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $contact_no, $message]);
        
        $_SESSION['success'] = "Message sent successfully! We'll get back to you soon.";
        header("Location: about.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Failed to send message. Please try again.";
        header("Location: about.php");
        exit();
    }
} else {
    header("Location: about.php");
    exit();
}
?>

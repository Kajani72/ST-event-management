<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "You must be logged in to place an order.";
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $event_type = $_POST['event_type'];
    $event_date = $_POST['event_date'];
    $contact_no = $_POST['contact_no'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, event_type, event_date, contact_no, location, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $event_type, $event_date, $contact_no, $location, $description]);
        
        $order_id = $pdo->lastInsertId();

        // Handle Image Uploads
        if (!empty($_FILES['reference_images']['name'][0])) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            foreach ($_FILES['reference_images']['tmp_name'] as $key => $tmp_name) {
                $file_name = time() . '_' . $_FILES['reference_images']['name'][$key];
                $target_file = $upload_dir . $file_name;

                if (move_uploaded_file($tmp_name, $target_file)) {
                    $stmt = $pdo->prepare("INSERT INTO order_images (order_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$order_id, $target_file]);
                }
            }
        }

        $pdo->commit();
        $_SESSION['success'] = "Order placed successfully!";
        header("Location: order.php");
        exit();

    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $_SESSION['error'] = "Order placement failed: " . $e->getMessage();
        header("Location: order.php");
        exit();
    } catch (Exception $e) {
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header("Location: order.php");
        exit();
    }
} else {
    header("Location: order.php");
    exit();
}
?>

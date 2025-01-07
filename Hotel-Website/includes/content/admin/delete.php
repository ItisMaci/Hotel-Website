<?php
    require_once '../../../config/config_session.inc.php';
    require_once '../../../config/dbaccess.php';
    
// Verify login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../../index.php"); 
    exit();
}

// Very that user is an admin
if ($_SESSION['is_admin'] !== 1) {
    echo "Not authorized.";
    exit();
}

// Include database credentials
require_once '../../../config/dbaccess.php'; // Adjust the path to dbaccess.php

if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $id = intval($_GET['user_id']);

    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: ../../../index.php?page=administration"); // Redirect back to admin
    } else {
        echo "Error deleting record."; // Display error if query fails
    }
} else {
    header("Location: ../../../index.php?page=administration"); // Redirect back if ID not valid
}
exit();
?>

<?php
session_start();

// Überprüfen ob Sitzung schon gestartet hat
if (empty($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../../index.php");
    exit();
}

// Verify that user is an admin
if ($_SESSION['is_admin'] !== 1) {
    echo "Not authorized.";
    exit();
}

// Überprüfen ob die notwendigen Parameter vorhanden sind
if (!isset($_GET['user_id']) || !isset($_GET['current_status'])) {
    header("Location: ../../../index.php?page=administration");
    exit();
}

try {
    require_once '../../../config/config_session.inc.php';
    require_once '../../../config/dbaccess.php';

    
    $user_id = $_GET['user_id'];
    $current_status = $_GET['current_status'];
    $new_status = $current_status == 1 ? 0 : 1;
    
    $update_query = "UPDATE users SET active = ? WHERE user_id = ?";
    $stmt = $pdo->prepare($update_query);
    $stmt->execute([$new_status, $user_id]);
    
    header("Location: ../../../index.php?page=administration&status=success");
    exit();
    
} catch (PDOException $e) {
    header("Location: ../../../index.php?page=administration&status=error");
    exit();
}
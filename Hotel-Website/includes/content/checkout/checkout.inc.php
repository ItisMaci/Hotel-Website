<?php
    require_once '../../../config/config_session.inc.php';
    $conn = new mysqli("localhost", "root", "", "dbaccess");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fk_user_id = $_SESSION["user_id"];
    $fk_room_id = $_POST["room_id"];
    $checkin = $_POST["checkin"];
    $checkout = $_POST["checkout"];
    $breakfast_included = $_POST["breakfast_included"];
    $parking_included = $_POST["parking_included"];
    $pets_included = $_POST["pets_included"];
    $payment_method = $_POST["payment_method"];
    $price_total = str_replace(',', '', $_POST["price_total"]); // Remove any commas

    $sql = "INSERT INTO bookings (fk_user_id, fk_room_id, checkin, checkout, breakfast_included, parking_included, pets_included, payment_method, price_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssssd", $fk_user_id, $fk_room_id, $checkin, $checkout, $breakfast_included, $parking_included, $pets_included, $payment_method, $price_total);

    if ($stmt->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: checkout_index.php?page=thanks");
?>
<?php
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST["checkin"]) && isset($_POST["checkout"]) && isset($_POST["room_id"])){
        $checkin = $_POST["checkin"];
        $checkout = $_POST["checkout"];
        $room_id = $_POST["room_id"];
        
        $sql = "SELECT COUNT(*) as count FROM bookings 
                WHERE fk_room_id = ? AND (? < checkout AND ? > checkin)";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Statement preparation failed: " . $conn->error);
        }
        $stmt->bind_param("iss", $room_id, $checkin, $checkout);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        $conn->close();

        if ($count > 0) {
            $error_msg = "Room is already taken in the selected period. Check availability.";
            header("Location: ../../../index.php?page=rooms&error=$error_msg");
        }
    } else {
        echo "Invalid input.";
    }
?>
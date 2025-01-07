<?php

// Fetch rooms with prepared statements
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// If From and To dates are set, rooms are fetched based on availability
if(isset($_POST["checkin"]) && isset($_POST["checkout"])){
    $checkin = $_POST["checkin"];
    $checkout = $_POST["checkout"];
    
    $sql = "SELECT * FROM rooms 
            WHERE room_id NOT IN (
                SELECT fk_room_id FROM bookings 
                WHERE (? < checkout AND ? > checkin)
            )";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Statement preparation failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $checkin, $checkout);
} else {
    $sql = "SELECT * FROM rooms";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Statement preparation failed: " . $conn->error);
    }
}

$stmt->execute();
$result = $stmt->get_result();

$rooms = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

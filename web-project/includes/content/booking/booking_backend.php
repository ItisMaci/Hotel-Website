<?php
// Hardcoded user ID for testing
$room_id = 1; // Replace with a valid user ID from your `users` table

$conn = mysqli_connect("localhost", "root", "", "dbaccess"); 
// Fetch room details
$sql = "SELECT * FROM rooms WHERE room_id = $room_id";
$result = $conn->query($sql);
if (!$result) {
    die("Error fetching room: " . $conn->error);
}
$room = $result->fetch_assoc(); 

if (!$room) {
    die("Room not found. Please check the room_id parameter.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $breakfast = isset($_POST['breakfast']) ? 1 : 0;
    $parking = isset($_POST['parking']) ? 1 : 0;
    $pets = isset($_POST['pets']) ? 1 : 0;

    $sql = "INSERT INTO bookings (user_id, room_id, check_in_date, check_out_date, breakfast, parking, pets) 
            VALUES ('$user_id', '$room_id', '$from_date', '$to_date', '$breakfast', '$parking', '$pets')";

    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Booking successful!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

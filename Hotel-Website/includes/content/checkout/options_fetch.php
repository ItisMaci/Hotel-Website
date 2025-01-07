<?php
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM booking_options";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Statement preparation failed: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

$options = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

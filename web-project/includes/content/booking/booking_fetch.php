<?php
$conn = mysqli_connect("localhost", "root", "", "dbaccess");
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

$rooms = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

?>

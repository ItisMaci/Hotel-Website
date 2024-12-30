<?php
$conn = mysqli_connect("localhost", "root", "", "dbaccess");
$sql = "SELECT * FROM booking_options";
$result = $conn->query($sql);

$options = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

?>

<?php 
    require_once 'config/config_session.inc.php';
    require_once 'config/dbaccess.php';

    // Überprüfen, ob Sitzung schon gestartet ist
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: /Hotel-Website/index.php"); // Zurück zu index.php, wenn nicht eingeloggt
        exit();
    }

    // Create connection
    $connection = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Überprüfen auf Verbindungsfehler
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Benutzerdaten des derzeit eingeloggenen Benutzers abrufen
    $user_id = $_SESSION['user_id']; // Angenommen, die User-ID wird in der Sitzung gespeichert
    $query = "SELECT user_id, gender, firstName, lastName, username, email FROM users WHERE user_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    // Buchungen des aktuell eingeloggten Benutzers abrufen
    $bookingsQuery = "SELECT booking_id, fk_user_id, fk_room_id, checkin, checkout, breakfast_included, parking_included, pets_included, payment_method, booking_status, price_total, created_at FROM bookings WHERE fk_user_id = ?";
    $bookingsStmt = $pdo->prepare($bookingsQuery);
    $bookingsStmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $bookingsStmt->execute();
    $bookingsResult = $bookingsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="container my-5 vh-100">
    <div class="table-responsive">
        <h2>Profile</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Gender</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($result['gender']); ?></td>
                    <td><?php echo htmlspecialchars($result['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($result['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($result['username']); ?></td>
                    <td><?php echo htmlspecialchars($result['email']); ?></td>
                    <td>
                        <a href="includes/content/editUser.php?user_id=<?php echo $result['user_id']; ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive">
        <h2>Bookings</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Booking ID</th>
                    <th scope="col">Room</th>
                    <th scope="col">Checkin</th>
                    <th scope="col">Checkout</th>
                    <th scope="col">Breakfast</th>
                    <th scope="col">Parking</th>
                    <th scope="col">Pets</th>
                    <th scope="col">Payment Method</th>
                    <th scope="col">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($bookingsResult as $row) {
                    echo "<tr>
                        <td>{$row['booking_id']}</td>
                        <td>{$row['fk_room_id']}</td>
                        <td>{$row['checkin']}</td>
                        <td>{$row['checkout']}</td>
                        <td>" . ($row['breakfast_included'] ? 'Yes' : 'No') . "</td>
                        <td>" . ($row['parking_included'] ? 'Yes' : 'No') . "</td>
                        <td>" . ($row['pets_included'] ? 'Yes' : 'No') . "</td>
                        <td>{$row['payment_method']}</td>
                        <td>€ {$row['price_total']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>


<?php 
// Schließen der Verbindungen
$stmt->close();
//$bookingsStmt->close();
$connection->close(); 
?>

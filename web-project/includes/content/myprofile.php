<?php 
require_once 'config/config_session.inc.php';
require_once 'config/dbaccess.php';

// Überprüfen, ob Sitzung schon gestartet ist
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php"); // Zurück zu index.php, wenn nicht eingeloggt
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
$query = "SELECT id, gender, firstName, lastName, username, email, created_at FROM users WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

// Buchungen des aktuell eingeloggten Benutzers abrufen
$bookingsQuery = "SELECT room_id, start_date, end_date, id FROM availability WHERE user_id = ?";
$bookingsStmt = $connection->prepare($bookingsQuery);
$bookingsStmt->bind_param("i", $user_id);
$bookingsStmt->execute();
$bookingsResult = $bookingsStmt->get_result();
?>

<div class="container my-5">
    <h2>Mein Profil</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Gender</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $result['gender']; ?></td>
                <td><?php echo $result['firstName']; ?></td>
                <td><?php echo $result['lastName']; ?></td>
                <td><?php echo $result['username']; ?></td>
                <td><?php echo $result['email']; ?></td>
                <td><?php echo $result['created_at']; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php 
// Schließen der Verbindungen
$stmt->close();
$bookingsStmt->close();
$connection->close(); 
?>

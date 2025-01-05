<?php 
    // Überprüfen ob Sitzung schon gestartet hat
    if (empty($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: index.php"); // Zurück zu index.php, wenn nicht eingeloggt
        exit();
    }

    // Very that user is an admin
    if ($_SESSION['is_admin'] !== 1) {
        echo "Not authorized.";
        var_dump($_SESSION['is_admin']); // Outputs the value and type
        exit();
    }

    // Abrufen der Benutzerdaten aus der Datenbank
    $query = "SELECT user_id, gender, firstName, lastName, username, email, active, created_at FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Abrufen der Reservierungen aus der Datenbank
    if(isset($_POST["status_filter"]) && $_POST["status_filter"] !== 'all') {
        $status_filter = $_POST["status_filter"];
        $query = "SELECT booking_id, fk_user_id, fk_room_id, checkin, checkout, breakfast_included, parking_included, pets_included, payment_method, booking_status, price_total, created_at FROM bookings WHERE booking_status = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$status_filter]);
    } else {
        $query = "SELECT booking_id, fk_user_id, fk_room_id, checkin, checkout, breakfast_included, parking_included, pets_included, payment_method, booking_status, price_total, created_at FROM bookings";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }

    $result_bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5 min-vh-100">
    <div>
        <h2>All Clients</h2>
        <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gender</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Action</th>
                <th>Active</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($result as $row) {
                // Umgekehrte Logik: 0 = "Active", 1 = "Inactive"
                $btnClass = $row['active'] == 1 ? 'btn-danger' : 'btn-success';
                $statusText = $row['active'] == 1 ? 'Inactive' : 'Active';
                
                echo "<tr>
                    <td>$row[user_id]</td>
                    <td>$row[gender]</td>
                    <td>$row[firstName]</td>
                    <td>$row[lastName]</td>
                    <td>$row[username]</td>
                    <td>$row[email]</td>
                    <td>$row[created_at]</td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='includes/content/admin/edit.php?user_id=$row[user_id]'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='includes/content/admin/delete.php?user_id=$row[user_id]'>Delete</a>
                    </td>
                    <td>
                        <a href='includes/content/admin/toggle_active.php?user_id={$row['user_id']}&current_status={$row['active']}' 
                        class='btn btn-sm {$btnClass}'>
                            {$statusText}
                        </a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
        </table>
    </div>

    <div>
        <h2>All Bookings</h2>
        <table class="table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User ID</th>
                <th>Room ID</th>
                <th>Checkin</th>
                <th>Checkout</th>
                <th>Breakfast</th>
                <th>Parking</th>
                <th>Pets</th>
                <th>Payment Method</th>
                <th>
                    <div class="row gx-0">
                        <div class="col">
                            <form method='post'>
                                <select class='form-select' name='status_filter'>
                                    <option value='all'>All</option>
                                    <option value='new'>New</option>
                                    <option value='confirmed'>Confirmed</option>
                                    <option value='canceled'>Canceled</option>
                                </select>
                        </div>
                        <div class="col">
                                <button type='submit' class='btn btn-primary'>Filter</button>
                            </form>
                        </div>
                    </div>
                    Booking Status
                </th>
                <th>Price Total</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    <?php 
    foreach ($result_bookings as $row) {
        echo "<tr>
            <td>{$row['booking_id']}</td>
            <td>{$row['fk_user_id']}</td>
            <td>{$row['fk_room_id']}</td>
            <td>{$row['checkin']}</td>
            <td>{$row['checkout']}</td>
            <td>" . ($row['breakfast_included'] ? 'Yes' : 'No') . "</td>
            <td>" . ($row['parking_included'] ? 'Yes' : 'No') . "</td>
            <td>" . ($row['pets_included'] ? 'Yes' : 'No') . "</td>
            <td class='text-capitalize'>{$row['payment_method']}</td>
            <td>{$row['booking_status']}</td>
            <td>€ " . number_format($row['price_total'], 2) . "</td>
            <td>{$row['created_at']}</td>
            <td>
                <a class='btn btn-primary btn-sm' href='includes/content/admin/edit_booking.php?booking_id={$row['booking_id']}'>Edit</a>
            </td>
        </tr>";
    }
?>
</tbody>
        </table>
    </div>
</div>
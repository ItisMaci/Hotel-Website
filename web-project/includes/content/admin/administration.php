<?php 
    // Überprüfen ob Sitzung schon gestartet hat
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: /web-project/index.php"); // Zurück zu index.php, wenn nicht eingeloggt
        exit();
    }

    // Very that user is an admin
    if ($_SESSION['is_admin'] !== 1) {
        echo "Not authorized.";
        var_dump($_SESSION['is_admin']); // Outputs the value and type
        exit();
    }

    // Abrufen der Benutzerdaten aus der Datenbank
    $query = "SELECT id, gender, firstName, lastName, username, email, created_at FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5 min-vh-100">
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

        </tr>
       </thead>
       <tbody>
        <?php 
        foreach ($result as $row) {
            echo "<tr>
                <td>$row[id]</td>
                <td>$row[gender]</td>
                <td>$row[firstName]</td>
                <td>$row[lastName]</td>
                <td>$row[username]</td>
                <td>$row[email]</td>
                <td>$row[created_at]</td>
                <td>
                    <a class='btn btn-primary btn-sm' href='/web-project/includes/content/admin/edit.php?id=$row[id]'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='/web-project/includes/content/admin/delete.php?id=$row[id]'>Delete</a>
                </td>
            </tr>";
        }
        ?>
       </tbody>
    </table>
</div>

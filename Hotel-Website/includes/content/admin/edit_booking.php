<?php 
    require_once '../../../config/config_session.inc.php';
    require_once '../../../config/dbaccess.php';

    // Verify login
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: ../../../index.php"); 
        exit();
    }
    
    // Verify that user is an admin
    if ($_SESSION['is_admin'] !== 1) {
        echo "Not authorized.";
        exit();
    }

    // Create connection
    $connection = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $booking_id = "";
    $booking_status = "";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!isset($_GET["booking_id"])) {
            header("location: ../../../index.php?page=administration");
            exit;
        }
        $booking_id = $_GET['booking_id'];

        // Fetch booking details
        $sql = "SELECT * FROM bookings WHERE booking_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();

        if (!$booking) {
            header("location: ../../../index.php?page=administration");
            exit;
        }

        $booking_status = $booking['booking_status'];
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $booking_id = $_POST['booking_id'];
        $booking_status = $_POST['booking_status'];

        // Update booking status
        $sql = "UPDATE bookings SET booking_status = ? WHERE booking_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("si", $booking_status, $booking_id);

        if ($stmt->execute()) {
            $successMessage = "Booking status updated successfully!";
        } else {
            $errorMessage = "Error updating booking status: " . $stmt->error;
        }
    }

    include("../../components/header.php");
?>

<body>
    <div class="container my-5 min-vh-100">        
        <?php
            if (!empty($errorMessage)) {
                echo "<div class='alert alert-danger'>$errorMessage</div>";
            }
            if (!empty($successMessage)) {
                echo "<div class='alert alert-success'>$successMessage</div>";
            }
        ?>

        <form method="post">
            <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Booking ID</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="booking_id" value="<?php echo $booking_id; ?>" readonly> 
                    </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Booking Status</label>
                <div class="col-sm-6">
                    <select class="form-select" name="booking_status" required>
                        <option value="new" <?php echo $booking_status == 'new' ? 'selected' : ''; ?>>New</option>
                        <option value="confirmed" <?php echo $booking_status == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="canceled" <?php echo $booking_status == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="../../../index.php?page=administration" role="button">Back</a> 
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    $connection->close();
?>

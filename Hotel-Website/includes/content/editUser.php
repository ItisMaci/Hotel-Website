<?php 
require_once '../../config/config_session.inc.php';
require_once '../../config/dbaccess.php';


include("../components/header.php");
include("../components/navbar.php");

// Verify login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../index.php"); 
    exit();
}

// Create connection
$connection = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Get user ID
$user_id = $_SESSION['user_id'];

// Fetch current user data
$query = "SELECT firstName, lastName, username, email, pwd FROM users WHERE user_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$errorMessage = "";
$successMessage = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'] ?? $result['firstName'];
    $lastName = $_POST['lastName'] ?? $result['lastName'];
    $username = $_POST['username'] ?? $result['username'];
    $email = $_POST['email'] ?? $result['email'];
    $oldPassword = $_POST['old_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';

    do {
        // Validate mandatory fields
        if (empty($firstName) || empty($lastName) || empty($username) || empty($email)) {
            $errorMessage = "Please fill in all mandatory fields.";
            break;
        }

        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email format.";
            break;
        }

        // Update password only if old and new passwords are provided
        if (!empty($oldPassword) && !empty($newPassword)) {
            $checkQuery = "SELECT pwd FROM users WHERE user_id = ?";
            $checkStmt = $connection->prepare($checkQuery);
            $checkStmt->bind_param("i", $user_id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result()->fetch_assoc();

            if (!$checkResult || !password_verify($oldPassword, $checkResult['pwd'])) {
                $errorMessage = "Old password is incorrect.";
                break;
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $passwordQuery = "UPDATE users SET pwd = ? WHERE user_id = ?";
            $passwordStmt = $connection->prepare($passwordQuery);
            $passwordStmt->bind_param("si", $hashedPassword, $user_id);
            if (!$passwordStmt->execute()) {
                $errorMessage = "Failed to update password.";
                break;
            }
        }

        // Update other user data
        $updateQuery = "UPDATE users SET firstName = ?, lastName = ?, username = ?, email = ? WHERE user_id = ?";
        $updateStmt = $connection->prepare($updateQuery);
        $updateStmt->bind_param("ssssi", $firstName, $lastName, $username, $email, $user_id);
        if (!$updateStmt->execute()) {
            $errorMessage = "Failed to update profile.";
            break;
        }

        $successMessage = "Profile updated successfully.";
    } while (false);
}

?>

<div class="container my-5">
    <h2>Edit Profile</h2>

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
            <label class="col-sm-3 col-form-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="firstName" value="<?php echo htmlspecialchars($result['firstName']); ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="lastName" value="<?php echo htmlspecialchars($result['lastName']); ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($result['username']); ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($result['email']); ?>" required>
            </div>
        </div>

        <h3>Change Password</h3>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Old Password</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="old_password">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">New Password</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="new_password">
            </div>
        </div>

        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-secondary" href="../../index.php?page=profile" role="button">Cancel</a>
            </div>
        </div>
    </form>
</div>

<?php
$stmt->close();
$connection->close();
?>

<?php 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();

    $username = htmlspecialchars(trim($_POST["username"]), ENT_QUOTES, 'UTF-8');
    $pwd = htmlspecialchars(trim($_POST["pwd"]), ENT_QUOTES, 'UTF-8');

    try {
        require_once '../../../config/dbaccess.php';        
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        $errors = [];

        if (is_input_empty($username, $pwd)) {
            $errors["empty_input"] = "Please fill in all fields.";
        }

        $result = get_user($pdo, $username);

        if (!$result || is_password_wrong($pwd, $result["pwd"])) {
            $errors["login_incorrect"] = "Invalid username or password.";
        }

        // Neue Überprüfung für den Status
        if ($result && (int)$result["active"] === 1) {
            $errors["inactive_account"] = "Your account is no longer active.";
        }

        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            $_SESSION["login_username"] = $username;
            header("Location: ../../../index.php?page=login");
            exit();
        }

        //require_once '../../../config/config_session.inc.php';

        session_regenerate_id(true);

        $_SESSION["user_id"] = $result["user_id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["is_admin"] = (int)$result["is_admin"];
        $_SESSION["last_regeneration"] = time();
        $_SESSION["loggedin"] = true;

        if (isset($_SESSION["login_username"])) {
            unset($_SESSION["login_username"]);
        }

        header("Location: ../../../index.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION["errors_login"]["db_error"] = "A database error occurred. Please try again later.";
        header("Location: ../../../index.php?page=login");
        exit();
    }
} else {
    header("Location: ../../../index.php?page=login");
    exit();
}
?>
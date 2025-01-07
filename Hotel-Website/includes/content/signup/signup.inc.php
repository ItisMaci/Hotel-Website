<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : ''; 
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $confirmPwd = $_POST["confirm_password"];

    try {
        require_once("../../../config/dbaccess.php");
        require_once __DIR__ . '/signup_model.inc.php';
        require_once __DIR__ . '/signup_contr.inc.php';

        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($firstName, $lastName, $username, $pwd, $email, $gender)) {
            $errors["empty_input"] = "Fill in the input";
        }
        if (!is_name_valid($firstName)) {
            $errors["invalid_first_name"] = "First name can only contain letters and allowed characters (no numbers or special symbols)";
        }
        if (!is_name_valid($lastName)) {
            $errors["invalid_last_name"] = "Last name can only contain letters and allowed characters (no numbers or special symbols)";
        }
        if (is_email_invalid($email)) {
            $errors["email_invalid"] = "Your email is invalid";
        }
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "The username is already taken";
        }
        if (is_email_registered($pdo, $email)) {
            $errors["email_registered"] = "The email is already registered";
        }
        if (!is_password_matching($pwd, $confirmPwd)) {
            $errors["password_mismatch"] = "Passwords do not match";
        }

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            $_SESSION["signup_data"] = [
                "username" => $username,
                "email" => $email,
                "firstName" => $firstName,
                "lastName" => $lastName
            ];

            header("Location: ../../../index.php?page=signup");
            exit();
        }

        create_user($pdo, $gender, $username, $email, $firstName, $lastName, $pwd);
        header("Location: ../../../index.php");
        exit();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../../../index.php");
    exit();
}
?>
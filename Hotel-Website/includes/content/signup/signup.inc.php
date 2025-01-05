<?php 

    if($_SERVER["REQUEST_METHOD"] === "POST"){

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

            //ERROR HANDLERS
            $errors = [];

            if(is_input_empty($gender,$firstName, $lastName, $username, $email,$pwd)){
                $errors["empty_input"] = "Fill in the input";
            }
            if(!is_name_valid($firstName)){
                $errors["invalid_first_name"] = "First name can only contain letters and allowed characters (no numbers or special symbols)";
            }
    
            if(!is_name_valid($lastName)){
                $errors["invalid_last_name"] = "Last name can only contain letters and allowed characters (no numbers or special symbols)";
            }

            if(is_email_invalid($email)){
                $errors["email_invalid"] = "Your email is invalid";
            }

            if(is_username_taken($pdo,$username)){
                $errors["username_taken"] = "The username is already taken";
            }

            if(is_email_registered( $pdo, $email)){
                $errors["email_registered"] = "The email is already registered";
            }

                    // **Passwort-Bestätigung prüfen**
            if ($pwd !== $confirmPwd) {
                $errors["password_mismatch"] = "Passwords do not match";
            }

            require_once '../../../config/config_session.inc.php';
          
            if($errors){
                $_SESSION["errors_signup"]= $errors;

                $signupData = [
                    "username" => $username,
                    "email" => $email,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "confirm_password" => $confirmPassword
                ];
                $_SESSION["signupData"]= $signupData;

                header("Location: ../../../index.php/?page=signup");
                die();
                
            }

            create_user($pdo,$pwd,$firstName,$lastName, $username,$email, $gender);
            header("Location: ../../../index.php");

            $pdo = null;
            $stmt = null;
            die();
            
        }catch(PDOException $e){
            die("Query failed: " . $e->getMessage());
        }

    }else{
        header("Location: ../../../index.php");
        die();
    }

?>
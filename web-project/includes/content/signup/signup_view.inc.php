<?php 
declare(strict_types=1);

function signup_inputs() {
    echo '<div class="d-flex  align-items-center justify-content-center mb-2">
           <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="male" >
            <label class="form-check-label me-3">Male</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="female" >
            <label class="form-check-label">Female</label>
          </div> 
         </div>';


    if (isset($_SESSION["signup_data"]["firstName"]) && !isset($_SESSION["errors_signup"]["is_name_valid"])) {
        echo '<input type="text" class="form-control mb-2" name="firstName" placeholder="First Name" value="' . $_SESSION["signup_data"]["firstName"] . '" >';
    } else {
        echo '<input type="text" class="form-control mb-2" name="firstName" placeholder="First Name" >';
    }

    if (isset($_SESSION["signup_data"]["lastName"]) && !isset($_SESSION["errors_signup"]["is_name_valid"])) {
        echo '<input type="text" class="form-control mb-2" name="lastName" placeholder="Last Name" value="' . $_SESSION["signup_data"]["lastName"] . '" >';
    } else {
        echo '<input type="text" class="form-control mb-2" name="lastName" placeholder="Last Name" >';
    }

    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" class="form-control mb-2" name="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"] . '" >';
    } else {
        echo '<input type="text" class="form-control mb-2" name="username" placeholder="Username" >';
    }

    echo '<input type="password" class="form-control mb-2" name="pwd" placeholder="Password" >';

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_registered"]) && !isset($_SESSION["errors_signup"]["email_invalid"])) {
        echo '<input type="text" class="form-control mb-2" name="email" placeholder="Email" value="' . $_SESSION["signup_data"]["email"] . '" >';
    } else {
        echo '<input type="text" class="form-control mb-2" name="email" placeholder="Email" >';
    }
}

function check_signup_errors() {
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];
        
        foreach ($errors as $error) {
            echo '<p class="alert-danger p-2 mt-2">' . $error . '</p>';
        }
        
        unset($_SESSION['errors_signup']);
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo '<p class="alert-success p-2 mt-2" >Sign up success!</p>';
    }
}
?>
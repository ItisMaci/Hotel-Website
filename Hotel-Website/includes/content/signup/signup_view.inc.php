<?php 
declare(strict_types=1);

function signup_inputs() {
    echo '
         <div data-mdb-input-init class="form-outline mb-4">
            <label for="gender">Gender</label>
            <select id="gender" class="form-control" name="gender" required>
                <option value="" selected hidden disabled>Select...</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
         <div class="row">      
         ';

        
    if (isset($_SESSION["signup_data"]["firstName"]) && !isset($_SESSION["errors_signup"]["is_name_valid"])) {
        echo '
                 
                     <div class="col">
                        <div data-mdb-input-init class="form-outline mb-4">
                           <label class="form-label" for="firstName">First Name</label>
                           <input type="text" class="form-control form-control-lg" id= "firstName" name="firstName" placeholder="First Name" value="' . $_SESSION["signup_data"]["firstName"] . '" required>
                        </div>
                     </div>';
    } else {
        echo '  
                   <div class="col">
                      <div data-mdb-input-init class="form-outline mb-4">
                           <label class="form-label" for="firstName">First Name</label>
                           <input type="text" class="form-control form-control-lg" id= "firstName" name="firstName" placeholder="First Name" required>
                        </div>
                    </div>';
    }

    if (isset($_SESSION["signup_data"]["lastName"]) && !isset($_SESSION["errors_signup"]["is_name_valid"])) {
 
        echo '  
                <div class="col">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="lastName">Last Name</label>
                        <input type="text" class="form-control form-control-lg" id="lastName" name="lastName" placeholder="Last Name" value="' . $_SESSION["signup_data"]["lastName"] . '" required>            
                    </div>
                </div>';
    } else {
        echo '  
                <div class="col">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="lastName">Last Name</label>
                        <input type="text" class="form-control form-control-lg" id="lastName" name="lastName" placeholder="Last Name" required>           
                    </div>
                </div>';
    }

    echo '  
    </div>
    <div class="row">      
         ';

    if (isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '  
                <div class="col">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"] . '" required>           
                    </div>
                </div>';
    } else {
        echo '  
        <div class="col">
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="username">Username</label>
                <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username" required>           
            </div>
        </div>';
    }

    if (isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_registered"]) && !isset($_SESSION["errors_signup"]["email_invalid"])) {
        
        echo '  
        <div class="col">
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="email">Email</label>
               <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Email" value="' . $_SESSION["signup_data"]["email"] . '" required>           
            </div>
        </div>';
    } else {
        echo '  
        <div class="col">
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="email">Email</label>
                <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Email" required >           
            </div>
        </div>';
    }

    echo '  
        </div> 
            <div class="col">
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="pwd">Password</label>
                <input type="password" class="form-control form-control-lg" id="pwd" name="pwd" placeholder="Password" required>           
                </div>
            </div>';

    if (isset($_SESSION["signup_data"]["confirm_password"]) && !isset($_SESSION["errors_signup"]["password_mismatch"])) {
        echo '  
                <div class="col">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Confirm Password" value="' . htmlspecialchars($_SESSION["signup_data"]["confirm_password"]) . '" required >          
                    </div>
                </div>';
    } else {
        echo '  
        <div class="col">
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
        </div>';
    }


}

function check_signup_errors() {
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];
        
        foreach ($errors as $error) {
            echo '<p class="alert alert-danger p-2 mt-2">' . htmlspecialchars($error) . '</p>';
        }
        
        unset($_SESSION['errors_signup']);
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo '<p class="alert-success p-2 mt-2" >Sign up success!</p>';
    }
}
?>
<?php 

declare(strict_types=1);

function is_input_empty(string $firstName,string $lastName,string $username, string $pwd, string $email, string $gender){
    if(empty($firstName) ||empty($lastName) ||empty($username) || empty($pwd) || empty($email) || empty($gender)){
        return true;
    }else{
        return false;
    }
}

function is_email_invalid(string $email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}

function is_username_taken(object $pdo, string $username){
    if(get_username( $pdo, $username)){
        return true;
    }else{
        return false;
    }
}

function is_email_registered(object $pdo, string $email){
    if(get_email($pdo, $email)){
        return true;
    }else{
       return false;
    }
}

function create_user(object $pdo,  string $gender, string $username, string $email,string $firstName,string $lastName,string $pwd,){ 
    set_user( $pdo, $gender, $username,  $email, $firstName, $lastName,$pwd);
}

function is_name_valid(string $name): bool {
    $pattern = "/^[a-zA-ZäöüÄÖÜß\s'-]+$/"; // Erlaubt nur Buchstaben, Leerzeichen, Bindestriche und Apostrophe
    return preg_match($pattern, $name) === 1;
}

?>
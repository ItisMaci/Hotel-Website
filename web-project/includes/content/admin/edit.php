<?php 
    require_once '../../../config/config_session.inc.php';
    require_once '../../../config/dbaccess.php';

    // Verify login
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: /web-project/index.php"); 
        exit();
    }
    
    // Very that user is an admin
    if ($_SESSION['is_admin'] !== 1) {
        echo "Not authorized.";
        exit();
    }

//Create connection

$connection = new mysqli($host, $dbusername, $dbpassword, $dbname);


$id = "";
$firstName = "";
$lastName = "";
$username = "";
$email = "";

$errorMessage="";
$successMessage ="";

if( $_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!isset($_GET["id"])){
        header("location: /web-project/index.php?page=administration");
        exit;
    }
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE  id=$id";
    $result =$connection -> query($sql);
    $row = $result ->fetch_assoc();

    if(!$row){
        header("location: /web-project/index.php?page=administration");
        exit;
    }

    $id = $row["id"];
    $firstName = $row["firstName"];
    $lastName = $row["lastName"];
    $username = $row["username"];
    $email = $row["email"];



}else{

    //POST UPDATED DATA

    $id = $_POST["id"];
    $firstName = $_POST["firstName"];
    $lastName =  $_POST["lastName"];
    $username =  $_POST["username"];
    $email =  $_POST["email"];

    do{
        if(empty($id)|| empty($firstName) || empty( $lastName) || empty($username) || empty($email)){
            $errorMessage = "All fields are requierd";
            break;
        }

        $sql = "UPDATE users " .
        "SET id = '$id', firstName = '$firstName', lastName = '$lastName', username = '$username', email = '$email' " .
        "WHERE id = '$id'";
 

        $result = $connection->query($sql);

        if(!$result){
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Client updated successfully";

        header("location: /web-project/index.php?page=administration");
        exit;


    }while(false);
}

include("../../components/header.php");
include("../../components/navbar.php");
?>



<body>
    <div class="container my-5">

    <?php 
        if(!empty($errorMessage)){
            echo "
                <div class='alert alert-warning alert dismissible fade show' role='alert'>
                        <strong>$errorMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>       
            ";
        }
    ?>

    <form method="post">

        <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ID</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="id" value="<?php echo $id ?>"> 
                </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="firstName" value="<?php echo $firstName ?>"> 
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="lastName" value="<?php echo $lastName ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="email" value="<?php echo $email ?>">
            </div>
        </div>

        <?php 
        if(!empty($successMessage)){
            echo "
                <div class='alert alert-success alert dismissible fade show' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>       
            ";
        }
        
        
        ?>

        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

            <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="/web-project/index.php?page=administration" role="button">Cancel</a> 
            </div>
        </div>
    </form>
    </div>
<?php
    include("../../components/footer.php");
?>
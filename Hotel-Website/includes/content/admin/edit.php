<?php 
    require_once '../../../config/config_session.inc.php';
    require_once '../../../config/dbaccess.php';

    // Verify login
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: ../../../index.php"); 
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
    if(!isset($_GET["user_id"])){
        header("location: ../../../index.php?page=administration");
        exit;
    }
    $id = $_GET['user_id'];

    $sql = "SELECT * FROM users WHERE  user_id=$id";
    $result =$connection -> query($sql);
    $row = $result ->fetch_assoc();

    if(!$row){
        header("location: ../../../index.php?page=administration");
        exit;
    }

    $id_ = $row["user_id"];
    $firstName_ = $row["firstName"];
    $lastName_ = $row["lastName"];
    $username_ = $row["username"];
    $email_ = $row["email"];
    $pwd_ = $row["pwd"];



}else{

    //POST UPDATED DATA

    $id = $_POST["user_id"];
    $firstName = $_POST["firstName"];
    $lastName =  $_POST["lastName"];
    $username =  $_POST["username"];
    $email =  $_POST["email"];
    $pwd =  $_POST["pwd"];

    do{
        if(empty($id)|| empty($firstName) || empty( $lastName) || empty($username) || empty($email) || empty($pwd)){
            $errorMessage = "All fields are requierd";
            break;
        }
        
        $options = [
            'cost' => 12
        ];
        $hashedpwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

        $sql = "UPDATE users " .
        "SET user_id = '$id', firstName = '$firstName', lastName = '$lastName', username = '$username', email = '$email', pwd = '$hashedpwd' " .
        "WHERE user_id = '$id'";
 

        $result = $connection->query($sql);

        if(!$result){
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Client updated successfully";

        header("location: ../../../index.php?page=administration");
        exit;


    }while(false);
}

include("../../components/header.php");
?>



<body>
    <div class="container my-5 min-vh-100">

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
                    <input type="text" class="form-control" name="user_id" value="<?php echo $id_ ?>" readonly> 
                </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="firstName" value="<?php echo $firstName_ ?>"> 
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="lastName" value="<?php echo $lastName_ ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="username" value="<?php echo $username_ ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="email" value="<?php echo $email_ ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">PWD</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="pwd" value="<?php echo $pwd_ ?>">
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
                <a class="btn btn-outline-primary" href="../../../index.php?page=administration" role="button">Cancel</a> 
            </div>
        </div>
    </form>
    </div>
</body>
</html>

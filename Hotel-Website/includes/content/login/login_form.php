<?php 
    declare(strict_types=1);

    //If already logged in, redirect to index.php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header("Location: index.php");
        exit();
    }

    // Error handling
    function render_login_errors() {
        if (!empty($_SESSION["errors_login"])) {
            foreach ($_SESSION["errors_login"] as $error) {
                echo '<p class="alert alert-danger p-2 mt-2">' . htmlspecialchars($error) . '</p>';
            }
            unset($_SESSION["errors_login"]);
        } elseif (isset($_GET['login']) && $_GET['login'] === "success") {
            echo '<p class="alert-success p-2 mt-2">Login successful!</p>';
        }
    }
?>

<section class="vh-100 hero_style">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
            <div class="card" style="border-radius: 1rem;">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                        <img src="images/palmtree_unsplash.jpg"
                            alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                    </div>
                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">

                            <form action="includes/content/login/login.inc.php" method="post">
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <i class="fas fa-cubes fa-2x" style="color: #ff6219;"></i>
                                    <span class="h1 fw-bold mb-0">Login</span>
                                </div>

                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign in to your account</h5>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" id="username" name="username" value="<?php echo $_SESSION["login_username"] ?? ''; ?>" 
                                                                                                class="form-control form-control-lg" required/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="pwd">Password</label>
                                    <input type="password" id="pwd" name="pwd" class="form-control form-control-lg" required/>
                                </div>

                                <?php 
                                    render_login_errors(); 
                                    unset($_SESSION["errors_login"]);
                                ?>

                                <div class="pt-1 mb-4">
                                    <button class="btn btn-dark btn-lg btn-block" type="submit" name="submit">Login</button>
                                </div>

                                <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="index.php?page=signup"
                                    style="color: #393f81;">Register here.</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
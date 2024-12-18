<?php 
    require_once __DIR__ . '/../../../config/config_session.inc.php';
    require_once __DIR__ . '/login_view.inc.php';  

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header("Location: /web-project/index.php");
        exit();
    }

    include("../../components/header.php");
    include("../../components/navbar.php");
?>

<section class="vh-100 login_style">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
            <div class="card" style="border-radius: 1rem;">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-5 d-none d-md-block">
                        <img src="/web-project/images/palmtree_unsplash.jpg"
                            alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                    </div>
                    <div class="col-md-6 col-lg-7 d-flex align-items-center">
                        <div class="card-body p-4 p-lg-5 text-black">

                            <form action="login.inc.php" method="post">
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <i class="fas fa-cubes fa-2x" style="color: #ff6219;"></i>
                                    <span class="h1 fw-bold mb-0">Login</span>
                                </div>

                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign in to your account</h5>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" id="username" name="username" value="<?php echo $_SESSION["login_username"]?>" class="form-control form-control-lg" required/>
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

                                <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="/web-project/includes/content/signup/signup_form.php"
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

<?php
  include("../../components/footer.php");
?>

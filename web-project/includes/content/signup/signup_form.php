<?php 
    require_once __DIR__ . '/../../../config/config_session.inc.php';
    require_once __DIR__ . '/signup_view.inc.php';  

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header("Location: /web-project/index.php");
        exit();
    }

    include("../../components/header.php");
    include("../../components/navbar.php");
?>

<section class="hero_style">
  <div class="container py-5">
    <div class="row d-flex justify-content-center align-items-stretch">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <!-- Image Column -->
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="/web-project/images/palmtree_unsplash.jpg"
                alt="registration form" class="img-fluid h-100" style="border-radius: 1rem 0 0 1rem; object-fit: cover;" />
            </div>
            <!-- Form Column -->
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <!-- REGISTER FORM -->
                <form action="signup.inc.php" method="post">

                    <div class="d-flex align-items-center mb-3 pb-1">
                        <i class="fas fa-cubes fa-2x" style="color: #ff6219;"></i>
                        <span class="h1 fw-bold mb-0">Register</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create a new account</h5>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label for="gender">Gender</label>
                        <select id="gender" class="form-control" name="gender" required>
                            <option value="" selected hidden disabled>Select...</option>
                            <option value="Mr">Male</option>
                            <option value="Ms">Female</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="firstName">First Name</label>
                                <input type="text" id="firstName" name="firstName" value="<?php if(isset($_SESSION["signup_data"]["firstName"])) echo $_SESSION["signup_data"]["firstName"] ?>" class="form-control form-control-lg" required/>
                            </div>
                        </div>

                        <div class="col">
                            <div data-mdb-input-init class="form-outline mb-4">
                                <label class="form-label" for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="lastName" value="<?php if(isset($_SESSION["signup_data"]["lastName"])) echo $_SESSION["signup_data"]["lastName"] ?>" class="form-control form-control-lg" required/>
                            </div>
                        </div>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php if(isset($_SESSION["signup_data"]["username"])) echo $_SESSION["signup_data"]["username"] ?>" class="form-control form-control-lg" required/>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php if(isset($_SESSION["signup_data"]["email"])) echo $_SESSION["signup_data"]["email"] ?>" class="form-control form-control-lg" required/>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="pwd">Password</label>
                        <input type="password" id="pwd" name="pwd" class="form-control form-control-lg" required/>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg" required/>
                    </div>
                    
                    <div class="pt-1 mb-4">
                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit" name="submit">Create Account</button>
                    </div>

                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? <a href="../login/login_form.php"
                        style="color: #393f81;">Log in here.</a></p>
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

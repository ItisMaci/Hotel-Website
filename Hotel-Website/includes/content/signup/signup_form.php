<?php
require_once __DIR__ . '/signup_view.inc.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: /web-project/index.php");
    exit();
}
?>

<section class="hero_style">
  <div class="container py-5">
    <div class="row d-flex justify-content-center align-items-stretch">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <!-- Image Column -->
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="images/palmtree_unsplash.jpg"
                alt="registration form" class="img-fluid h-100" style="border-radius: 1rem 0 0 1rem; object-fit: cover;" />
            </div>
            <!-- Form Column -->
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <!-- REGISTER FORM -->
                <form action="includes/content/signup/signup.inc.php" method="post">

                    <div class="d-flex align-items-center mb-3 pb-1">
                        <i class="fas fa-cubes fa-2x" style="color: #ff6219;"></i>
                        <span class="h1 fw-bold mb-0">Register</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create a new account</h5>

                    <!-- Fehleranzeigen -->
                    <?php check_signup_errors(); ?>

                    <!-- Inputs generieren -->
                    <?php signup_inputs(); ?>

                    <div class="pt-1 mb-4">
                        <button class="btn btn-dark btn-lg btn-block" type="submit" name="submit">Create Account</button>
                    </div>

                    <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? <a href="index.php?page=login"
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
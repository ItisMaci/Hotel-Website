<?php
  require_once('check_availability.php');
  // Überprüfen, ob Sitzung schon gestartet ist
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /Hotel-Website/index.php"); // Zurück zu index.php, wenn nicht eingeloggt
    exit();
  }

  if (isset($_SESSION['post_data'])) {
    $_POST = $_SESSION['post_data'];
    unset($_SESSION['post_data']);  
  }

  // Calculates days between checkin and checkout
  if (isset($_POST["checkin"]) && isset($_POST["checkout"])) {
      $checkin = new DateTime($_POST["checkin"]);
      $checkout = new DateTime($_POST["checkout"]);
      $interval = $checkin->diff($checkout);
      $totalnights = $interval->days;
  }

  // initialize sum
  $sum = 0;
?>

<section class="bg-body-tertiary py-5">
  <div class="container">
    <!-- LOGO and text -->
    <div class="py-5 text-center">
        <h1 class="fw-bold display-4" href="/web-project/index.php?page=home">XENIA <i class="bi bi-lightning-charge-fill" style="color: #6C63FF"></i></h1>
      <h2>Checkout form</h2>
      <p class="lead">Choose your prefered payment method and continue to checkout.</p>
    </div>

    <!-- Content -->
    <div class="row g-5">

      <!-- Cart -->
      <div class="col-md-5 col-lg-4 order-md-last" data-np-autofill-form-type="other" data-np-checked="1" data-np-watching="1">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?php echo "Room " . $selected_room['room_type'];?></h6>
              <small class="text-body-secondary"><?php echo "€ " . $selected_room['price'] . " for " . $totalnights . " nights"?></small>
            </div>
            <span class="text-body-secondary">€ <?php echo number_format($selected_room['price']*$totalnights, 2); $sum += $selected_room['price']*$totalnights;?></span>
          </li>

          <?php if (!empty($options)): ?>
              <?php foreach ($options as $option): ?>
                <?php if(isset($_POST[$option["description"]])):?>
                  <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                      <h6 class="my-0 text-capitalize"><?php echo $option['description']?></h6>
                      <small class="text-body-secondary"><?php echo "€ " . number_format($option['price'], 2) . " for " . $totalnights . " nights"?></small>
                    </div>
                    <span class="text-body-secondary">€ <?php echo number_format($totalnights*$option['price'], 2); $sum += $totalnights*$option['price'];?></span>
                  </li> <?php endif; ?>
              <?php endforeach; endif; ?>

          <li class="list-group-item d-flex justify-content-between">
            <span>Total (EUR)</span>
            <strong>€ <?php echo number_format($sum, 2); ?></strong>
          </li>
        </ul>
      </div>

      <div class="col-md-7 col-lg-8">
        <!-- Payment -->
        <hr class="my-4">

        <h4 class="mb-3">Payment</h4>
        <form action="checkout.inc.php" method="post">
          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="payment_method" type="radio" class="form-check-input" value="cash" checked="" required="">
              <label class="form-check-label" for="credit">Cash (Pay at the hotel)</label>
            </div>
            <div class="form-check">
              <input id="debit" name="payment_method" type="radio" class="form-check-input" value="debit" disabled>
              <label class="form-check-label text-secondary" for="debit">More payment methods available soon...</label>
            </div>
          </div>

          <input type="hidden" name="room_id" value="<?php echo $selected_room['room_id']; ?>">
          <input type="hidden" name="checkin" value="<?php echo $_POST['checkin']; ?>">
          <input type="hidden" name="checkout" value="<?php echo $_POST['checkout']; ?>">
          <input type="hidden" name="breakfast_included" value="<?php echo isset($_POST['breakfast']) ? 1 : 0; ?>">
          <input type="hidden" name="parking_included" value="<?php echo isset($_POST['parking']) ? 1 : 0; ?>">
          <input type="hidden" name="pets_included" value="<?php echo isset($_POST['pets']) ? 1 : 0; ?>">
          <input type="hidden" name="price_total" value="<?php echo $sum; ?>">

          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Book Now</button>
        </form>

      </div>
    </div>
  </div>
</section>
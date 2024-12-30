<section class="bg-body-tertiary py-5">
<div class="container">
    <div class="py-5 text-center">
        <h1 class="fw-bold display-4" href="/web-project/index.php?page=home">XENIA <i class="bi bi-lightning-charge-fill" style="color: #6C63FF"></i></h1>
      <h2>Checkout form</h2>
      <p class="lead">Choose your prefered payment method and continue to checkout.</p>
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last" data-np-autofill-form-type="other" data-np-checked="1" data-np-watching="1">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill">3</span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Product name</h6>
              <small class="text-body-secondary">Brief description</small>
            </div>
            <span class="text-body-secondary">$12</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Second product</h6>
              <small class="text-body-secondary">Brief description</small>
            </div>
            <span class="text-body-secondary">$8</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Third item</h6>
              <small class="text-body-secondary">Brief description</small>
            </div>
            <span class="text-body-secondary">$5</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>$20</strong>
          </li>
        </ul>

      </div>

      <div class="col-md-7 col-lg-8">

      <hr class="my-4">

          <h4 class="mb-3">Payment</h4>
        <form action="#" method="post">
          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked="" required="">
              <label class="form-check-label" for="credit">Cash (Pay at the hotel)</label>
            </div>
            <div class="form-check">
              <input id="debit" name="paymentMethod" type="radio" class="form-check-input" disabled>
              <label class="form-check-labeln text-secondary" for="debit">More payment methods avaiable soon...</label>
            </div>
          </div>

          <div class="row gy-3">
            <div class="col-md-6">
                
            </div>

            
          </div>

          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
        </form>
      </div>
    </div>
</section>
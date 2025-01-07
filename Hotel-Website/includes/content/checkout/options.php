<?php
    // Überprüfen, ob Sitzung schon gestartet ist
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        $error_msg = 'To book a room, you need to be <a class="text-decoration-underline" href="/Hotel-Website/index.php?page=login">logged in</a>. If you don not have an account, please <a class="text-decoration-underline" href="/Hotel-Website/index.php?page=signup">sign up</a>.';
        header("Location: /Hotel-Website/index.php?page=rooms&error=$error_msg"); // Zurück zu rooms.php, wenn nicht eingeloggt
        exit();
    }

    // today and tomorrow dates to use as min values for checkin and checkout
    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
?>

<section>
    <div class="container">
        <div class="row gy-4">
            <?php if ($selected_room): ?>
                <div class="col">
                    <div class="card shadow">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <img src="<?php echo htmlspecialchars($selected_room['image_reference']); ?>" class="card-img-top border border-5 border-white" alt="Room Image">
                            </div>
                            <div class="col">
                                <div class="card-body">
                                    <h5 class="card-title">Room #<?php echo $selected_room['room_id']; ?> - <?php echo $selected_room['room_type']; ?></h5>
                                    <p class="card-text"><?php echo $selected_room['description']; ?></p>
                                    <p class="card-text"><strong>Price:</strong> € <?php echo $selected_room['price']; ?>/night</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-center">No room selected.</p>
            <?php endif; ?>
        </div>
        
        <!-- Extras -->
        <div class="container py-5">
            <h2 class="py-2">Extras:</h2>
            <form action="checkout_index.php?page=checkout" method="post">
                <input type="hidden" name="room_id" value="<?php echo $selected_room['room_id']; ?>">
                <div class="row gx-2 fs-5">
                    <?php if (!empty($options)): ?>
                        <?php foreach ($options as $option): ?>
                            <div class="col-lg-6 px-5 form-check">
                                <input type="checkbox" class="form-check-input" name="<?php echo $option['description']?>" id="<?php echo $option['description']?>">
                                <label class="form-check-label d-flex justify-content-between" for="<?php echo $option['description']?>">
                                    <span class="text-capitalize"><?php echo $option['description']?></span>
                                    <span><b>€<?php echo $option['price']?></b> per night</span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">No options available.</p>
                    <?php endif; ?>

                    <!-- Check In / Check Out -->
                    <div class="col-lg-12">
                        <div class="row gx-2">
                            <div class="col-6">
                                <label for="checkin" class="form-label">From</label>
                                <input type="date" id="checkin" name="checkin" min="<?php echo $today; ?>" value="<?php echo htmlspecialchars($checkin); ?>" class="form-control" required onchange="updateCheckoutMin()">
                            </div>
                            <div class="col-6">
                                <label for="checkout" class="form-label">To</label>
                                <input type="date" id="checkout" name="checkout" min="<?php echo $tomorrow; ?>" value="<?php echo htmlspecialchars($checkout); ?>" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <button class="w-100 btn btn-primary btn-lg my-3" type="submit">Continue to checkout</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    function updateCheckoutMin() {
        // get the checkin/checkout references
        var checkin = document.getElementById('checkin').value;
        var checkout = document.getElementById('checkout');

        // set the min value of checkout 1 higher than the checkin
        var checkinDate = new Date(checkin);
        checkinDate.setDate(checkinDate.getDate() + 1);
        var minCheckoutDate = checkinDate.toISOString().split('T')[0];
        checkout.min = minCheckoutDate;
    }
</script>
<?php
    require_once("rooms_fetch.php");

    // today and tomorrow dates to use as min values for checkin and checkout
    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
?>

<section class="py-4 min-vh-100">
    <?php if (!empty($_GET["error"])) {?>
        <div class='text-center alert alert-warning alert dismissible fade show d-flex justify-content-center align-items-center' role='alert'>
            <strong><?php echo $_GET['error'] ?? '';?></strong>
        </div> 
    <?php } ?>
    <!-- Search Bar -->
    <div class="container border border-light-subtle shadow p-3 mb-5 rounded-5">
        <form action="index.php?page=rooms" method="post">
            <div class="row gy-3 justify-content-center align-items-center">
                <!-- Check In / Check Out -->
                <div class="col-lg-6">
                    <div class="row gx-2">
                        <div class="col-6">
                            <label for="checkin" class="form-label">From</label>
                            <input type="date" id="checkin" name="checkin" min="<?php echo $today; ?>" value="<?php echo $_POST["checkin"] ?? ""; ?>" class="form-control" required onchange="updateCheckoutMin()">
                        </div>
                        <div class="col-6">
                            <label for="checkout" class="form-label">To</label>
                            <input type="date" id="checkout" name="checkout" min="<?php echo $tomorrow; ?>" value="<?php echo $_POST["checkout"] ?? ""; ?>" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary w-100 w-lg-auto">Check Availability</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Room Display Section -->
    <div class="container">
        <div class="row gy-4">
            <?php if (!empty($rooms)): ?>
                <?php foreach ($rooms as $room): ?>
                    <div class="col-lg-4">
                        <div class="card shadow">
                            <img src="<?php echo htmlspecialchars($room['image_reference']); ?>" class="card-img-top" alt="Room Image">
                            <div class="card-body">
                                <h5 class="card-title">Room #<?php echo $room['room_id']; ?> - <?php echo $room['room_type']; ?></h5>
                                <p class="card-text"><?php echo $room['description']; ?></p>
                                <p class="card-text"><strong>Price:</strong> € <?php echo $room['price']; ?>/night</p>
                                <form action="includes/content/checkout/checkout_index.php?page=options" method="post">
                                    <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
                                    <input type="hidden" name="checkin" value="<?php echo $_POST['checkin'] ?? ''; ?>">
                                    <input type="hidden" name="checkout" value="<?php echo $_POST['checkout'] ?? ''; ?>">
                                    <button class="w-100 btn btn-primary btn-lg text-uppercase"> Select Room </button>
                                </form>                            
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No rooms available.</p>
            <?php endif; ?>
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

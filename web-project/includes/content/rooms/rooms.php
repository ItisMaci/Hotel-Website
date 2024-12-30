<?php
    require_once("rooms_fetch.php");
?>

<section class="py-4">

    <!-- Search Bar -->
    <div class="container border border-light-subtle shadow p-3 mb-5 rounded-5">
        <form action="index.php?page=rooms" method="post" onsubmit="return validateDates()">
            <div class="row gy-3 justify-content-center align-items-center">
                <!-- Check In / Check Out -->
                <div class="col-lg-6">
                    <div class="row gx-2">
                        <div class="col-6">
                            <label for="checkin" class="form-label">Arrival</label>
                            <input type="date" id="checkin" name="checkin" value="<?php echo $_POST["checkin"] ?? ""; ?>" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label for="checkout" class="form-label">Departure</label>
                            <input type="date" id="checkout" name="checkout" value="<?php echo $_POST["checkout"] ?? ""; ?>" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary w-100 w-lg-auto">Search</button>
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
                                <p class="card-text"><strong>Status:</strong> <?php echo $room['status']; ?></p>
                                <a href="includes/checkout/checkout_index.php" class="w-100 btn btn-primary btn-lg text-uppercase"> Book now </a>
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
    document.addEventListener("DOMContentLoaded", function() {
        const today = new Date().toISOString().split("T")[0];
        const checkinInput = document.getElementById("checkin");
        const checkoutInput = document.getElementById("checkout");

        // Set the minimum date for both inputs to today
        checkinInput.setAttribute("min", today);
        checkoutInput.setAttribute("min", today);

        // Add event listeners to validate the dates dynamically
        checkinInput.addEventListener("change", function() {
            const checkinDate = checkinInput.value;
            if (checkinDate) {
                const nextDay = new Date(checkinDate);
                nextDay.setDate(nextDay.getDate() + 1);
                checkoutInput.setAttribute("min", nextDay.toISOString().split("T")[0]);
            }
        });

        checkoutInput.addEventListener("change", function() {
            const checkoutDate = checkoutInput.value;
            const checkinDate = checkinInput.value;
            if (checkoutDate && checkinDate && checkoutDate <= checkinDate) {
                alert("Departure date must be at least one day after arrival date.");
                checkoutInput.value = "";
            }
        });
    });

    function validateDates() {
        const checkinInput = document.getElementById("checkin");
        const checkoutInput = document.getElementById("checkout");

        const checkinDate = checkinInput.value;
        const checkoutDate = checkoutInput.value;

        if (!checkinDate || !checkoutDate) {
            alert("Please select both arrival and departure dates.");
            return false;
        }

        if (checkoutDate <= checkinDate) {
            alert("Departure date must be at least one day after arrival date.");
            return false;
        }

        return true;
    }
</script>

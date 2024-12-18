<?php
    include("booking_fetch.php");
?>

<section>
<div class="container mt-5">
        <h1 class="mb-4">Verfügbare Räume</h1>
        <!-- Date Selection Form -->
        <form method="GET" action="available_rooms.php" class="row mb-4">
            <div class="col-md-4">
                <label for="from_date" class="form-label">Check-in Datum</label>
                <input type="date" id="from_date" name="from_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="to_date" class="form-label">Check-out Datum</label>
                <input type="date" id="to_date" name="to_date" class="form-control" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Verfügbarkeit prüfen</button>
            </div>
        </form>

        <!-- Display Rooms -->
        <div class="row">
            <?php foreach ($rooms as $room): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= $room['image_url'] ?>" class="card-img-top" alt="<?= $room['room_name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $room['room_number'] ?></h5>
                            <p class="card-text"><?= $room['status'] ?></p>
                            <p class="card-text"><?= $room['description'] ?></p>
                            <p class="card-text"><strong>Type:</strong> <?= $room['room_type'] ?></p>
                            <p class="card-text"><strong>Price:</strong> $<?= $room['price'] ?>/night</p>
                            <a href="booking.php?room_id=<?= $room['id'] ?>&from_date=<?= $_GET['from_date'] ?? '' ?>&to_date=<?= $_GET['to_date'] ?? '' ?>" 
                               class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
    require_once("options_fetch.php");
?>

<section>
    <div class="container py-5">
        <p class="text">You now have the option to select extras.</p>
        <h2 class="py-2">Extras:</h2>
        <form action="checkout_index.php?page=payment" method="post">
            <div class="row gx-2 fs-5">
                <?php if (!empty($options)): ?>
                    <?php foreach ($options as $option): ?>
                        <div class="col-4 form-check">
                            <input type="checkbox" class="form-check-input" id="<?php echo $option['description']?>">
                            <label class="form-check-label" name="<?php echo $option['description']?>" for="<?php echo $option['description']?>"><?php echo "<span class='text-uppercase'>".$option['description']."</span> <b>€".($option['price']*5)."</b> for <b>" ."5". "</b> nights"?></label>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <p class="text-center">No rooms available.</p>
                <?php endif; ?>

                <button class="w-100 btn btn-primary btn-lg my-3" type="submit">Continue to payment</button>
            </div>
        </form>
    </div>
</section>
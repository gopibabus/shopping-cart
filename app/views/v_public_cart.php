<?php include('includes/public_header.php'); ?>

    <div id="content">
        <h2>
            Shopping Cart
        </h2>
        <ul class="alerts">
            <?php $this->getAlerts(); ?>
        </ul>
        <form action="" method="post">
            <ul class="cart">
                <?php $this->getData('cartRows'); ?>
            </ul>
            <div class="buttons_row">
                <a class="button_alt" href="?empty">Empty Cart</a>
                <input type="submit" name="update" class="button_alt" value="Update Cart">
            </div>
        </form>

        <?php
        $items = $this->getData('cartTotalItems', false);
        if ($items > 0) {
            ?>
            <form action="checkout.php" method="post">
                <div class="submit_row">
                    <input type="submit" name="submit" class="button" value="Pay with PayPal">
                </div>
            </form>
        <?php } ?>
    </div>

<?php include('includes/public_footer.php'); ?>
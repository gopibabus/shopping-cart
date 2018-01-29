<?php include('includes/public_header.php'); ?>

    <div id="content">
        <h2>
            Shopping Cart
        </h2>
        <ul>
            <?php $this->getAlerts(); ?>
        </ul>
        <form action="" method="post">
            <ul class="cart">
                <li class="header_row">
                    <div class="col1">Product Name:</div>
                    <div class="col2">Quantity:</div>
                    <div class="col3">Product Price:</div>
                    <div class="col4">Total Price:</div>
                </li>
                <li>
                    <div class="col1">Beach Toys</div>
                    <div class="col2"><input name="product" value="1"></div>
                    <div class="col3">$8.99</div>
                    <div class="col4">$8.99</div>
                </li>
                <li class="subtotal_row">
                    <div class="col1">Subtotal:</div>
                    <div class="col2">$8.99:</div>
                </li>
                <li class="shipping_row">
                    <div class="col1">Shipping Cost:</div>
                    <div class="col2">$2.00:</div>
                </li>
                <li class="taxes_row">
                    <div class="col1">Taxes(8.75%)</div>
                    <div class="col2">$0.79:</div>
                </li>
                <li class="total_row">
                    <div class="col1">Total:</div>
                    <div class="col2">$11.78</div>
                </li>
            </ul>
            <div class="buttons_row">
                <a class="button_alt" href="?empty">Empty Cart</a>
                <input type="submit" name="update" class="button_alt" value="Update Cart">
            </div>
        </form>
        <form action="" method="post">
            <div class="submit_row">
                <input type="submit" name="submit" class="button" value="Pay with PayPal">
            </div>
        </form>
    </div>

<?php include('includes/public_footer.php'); ?>
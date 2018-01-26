<?php include('includes/public_header.php'); ?>

<div id="content">
    <h2>
        All Products
    </h2>
    <ul>
        <?php $this->getAlerts(); ?>
    </ul>
    <p>
        <?php $this->getData('header'); ?>
    </p>
    <ul class="products">
     <?php $this->getData('products') ?>
    </ul>
</div>

<?php include('includes/public_footer.php'); ?>
<?php include('includes/public_header.php'); ?>

    <div id="content">
        <img class="product_image" src="<?php $this->getData('prodImage'); ?>" alt="<?php $this->getData('prod_name') ?>">
        <h2><?php $this->getData('prodName'); ?></h2>
        <div class="price"><?php $this->getData('prodPrice'); ?></div>
        <div class="description"><?php $this->getData('prodDescription'); ?></div>
        <a href="cart?add=<?php $this->getData('prodId'); ?>" class="button"> Add to Cart</a>
    </div>

<?php include('includes/public_footer.php'); ?>
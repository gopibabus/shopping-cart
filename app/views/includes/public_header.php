<!Doctype html>
<html>
<head>
    <title>
        <?php $this->getData('pageTitle'); ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href=<?php echo STYLE_PATH;?>style.css media="all" rel="stylesheet" type="text/css">
</head>
<body class="<?php $this->getData('pageClass'); ?>">
    <div id="wrapper">
        <div class="secondarynav">
            <strong>0 items ($0.00) in the cart</strong> &nbsp;| &nbsp;
            <a href="<?php echo SITE_PATH; ?>cart.php">Shopping Cart</a>
        </div>
        <h1>
            <?php echo SITE_NAME?>
        </h1>
        <ul class="nav">
            <?php $this->getData('pageNav'); ?>
        </ul>
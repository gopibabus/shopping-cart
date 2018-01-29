<?php

include('app/init.php');

$Template->setData('pageClass', 'shoppingcart');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    //check if adding a valid item
    if (!$Products->productExists($_GET['id'])) {
        $Template->setAlert('Invalid Item');
        $Template->redirect(SITE_PATH . 'cart.php');

    }

    //add item to teh cart
    if (isset($_GET['num']) && is_numeric($_GET['num'])) {
        $Cart->add($_GET['id'], $_GET['num']);
        $Template->setAlert('Items are added to the cart');
    } else {
        $Cart->add($_GET['id']);
        $Template->setAlert('Item has been added to the cart');
    }
    $Template->redirect(SITE_PATH . 'cart.php');
}

if (isset($_GET['empty'])) {
    $Cart->emptyCart();
    $Template->setAlert('Shopping Cart Emptied!!');
    $Template->redirect(SITE_PATH . 'cart.php');

}
//get items in the cart
$display = $Cart->createCart();
$Template->setData('cartRows', $display);

//get category nav
$categoryNav = $Categories->createCategoryNav('');
$Template->setData('pageNav', $categoryNav);

$Template->load('app/views/v_public_cart.php', 'Shopping Cart');
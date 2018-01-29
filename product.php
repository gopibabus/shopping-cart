<?php

include('app/init.php');

$Template->setData('pageClass', 'product');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // show the product
    $product = $Products->get($_GET['id']);
    if (!empty($product)) {
        //pass the data to view
        $Template->setData('prodId', $_GET['id']);
        $Template->setData('prodName', $product['name']);
        $Template->setData('prodDescription', $product['description']);
        $Template->setData('prodPrice', $product['price']);
        $Template->setData('prodImage', IMAGE_PATH . $product['image']);

        //Create Category Navigation
        $categoryNav = $Categories->createCategoryNav($product['category_name']);
        $Template->setData('pageNav', $categoryNav);

        //display view
        $Template->load('app/views/v_public_product.php', $product['name']);

    } else {
        //here we are just redirecting to home page
        $Template->redirect(SITE_PATH);
    }

} else {
    //error
    //here we are just redirecting to home page
    $Template->redirect(SITE_PATH);
}
<?php

include('app/init.php');

$Template->setData('pageClass', 'home');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    //get products from specific category
    $category = $Categories->getCategories($_GET['id']);

    //check if valid
    if (!empty($category)) {
        //get category nav
        $categoryNav = $Categories->createCategoryNav($category['name']);
        $Template->setData('pageNav', $categoryNav);

        //get all products from that category
        $categoryProducts = $Products->createProductTable(4, $_GET['id']);

        if (!empty($categoryProducts)) {
            $Template->setData('products', $categoryProducts);
        } else {
            $Template->setData('products', '<li>No Products Exists in this category</li>');
        }
        $Template->load('app/views/v_public_home.php', $category['name']);
    } else {
        //if category is not valid
        $Template->redirect('http://www.google.com');
    }
} else {
    //get all products
    $categoryNav = $Categories->createCategoryNav('home');
    $Template->setData('pageNav', $categoryNav);

    //get  products
    $products = $Products->createProductTable();
    $Template->setData('products', $products);
    $Template->load('app/views/v_public_home.php', 'Welcome!');
}
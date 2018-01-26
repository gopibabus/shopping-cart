<?php

include('app/init.php');

$categoryNav = $Categories->createCategoryNav('home');

$Template->setData('pageNav', $categoryNav);

//get  products

$products = $Products->createProductTable();
$Template->setData('products', $products);


$Template->load('app/views/v_public_home.php', 'Welcome!');
//$Template->redirect('http://www.google.com');
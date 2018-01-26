<?php

include('app/init.php');

$category_nav = $Categories->createCategoryNav('home');

$Template->setData('pageNav', $category_nav);

$Template->load('app/views/v_public_home.php', 'Welcome!');
//$Template->redirect('http://www.google.com');
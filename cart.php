<?php

include('app/init.php');

$Template->setData('pageClass', 'shoppingcart');
$Template->load('app/views/v_public_cart.php', 'Shopping Cart');
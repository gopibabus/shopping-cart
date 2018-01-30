<?php

include('app/init.php');

$Template->setData('pageClass', 'success');

// create payment object
include('app/models/m_payments.php');
$Payments = new Payments();

//execute Payment to finalize
$payerId = htmlspecialchars($_GET['PayerID']);
$paymentId = $_SESSION['paymentId'];
$results = $Payments->executePayment($payerId, $paymentId);

/*echo "<pre>";

print_r($results);
echo "</pre>";
exit;*/

$Template->setData('name', $results->payer->payer_info->first_name. ' '.
    $results->payer->payer_info->last_name);

//clear cart
$Cart->emptyCart();
$Template->setData('cartTotalItems', 0);
$Template->setData('cartTotalCost', '0.00');

//get Category Nav
$categoryNav = $Categories->createCategoryNav('');
$Template->setData('pageNav', $categoryNav);

$Template->load('app/views/v_public_success.php', 'Thanks!!');
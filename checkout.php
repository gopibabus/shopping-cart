<?php
include('app/init.php');

if(isset($_POST)){
    // create payment object
    include('app/models/m_payments.php');
    $Payments = new Payments();

    //get item data
    $items = $Cart->get();

    //get details
    $details['subTotal']= $Cart->getTotalCost();
    $details['shipping']= 0;
    foreach ($items as $item){
        $details['shipping'] += $Cart->getShippingCost($item['price']);
    }
    $details['shipping'] = number_format($details['shipping'], 2);
    $details['tax'] = number_format($details['subTotal'] * SHOP_TAX,2);
    $details['total'] = number_format($details['subTotal'] + $details['shipping'] +
        $details['tax'], 2);

    //sent to PayPal
    $error = $Payments->createPayment($items, $details);
    if($error != NULL){
        $Template->setAlert($error, 'error');
        $Template->redirect('cart.php');
    }
}
else{
    $Template->redirect(SITE_PATH.'cart.php');
}
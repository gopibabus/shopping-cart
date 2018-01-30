<?php

require('vendor/autoload.php');

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
/**
 * Handle all tasks related to payments
 *
 * Class Payments
 */
class Payments
{

    private $apiContext;

    public function __construct()
    {
        $this->apiContext = $this->getApiContext();
    }

///////////////////////////////////////////////////////////////////////////////////////////
//////////////////////*Setters & Getters for Cart*/////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////


    public function getApiContext()
    {
        if (PAYPAL_MODE == 'sandbox') {
            $clientId = PAYPAL_DEVID;
            $clientSecret = PAYPAL_DEVSECRET;
        } else {
            $clientId = PAYPAL_LIVEID;
            $clientSecret = PAYPAL_LIVESECRET;
        }
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );

        // Comment this line out and uncomment the PP_CONFIG_PATH
        // 'define' block if you want to use static file
        // based configuration

        $apiContext->setConfig(
            array(
                'mode' => PAYPAL_MODE,
                'log.LogEnabled' => true,
                'log.FileName' => 'PayPal.log',
                'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
                'cache.enabled' => true
            )
        );

        return $apiContext;
    }

    /**
     * Created PayPal Payment: step 2 & 3
     *
     * @param $items
     * @param $itemDetails
     * @return array|string
     */
    public function createPayment($items, $itemDetails)
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        //set items
        $i = 0;
        $cartItems = [];
        foreach ($items as $item) {
            $cartItems[$i] = new Item();
            $cartItems[$i]
                ->setName($item['name'])
                ->setCurrency(PAYPAL_CURRENCY)
                ->setQuantity($item['quantity'])
                ->setSku("123123")// Similar to `item_number` in Classic API
                ->setPrice($item['price']);
            $i++;
        }

        $itemList = new ItemList();
        $itemList->setItems($cartItems);

        //set details
        $details = new Details();
        $details
            ->setShipping($itemDetails['shipping'])
            ->setTax($itemDetails['tax'])
            ->setSubtotal($itemDetails['subTotal']);

        //set Amount
        $amount = new Amount();
        $amount
            ->setCurrency(PAYPAL_CURRENCY)
            ->setTotal($itemDetails['total'])
            ->setDetails($details);

        //create Transaction
        $transaction = new Transaction();
        $transaction
            ->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("")
            ->setInvoiceNumber(uniqid());

        //create URLs
        $redirectUrls = new RedirectUrls();
        $redirectUrls
            ->setReturnUrl(SITE_PATH . "success.php")
            ->setCancelUrl(SITE_PATH . "cart.php");

        //create Payment
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        //$approvalUrl = $payment->getApprovalLink();
        //$redirectUrl = $payment->getRedirectUrls()->getReturnUrl();

        //"<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirectUrl = $link->getHref();
                break;
            }
        }
        $_SESSION['paymentId'] = $payment->getId();
        if (isset($redirectUrl)) {
            header("Location: $redirectUrl");
            exit;
        }
        //return $payment;
    }

    /**
     * Execute PayPal Payment: step : 4 & 5
     *
     * @param string $payerId
     * @param string $paymentId
     * @return object
     */
    public function executePayment($payerId, $paymentId)
    {
        //$paymentId = $_SESSION['paymentId'];
        $payment = Payment::get($paymentId, $this->apiContext);


        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $this->apiContext);

        return $result;
    }
}
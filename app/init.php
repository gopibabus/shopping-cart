<?php
/**
 * Basic Configuration Settings
 */

//Connect to database
$server = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'ks_shop';
$Database = new mysqli($server, $user, $pass, $db);

//error reporting
mysqli_report(MYSQLI_REPORT_ERROR);
ini_set('display_errors', 1);

//set up constants
define('SITE_NAME', 'My Online Store');
define('SITE_PATH', 'http://localhost:80/projectPaypal/');
define('IMAGE_PATH','http://localhost:80/projectPaypal/resources/images/');
define('STYLE_PATH','http://localhost:80/projectPaypal/resources/css/');

define('SHOP_TAX', '0.0875');

//either sandbox or live paypal credentials
define('PAYPAL_MODE','sandbox');
define('PAYPAL_CURRENCY','USD');
define('PAYPAL_DEVID','AUky_VpfRlsYmeFwtattTzTq8ncgix0cDjlMxqw0yK74prBzaWeQa8H79F9Nb-K5LIwkOB7m8WpR2wo_');
define('PAYPAL_DEVSECRET','EDeujIBkQjcP80oI3Zzz6AZxp3XD1tPRXzIGYl0slVBxxCqYOFKWbdepA8n7EtKbAp9KNSUGZPkgx1IU');
define('PAYPAL_LIVEID','');
define('PAYPAL_LIVESECRET','');


//Include objects
include('models/m_template.php');
include('models/m_categories.php');
include('models/m_products.php');
include('models/m_cart.php');

//Create Objects
$Template = new Template();
$Categories = new Categories();
$Products = new Products();
$Cart = new Cart();

session_start();

//global
$Template->setData('cartTotalItems', $Cart->getTotalItems());
$Template->setData('cartTotalCost', $Cart->getTotalCost());
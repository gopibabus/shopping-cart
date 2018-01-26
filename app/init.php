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
define('SITE_PATH', 'http://localhost:8888/projectPaypal/');
define('IMAGE_PATH','http://localhost:8888/projectPaypal/resources/images/');
define('STYLE_PATH','http://localhost:8888/projectPaypal/resources/css/');

//Include objects
include('models/m_template.php');
include('models/m_categories.php');


//Create Objects
$Template = new Template();
$Categories = new Categories();



session_start();
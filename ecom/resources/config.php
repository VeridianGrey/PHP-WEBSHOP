<?php ob_start();

session_start();
//session_destroy();

defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);


defined("TEMPLATE_FRONT") ? null : define("TEMPLATE_FRONT", __DIR__ . DS . "templates/front");

defined("TEMPLATE_BACK") ? null : define("TEMPLATE_BACK", __DIR__ . DS . "templates/back");

defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY", __DIR__ . DS . "uploads");



$servername = "localhost";
$username = "root";
$password = "usbw";

try {
    $connection = new PDO("mysql:host=$servername;port=3307;dbname=ecom", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }



require_once("functions.php");
require_once("cart.php");






?>
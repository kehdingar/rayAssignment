<?php

namespace ProductProcessing\Controller;

require "../../vendor/autoload.php";

use Product\Model\Session;
use ProductProcessing\Controller\ProductController;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: 'GET,POST, OPTIONS, PUT, PATCH, DELETE'");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

Session::start();

$productController = new ProductController();

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $body = json_decode(file_get_contents('php://input'), true);
    $productController->addProduct($body);
    // clearing all errors if page is reloaded
    unset($_SESSION['errors']);
} else {
    echo json_encode(array("message" => "Not Allowed"));
}

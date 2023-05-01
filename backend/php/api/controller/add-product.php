<?php

require_once "../model/Session.php";
require_once "../model/Product.php";
require_once "ProductController.php";
require_once "../model/DVD.php";
require_once "../model/Book.php";
require_once "../model/config/Crud.php";
require_once "../model/Furniture.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: 'GET'");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

Session::start();

$products = Product::getChildren();
$response = array();
// Get product data for React
foreach ($products as $productType) {
    $product = new $productType();
    $formData = array($productType => [
        'formfields' => $product->prepareFormFields(),
        'message' => $product->getdescriptionMessage(),
        'displayName' => $product->getDisplayName()
    ]);
    array_push($response, $formData);
}

echo json_encode($response);

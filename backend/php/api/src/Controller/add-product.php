<?php
require "../../vendor/autoload.php";

use Product\Model\Product;
use Product\Model\Session;
use Product\Model\Book as Book;
use Product\Model\DVD as DVD;
use Product\Model\Furniture as Furniture;

new DVD();
new Furniture();
new Book();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: 'GET'");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

Session::start();

$products = Product::getChildren();

$response = [];

foreach ($products as $productClass => $productNameSpace) {
    $product = new $productNameSpace();

    $formData = array($productClass => [
        'formfields' => $product->prepareFormFields(),
        'message' => $product->getdescriptionMessage(),
        'displayName' => $product->getDisplayName()
    ]);
    array_push($response, $formData);
}

echo json_encode($response);

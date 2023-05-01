<?php
require_once "ProductController.php";
require_once "../model/Product.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: 'GET,POST, OPTIONS, PUT, PATCH, DELETE'");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');


$body = json_decode(file_get_contents('php://input'), true);

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $productController = new ProductController();
    $productController->setProductIds($body);
    $productController->deleteProduct();
    echo json_encode("success");
}

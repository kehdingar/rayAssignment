<?php

namespace ProductProcessing\Controller;

require_once '../../vendor/autoload.php';

use ProductProcessing\Controller\ListProducts as ListProducts;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: 'GET'");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
?>

<?php
$response = array();
$listProducts = new ListProducts();
$products = $listProducts->queryProducts();
echo json_encode(array("products" => $products));

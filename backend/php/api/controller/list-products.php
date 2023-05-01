<?php
require_once "ListProducts.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: 'GET'");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
?>

<?php
$response = array();
$listProducts = new ListProducts();
$products = $listProducts->queryProducts();
echo json_encode(array("products" => $products));

<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 

include_once '../../database/dbconfig.php';
include_once '../../objects/cart.php';
 
$database = new Database();
$db = $database->getConnection();
 
$cart = new Cart($db);
 
$cart->id_user = isset($_GET['id_user']) ? $_GET['id_user'] : die();
 
$cart->readOneByIdUser();
 
if($cart->id_cart!=null){
    $cart_arr=array(
        "id_cart" => $cart->id_cart,
        "id_user" => $cart->id_user,
        "date" => $cart->date
    );
 
    http_response_code(200);
 
    echo json_encode($cart_arr);
}
 
else{
    http_response_code(404);
 
    echo json_encode(array("message" => "Product does not exist."));
}
?>
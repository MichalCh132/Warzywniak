<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../../database/dbconfig.php';
include_once '../../objects/Cart_position.php';
 
$database = new Database();
$db = $database->getConnection();
 
$cart = new Cart_position($db);

$json = file_get_contents("php://input");
$data = json_decode($json);

$regquantity='/^[0-9|.]{1,6}$/';
$regprice='/^[0-9|.]{1,6}$/';
$regiditem='/^[0-9]{1,6}$/';
$regidcart='/^[0-9]{1,6}$/';

if(!preg_match($regquantity,$data->quantity)){
    echo json_encode(array("message" => "Wrong quantity"));
    return;}
if(!preg_match($regprice,$data->price)){
    echo json_encode(array("message" => "Wrong price"));
    return;}
if(!preg_match($regiditem,$data->id_item)){
    echo json_encode(array("message" => "Wrong id item"));
    return;}
if(!preg_match($regidcart,$data->id_cart)){
    echo json_encode(array("message" => "Wrong id cart"));
    return;}

if(
    !empty($data->quantity)&&
    !empty($data->price)&&
    !empty($data->id_cart)&&
    !empty($data->id_item)
){
 
    $cart->quantity = $data->quantity;
    $cart->price = $data->price;
    $cart->id_cart = $data->id_cart;
    $cart->id_item = $data->id_item;
    if($cart->create()){
 
        http_response_code(201);

        echo json_encode(array("message" => "Product was created."));
    }
 
    else{
 
        http_response_code(503);
 
        echo json_encode(array("message" => "Unable to create product."));
    }
}
 
else{
 
    http_response_code(400);
 
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}

?>
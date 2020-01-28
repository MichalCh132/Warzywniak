<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../../database/dbconfig.php';
include_once '../../objects/item.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Item($db);
 
$data = json_decode(file_get_contents("php://input"));
$item->id_item = $data->id_item;
$item->name = $data->name;
$item->price = $data->price;
$item->describe = $data->describe;
$item->available = $data->available;

$regiditem='/^[0-9]{1,10}$/';
$regname='/^[a-z|A-Z|\s]{2,20}$/';
$regprice='/^[0-9|.]{1,6}$/';

if(!preg_match($regiditem,$item->id_item)){
    echo json_encode(array("message" => "Wrong id user"));
    return;}
if(!preg_match($regname,$data->name)){
    echo json_encode(array("message" => "Wrong name"));
    return;}
if(!preg_match($regprice,$data->price)){
    echo json_encode(array("message" => "Wrong price"));
    return;}
    
    
if($item->update()){
 
    http_response_code(200);
 
    echo json_encode(array("message" => "Product was updated."));
}
 
else{
 
    http_response_code(503);
 
    echo json_encode(array("message" => "Unable to update product."));
}
?>
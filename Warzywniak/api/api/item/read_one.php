<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../../database/dbconfig.php';
include_once '../../objects/item.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Item($db);
 
$item->id_item = isset($_GET['id']) ? $_GET['id'] : die();
 
$regiditem='/^[0-9]{1,10}$/';
if(!preg_match($regiditem,$data->id_item)){
    echo json_encode(array("message" => "Wrong id item"));
    return;}
    
$item->readOne();
 
if($item->name!=null){
    $item_arr=array(
        "id_item" => $item->id_item,
        "name" => $item->name,
        "describe" => $item->describe,
        "price" => $item->price,
        "image" => $item->image,
        "available" => $item->available
    );
 
    http_response_code(200);
 
    echo json_encode($item_arr);
}
 
else{
    http_response_code(404);
 
    echo json_encode(array("message" => "Product does not exist."));
}
?>
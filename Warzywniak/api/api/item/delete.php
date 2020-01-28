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
 
$json = file_get_contents("php://input");
$data = json_decode($json);

$regiditem='/^[0-9]{1,10}$/';
if(!preg_match($regiditem,$data->id_item)){
    echo json_encode(array("message" => "Wrong id item"));
    return;}

$item->id_item = $data->id_item;
if($item->delete()){
 
    http_response_code(200);
    
    echo json_encode(array("message" => "item was deleted."));
}
 
else{
 
    http_response_code(503);
 
    echo json_encode(array("message" => "Unable to delete item."));
}
?>
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../database/dbconfig.php';
include_once '../../objects/item.php';

$database = new Database();
$db = $database->getConnection();
 
$item = new Item($db);
 
$stmt = $item->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $item_arr=array();
    $item_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $single_item=array(
            "id_item" => $id_item,
            "name" => $name,
            "describe" => html_entity_decode($describe),
            "price" => $price,
            "image" => $image,
            "available" => $available
        );
        array_push($item_arr["records"], $single_item);
    }
 
    http_response_code(200);
 
    echo json_encode($item_arr);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "No products found.")
    );
}

?>
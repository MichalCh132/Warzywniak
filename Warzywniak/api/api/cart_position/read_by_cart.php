<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../database/dbconfig.php';
include_once '../../objects/cart_position.php';

$database = new Database();
$db = $database->getConnection();
 
$cart_position = new Cart_position($db);
 
$cart_position->id_cart = isset($_GET['idcart']) ? $_GET['idcart'] : die();
$stmt = $cart_position->read_by_cart();
$num = $stmt->rowCount();
 
if($num>0){
    $cart_position_arr=array();
    $cart_position_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $single_cart_position=array(
            "id_cart_positions" => $id_cart_positions,
            "quantity" => $quantity,
            "price" => $price,
            "id_cart" => $id_cart,
            "id_item" => $id_item,
        );
        array_push($cart_position_arr["records"], $single_cart_position);
    }
 
    http_response_code(200);
 
    echo json_encode($cart_position_arr);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "No products found.")
    );
}

?>
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../database/dbconfig.php';
include_once '../../objects/cart.php';

$database = new Database();
$db = $database->getConnection();

$cart = new Cart($db);
 
$cart->id_user = isset($_GET['iduser']) ? $_GET['iduser'] : die();
$stmt = $cart->read_by_user();
$num = $stmt->rowCount();
 
if($num>0){
 
    $cart_arr=array();
    $cart_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $single_cart=array(
            "id_cart" => $id_cart,
            "data" => $data,
            "id_user" => $id_user
        );
        array_push($cart_arr["records"], $single_cart);
    }
 
    http_response_code(200);
 
    echo json_encode($cart_arr);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "No products found.")
    );
}

?>
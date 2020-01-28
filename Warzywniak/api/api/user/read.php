<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../database/dbconfig.php';
include_once '../../objects/User.php';

$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
$stmt = $user->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $user_arr=array();
    $user_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $single_item=array(
            "id_user" => $id_user,
            "name" => $name,
            "phone" => html_entity_decode($phone),
            "email" => $email,
            "password" => $password
        );
        array_push($user_arr["records"], $single_item);
    }
 
    http_response_code(200);
 
    echo json_encode($user_arr);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "No products found.")
    );
}

?>
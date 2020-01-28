<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 

include_once '../../database/dbconfig.php';
include_once '../../objects/User.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
$user->id_user = isset($_GET['id']) ? $_GET['id'] : die();
 
$regiduser='/^[0-9]{1,10}$/';
if(!preg_match($regiduser,$user->id_user)){
    echo json_encode(array("message" => "Wrong id user"));
    return;}

$user->readOne();
 
if($user->name!=null){
    $user_arr=array(
        "id_user" => $user->id_user,
        "name" => $user->name,
        "phone" => $user->phone,
        "email" => $user->email,
        "password" => $user->password
    );
 
    http_response_code(200);
 
    echo json_encode($user_arr);
}
 
else{
    http_response_code(404);
 
    echo json_encode(array("message" => "Product does not exist."));
}
?>
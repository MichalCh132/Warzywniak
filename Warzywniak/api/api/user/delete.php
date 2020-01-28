<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../../database/dbconfig.php';
include_once '../../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
$json = file_get_contents("php://input");
$data = json_decode($json);

$regiduser='/^[0-9]{1,10}$/';
if(!preg_match($regiduser,$data->iduser)){
    echo json_encode(array("message" => "Wrong id user"));
    return;}

$user->id_user = $data->iduser;



if($user->delete()){
 
    http_response_code(200);
    
    echo json_encode(array("message" => "user was deleted."));
}
 
else{
 
    http_response_code(503);
 
    echo json_encode(array("message" => "Unable to delete user."));
}
?>
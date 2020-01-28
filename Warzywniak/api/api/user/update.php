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
 

$data = json_decode(file_get_contents("php://input"));

$regname='/^[a-z|A-Z]{2,20}$/';
$regemail='/^[a-zA-Z0-9-_.]+@[a-z0-9-.]+.[a-z0-9]{1,6}$/';
$regphone='/^[0-9]{9,11}$/';
$regpass='/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?!.*\s).{8,}$/';
$regiduser='/^[0-9]{1,10}$/';

if(!preg_match($regname,$data->name)){
    echo json_encode(array("message" => "Wrong name"));
    return;}
if(!preg_match($regemail,$data->email)){
    echo json_encode(array("message" => "Wrong email"));
    return;}
if(!preg_match($regphone,$data->phone)){
    echo json_encode(array("message" => "Wrong phone number"));
    return;}
if(!preg_match($regpass,$data->password)){
    echo json_encode(array("message" => "Wrong password"));
    return;}
if(!preg_match($regiduser,$data->iduser)){
    echo json_encode(array("message" => "Wrong id user"));
    return;}
    
$user->id_user = $data->id_user;
$user->name = $data->name;
$user->email = $data->email;
$user->phone = $data->phone;
$user->password = $data->password;
 
if($user->update()){
 
    http_response_code(200);
 
    echo json_encode(array("message" => "Product was updated."));
}
 
else{
 
    http_response_code(503);
 
    echo json_encode(array("message" => "Unable to update product."));
}
?>
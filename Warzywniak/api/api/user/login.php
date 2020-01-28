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
 
$postdata = file_get_contents("php://input");
$request = json_decode($postdata,True);
$email = $request["email"]; 
$password = $request["password"];
$user->readOneByEmail($email);

$regemail='/^[a-zA-Z0-9-_.]+@[a-z0-9-.]+.[a-z0-9]{1,6}$/';
$regpass='/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?!.*\s).{8,}$/';

if(!preg_match($regemail,$email)){
    echo json_encode(array("message" => "Wrong email",
                    "answer" => "REJECTED"));
    return;}
if(!preg_match($regpass,$password)){
    echo json_encode(array("message" => "Wrong password",
                            "answer" => "REJECTED")
                            );
    return;}
$hashed_password = password_hash($password, PASSWORD_BCRYPT,[ 'salt' => 'SolDoProjektuZWebAppps']);
$hashed_password = substr($hashed_password,25,15);
if($hashed_password===$user->password){
$response = array(
    "answer" => "ACCEPTED",
    "id_user" => $user->id_user
);}
else{
    $response = array(
        "answer" => "REJECTED"
    );
}

echo json_encode($response);
?>
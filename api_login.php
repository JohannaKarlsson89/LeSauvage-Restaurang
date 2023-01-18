
<?php
include_once("config.php");
header('Access-Control-Allow-Origin: *');
//the api uses Json
header('Content-Type: application/json');
//what can be used
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
//what headers are allowed
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
//variable what method are made
$method = $_SERVER['REQUEST_METHOD'];



// New instance of the class
$user = new Users();

include_once("config.php");

//what method has ben sent
$method = $_SERVER['REQUEST_METHOD'];

//if method is not post
if($method != "POST") {
    http_response_code(405); //Method not allowed
    $response = array("message" => "Only allowed");
    echo json_encode($response);
    exit;
}

//Transform the body to objekt
$data = json_decode(file_get_contents("php://input"), true);
//set method 
if ($user->setLogIn($data["username"],$data["password"])) {
    //checks so username and password exist in database
   if ($user->logInUser($data["username"],$data["password"]) ) {
        $response = array("message" => "Inloggad", "user" => true);
        http_response_code(200); //Ok
    } else {
        $response = array("message" => "Wrong username and/or password");
        http_response_code(401); //Unauthorized
    }
} else {
    http_response_code(400); //Bad request
    $response = array("message" => "Skicka med användarnamn och lösenord");
    echo json_encode($response);
    exit;
}







//Skickar svar tillbaka till avsändaren
echo json_encode($response);

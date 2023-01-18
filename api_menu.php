
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

//Checks if there is a GET-parameter in url and set it to id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
// New instance of the class
$menu = new Menu();

switch ($method) {
    case 'GET':
        http_response_code(200);
        $response = array("message" => "No menus in database");
    if (isset($id)) {
            //get one menu by id
            $response = $menu->getMenuById($id);
        } else {
            //Get all the menu
            $response = $menu->getMenu();
        }
        if (count($response) === 0) {
            $response = array("message" => "No menus in database");
            //Not found at this url
            http_response_code(404);
        } else {
            // Ok - it worked
            http_response_code(200);
        }
        
        break;
        case 'POST':
      //Save the sent data in a varible and decode to PHP
        $data = json_decode(file_get_contents("php://input"), true);

        if ($menu->setMenu($data["nameMenu"], $data["price"], $data["description"], $data["category"])) {
            if ($menu->CreateMenu($data["nameMenu"], $data["price"], $data["description"], $data["category"])) {
                $response = array("message" => "New menu created");
                http_response_code(201); //Created
            } else {
                http_response_code(500); //Internal server error
                $response = array("message" => "Fel vid registrering av ny meny ");
            }
        } else {
            $response = array("message" => "Fyll i alla fält");
            http_response_code(400); //Bad request
        }
             break;


    case 'PUT':
   
        $data = json_decode(file_get_contents("php://input"), true);

        if ($menu->setMenuId($data["nameMenu"], $data["price"], $data["description"], $data["category"], $data["id"])) {
            if ($menu->updateMenu()) {
                $response = array("message" => "Menu updated");
                http_response_code(201); //Created
            } else {
                http_response_code(500); //Internal server error
                $response = array("message" => "Fel vid uppdatering av meny ");
            }
        } else {
            $response = array("message" => "Fyll i alla fält");
            http_response_code(400); //Bad request
        }
        break;
    
    case 'DELETE':
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id is sent");
        } else {
            if($menu->deleteMenu($id))
            http_response_code(200);
            $response = array("message" => "meny med id=$id är bortagen");
        }
        break;
        
    }

//send back json code to the client
echo json_encode($response);

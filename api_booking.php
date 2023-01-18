
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
$booking= new Booking();

switch ($method) {
    case 'GET':
        http_response_code(200);
        $response = array("message" => "No bookings in database");
    if (isset($id)) {
            //get one course by id
            $response = $booking->getBookingById($id);
        } else {
            //Get all the courses
            $response = $booking->getBooking();
        }
        if (count($response) === 0) {
            $response = array("message" => "No bookings in database");
            //Not found at this url
            http_response_code(404);
        } else {
            // Ok - it worked
            http_response_code(200);
        }
        
        break;
        case 'POST':
            
      //Save the sent data in a varible 
        $data = json_decode(file_get_contents("php://input"), true);
        if ($booking->setBooking($data["guests"], $data["guest_name"], $data["date"], $data["time"], $data["email"])) {
            if ($booking->createBooking( $data["guests"], $data["guest_name"], $data["date"], $data["time"], $data["email"])) {
                $response = array("message" => "New booking created");
                http_response_code(201); //Created
            } else {
                http_response_code(500); //Internal server error
                $response = array("message" => "Fel vid registrering av bokning ");
            }
        } else {
            $response = array("message" => "Fyll i alla fält");
            http_response_code(400); //Bad request
        }
             break;


    case 'PUT':
   
        $data = json_decode(file_get_contents("php://input"), true);

        if ($booking->setBookingId($data["booking_id"],$data["guests"], $data["guest_name"], $data["date"], $data["time"], $data["email"])) {
            //if booking id is correct update booking
            if ($booking->updateBooking()) {
                $response = array("message" => "Booking updated");
                http_response_code(201); //Created
            } else {
                http_response_code(500); //Internal server error
                $response = array("message" => "Something went wrong - Try again! ");
            }
        } else {
            $response = array("message" => "Fill out all inputs");
            http_response_code(400); //Bad request
        }
        break;
   
    case 'DELETE':
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "No id is sent");
        } else {
            if($booking->deleteBooking($id))
            http_response_code(200);
            $response = array("message" => "bokning med id=$id är bortagen");
        }
        break;
       
    }

//send back json code to the client
echo json_encode($response);

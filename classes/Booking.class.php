
<?php
//Class
class Booking
{
    //Members - Properties
    private $db;
    private $booking_id;
    private $guest_name;
    private $guests;
    private $date;
    private $time;
    private $email;


    function __construct()
    { //connect to database
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die('Fel vid anslutning [' . $this->db->connect_error . ']');
        }
    }
    function getBooking()
    {
        $sql = "SELECT * FROM booking;";
        //$result = mysqli_query($this->db, $sql);
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getBookingById(int $id): array
    {
        $id = intval($id);
        //sql query
        $sql = "SELECT * FROM booking WHERE booking_id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }
    //control the booking inputs
    public function setBooking(int $guests, string $guest_name, $date, $time, string $email): bool
    {
        if ($guests and $guest_name and $date and $time and $email != "") {

            $this->guests = $guests;
            $this->guest_name = $guest_name;
            $this->date = $date;
            $this->time = $time;
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }
    //add new booking
    public function createBooking(int $guests, string $guest_name, string $date, string $time, string $email): bool
    {
        //sanitate the inputs
        $guests = $this->db->real_escape_string($guests);
        $guest_name = $this->db->real_escape_string($guest_name);
        $date = $this->db->real_escape_string($date);
        $time = $this->db->real_escape_string($time);
        $email = $this->db->real_escape_string($email);

        $guests = htmlentities($guests, ENT_QUOTES, 'UTF-8');
        $guest_name = htmlentities($guest_name, ENT_QUOTES, 'UTF-8');
        $date = htmlentities($date, ENT_QUOTES, 'UTF-8');
        $time = htmlentities($time, ENT_QUOTES, 'UTF-8');
        $email = htmlentities($email, ENT_QUOTES, 'UTF-8');
        $sql = "INSERT INTO booking(guests, guest_name, date, time, email )VALUES('" . $guests . "','" . $guest_name . "','" . $date . "','" . $time . "','" . $email . "');";
        //send query
        return mysqli_query($this->db, $sql);
    }

    public function setBookingId(int $booking_id, $guests, string $guest_name, $date,  $time, string $email): bool
    { //checking if input is empty
        $booking_id = intval($booking_id);
        $this->booking_id=$booking_id;


        if ($guests != "" && $guest_name != "" && $date != "" && $time != "" && $email != "") {
           // $this->booking_id = $booking_id;
            $this->guests = $guests;
            $this->guest_name = $guest_name;
            $this->date = $date;
            $this->time = $time;
            $this->email = $email;

            //sanitate the inputs
            $guests = $this->db->real_escape_string($guests);
            $guest_name = $this->db->real_escape_string($guest_name);
            $date = $this->db->real_escape_string($date);
            $time = $this->db->real_escape_string($time);
            $email = $this->db->real_escape_string($email);

            return true;
        } else {
            return false;
        }
    }

    public function updateBooking()
    {
        //sql query
       
        $sql = "UPDATE booking SET booking_id='" 
        . $this->booking_id . "', guests='" 
        . $this->guest_name . "', date='" 
        . $this->guests . "', guest_name='"         
         . $this->date . "', time='" 
         . $this->time . "', email='" 
         . $this->email 
         . "' WHERE booking_id=$this->booking_id;";
        //send query
        return mysqli_query($this->db, $sql);
    }
    //delete bookin where id=id
    public function deleteBooking(int $id): bool
    {
        $id = intval($id);
        $sql = "DELETE FROM booking WHERE booking_id=$id;";
        return mysqli_query($this->db, $sql);
    }
    function __destruct()
    {
        mysqli_close($this->db);
    }
}

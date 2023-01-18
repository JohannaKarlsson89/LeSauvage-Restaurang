
<?php


class Users
{
    //properties
    private $db;

    private $username;
    private $password;
    private $user_id;

    //methods

    public function __construct()
    {
        //connect to datebase and shut it down if error code present
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die('Fel vid anslutning [' . $this->db->connect_error . ']');
        }
    }
public function setLogIn (string $username, string $password){
    if ($username != "" and $password !="") {
        $this->username = $username;
        $this->password = $password;
        return true;
    }else {
        return false;
    }
}

    //log in user
    public function logInUser(string $username, string $password): bool
    {
        //sanitate the input
        $username = $this->db->real_escape_string($username);
       $password = $this->db->real_escape_string($password);
        //picks the row from where username=username
        $sql = "SELECT * FROM users WHERE username = '$username';";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            //if returning rows username exist in database
            $row = $result->fetch_assoc();
            //hashed password in databases
            $stored_password = $row['password'];
            //check if password matches
           // $user_id = $row['user_id'];
            if (password_verify($password, $stored_password)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }



    function __destruct()
    {
        mysqli_close($this->db);
    }
}

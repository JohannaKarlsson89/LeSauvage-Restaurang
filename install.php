
<?php

include("config.php");

//connect to to database
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if ($db->connect_errno > 0) {
    die('fel vid anslutning till databas:' . $db->connect_errno);
}

$sql = "DROP TABLE IF EXISTS menu,booking,users;";

$sql .= "CREATE TABLE menu(
     
       nameMenu varchar(200),
        price int(200),
        description text(300),
        category varchar(128),       
        id int(11) PRIMARY KEY AUTO_INCREMENT
);
";

$sql .= "CREATE TABLE booking(
    booking_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    guest_name varchar(200),
    guests int(11), 
    date varchar(100),
    time varchar(100),
    email varchar(200)    
);
";

$sql .= "CREATE TABLE users(
    user_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username varchar(200),
    password varchar(200)    
);
";

//send the sql question to the server
if ($db->multi_query($sql)) {
    echo "tabell installerad";
} else {
    echo "fel vid installation av tabell";
}

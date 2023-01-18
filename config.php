

<?php

//include course.class.php
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php';
});

$devmode = false;

if ($devmode) {
    error_reporting(-1);
    ini_set("display_errors", 1);

    define("DBHOST", "localhost");
    define("DBUSER", "resturant");
    define("DBPASS", "password");
    define("DBDATABASE", "resturant");
} else {
    error_reporting(-1);
    ini_set("display_errors", 1);
    //DB-settings
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "joka2113");
    define("DBPASS", "hALwhqPqfw");
    define("DBDATABASE", "joka2113");
}

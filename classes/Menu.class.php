<?php
//Class
class Menu
{
    //Members - Properties
    private $db;
    private $id;
    private $nameMenu;
    private $description;
    private $category;
    private $price;

    function __construct()
    { //connect to database
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die('Fel vid anslutning [' . $this->db->connect_error . ']');
        }
    }

    function getMenu()
    {
        $sql = "SELECT * FROM menu;";
        //$result = mysqli_query($this->db, $sql);
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getMenuById(int $id): array
    {
        $id = intval($id);
        //sql query
        $sql = "SELECT * FROM menu WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

    public function setMenu(string $nameMenu, int $price, string $description, string $category): bool
    {
        if ($nameMenu and $price and $description and $category != "") {
            $this->nameMenu = $nameMenu;
            $this->price = $price;
            $this->description = $description;
            $this->category = $category;

            $nameMenu = $this->db->real_escape_string($nameMenu);
            $price = $this->db->real_escape_string($price);
            $description = $this->db->real_escape_string($description);
            $category = $this->db->real_escape_string($category);
            $price = strip_tags($price);
            $description = strip_tags($description);
            $nameMenu = strip_tags($nameMenu);
            $category = strip_tags($category);


            return true;
        } else {
            return false;
        }
    }

    public function setMenuId(string $nameMenu, int $price, string $description, string $category, $id): bool
    {
    
        if ($nameMenu and $price and $description and $category != "") {
            $this->nameMenu = $nameMenu;
            $this->price = $price;
            $this->description = $description;
            $this->category = $category;
            $this->id = $id;
            return true;
        } else {
            return false;
        }
    }


    //add new menu
    public function createMenu(string $nameMenu, int $price, string $description, string $category): bool
    {
        //sanitate the inputs
        $price = strip_tags($price);
        $description = strip_tags($description);
        $nameMenu = strip_tags($nameMenu);
        $category = strip_tags($category);
      
        $nameMenu = $this->db->real_escape_string($nameMenu);
        $price = $this->db->real_escape_string($price);
        $description = $this->db->real_escape_string($description);
        $category = $this->db->real_escape_string($category);



        $sql = "INSERT INTO menu(nameMenu, price, description, category )VALUES('" . $nameMenu . "','" . $price . "','" . $description . "','" . $category . "');";
        //send query
        return mysqli_query($this->db, $sql);
    }
    public function updateMenu()
    {
                  
        //sql query
        $sql = "UPDATE menu SET nameMenu='" . $this->nameMenu . "', price='" . $this->price . "', description='" . $this->description . "', category='" . $this->category . "', id='" . $this->id . "' WHERE id=$this->id;";
        //send query
        return mysqli_query($this->db, $sql);
    }

    //delete menu where id=id
    public function deleteMenu($id): bool
    {
        $id = intval($id);
        $sql = "DELETE FROM menu WHERE id=$id;";
        return mysqli_query($this->db, $sql);
    }

    function __destruct()
    {
        mysqli_close($this->db);
    }
}

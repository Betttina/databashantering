<?php
//require_once "database.php";
//require_once "./credentials/model.php";
require_once "media.php";

class Products extends BaseModel {
    public $id = null;
    public $name = null;
    public $price = null;
    public $saleable = null;
    public $media = null;

    public function __construct($id, $name, $price, $saleable, $media)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->saleable = $saleable;
        $this->media = $media;
        parent::__construct();

    }

    function getId(){
        return $this->id;
    }

    function getName(){
        return $this->name;
    }

    function getPrice(){
        return $this->price;
    }

    function getSaleable(){
        return $this->saleable;
    }

    function getMedia(){
        return $this->media;
    }

    //set values

    function setId($value){
        $this->id = $value;
    }

    // Ställer inte in namnet om det givna värdet är tomt
    function setName($value){
        //sant eller falskt med empty, kollar om det är tomt värde.
        if(empty($value) == false){
        $this->name = $value;
        }
    }

    // Ställer inte in priset om det givna värdet är negativt
    function setPrice($value){
        // sätter inga negativa värden.
        if($value > 0){
        $this->price = $value;
        }
    }

    function setSaleable($value){
        $this ->saleable = $value;
    }

    function setMedia($value){
        $this->media = $value;
    }

    // skriver ut allt om produkter
//    public function print(){
//        echo "<br><br>Produkt: <br>" . "id : " . $this->id . " name: " . $this->name . " price: " . $this->price . "  saleable: " . $this->saleable . " <br>Image: " . $this->media;
//    }




}

// hämta produkter baserat på säljbarhet med media-path
function getProduct($connection){
    //produkter lagras i en array
    $products = array();

    // läs produkt från tabellen
    $query_prod = "SELECT products.*, media.media_name AS media_name
        FROM products
        LEFT JOIN media ON products.media_id = media.media_id
        WHERE products.saleable = 1";


    // skickar mot databas och lagras res i variabel
    $result = $connection->query($query_prod);
    
    // loopa genom resultaten
    while ($row = $result->fetch_assoc()) {
        $id = $row["product_id"];
        $name = $row["product_name"];
        $price = $row["price"];
        $saleable = $row["saleable"];
        $media = $row["media_id"];

        // skapa en ny produkt och lägg till den i arrayen
        $product = new Products($id, $name, $price, $saleable, $media);
        $products[] = $product;
    }
    
    return $products;
    

}

function getProductById($connection, $product_id) {
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row["product_id"];
        $name = $row["product_name"];
        $price = $row["price"];
        $saleable = $row["saleable"];
        $media = $row["media_id"];

        // skapar en ny produkt
        $product = new Products($id, $name, $price, $saleable, $media);
        return $product;
    } else {
        // ingen produkt hittades med angivna id
        return null;
    }
}





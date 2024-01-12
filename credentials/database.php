<?php

require_once "credentials.php";


// skapar instans av connection
$connection = new mysqli(databasehost, usernamehost, passwordhost, databasename, port);

// kontrollera om anslutningen lyckades
if ($connection->connect_error != null) {
    die("Anslutningen misslyckades: " . $connection->connect_error);
}

// Skapa databasen om den inte finns
// $createDatabaseSQL = "CREATE DATABASE IF NOT EXISTS database2";
// if ($connection->query($createDatabaseSQL) === TRUE) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . $connection->error;
// }
function getDatabaseConnection() {
    global $connection;
    return $connection;
}

$connection->set_charset("utf8");




// skapa tabell till produkter
$query_products = "CREATE TABLE IF NOT EXISTS products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(25),
    price INT,
    saleable BOOLEAN,
    stock INT,
    media_id INT
    );";

// skapa tabell till ordrar
$query_orders = "CREATE TABLE IF NOT EXISTS  orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    status VARCHAR(25),
    total FLOAT,
    created DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
    );";
    
// skapa tabell för ordervaror
$query_order_items = "CREATE TABLE IF NOT EXISTS order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT,
    subtotal INT,
    created DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
    );";
    
// skapa tabell för kunder    
$query_customers = "CREATE TABLE IF NOT EXISTS customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_firstname VARCHAR(50),
    customer_surname VARCHAR(50),
    customer_ssn VARCHAR(11) UNIQUE,
    customer_phone VARCHAR(10),
    customer_email VARCHAR(100) UNIQUE,
    customer_address VARCHAR(50),
    customer_city VARCHAR(50),
    customer_zip VARCHAR(5),
    created DATE DEFAULT (CURRENT_DATE)
    );";

// skapa tabell till media
$query_media = "CREATE TABLE IF NOT EXISTS media (
    media_id INT PRIMARY KEY AUTO_INCREMENT,
    media_name VARCHAR(50),
    product_id INT,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
    );";
    
    
    
    $result = $connection->query($query_media);

    if ($result === false) {
        die("Frågan misslyckades: " . $connection->error);
    }
      

//$connection->close();

?>
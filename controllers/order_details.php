<!-- order_details.php -->

<?php
require_once __DIR__ . '/../models/model.php';

require_once "customer_functions.php"; 
require_once "order_functions.php";
require_once __DIR__ . '/../models/media.php';

$connection = getDatabaseConnection();
// get order_items info + media 
function getOrderDetailsWithImages($connection, $order_id) {

    $sql = "SELECT o.*, c.customer_firstname, c.customer_surname, oi.quantity, oi.subtotal, p.product_name, p.price, m.media_name
    FROM orders o
    INNER JOIN customers c ON o.customer_id = c.customer_id
    INNER JOIN order_items oi ON o.order_id = oi.order_id
    INNER JOIN products p ON oi.product_id = p.product_id
    LEFT JOIN media m ON p.media_id = m.media_id
    WHERE o.order_id = $order_id";




    $stmt = $connection->prepare($sql);
    //$stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    var_dump($result);
    
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);

    } else {
        echo "Error: " . $stmt->error;
        return false; // no matching orders
    }
}
function getOrderDetails($connection, $order_id) {

    $sql = "SELECT o.*, c.customer_firstname, c.customer_surname, oi.quantity, oi.subtotal, p.product_name, p.price, m.media_name
    FROM orders o
    INNER JOIN customers c ON o.customer_id = c.customer_id
    INNER JOIN order_items oi ON o.order_id = oi.order_id
    INNER JOIN products p ON oi.product_id = p.product_id
    LEFT JOIN media m ON p.media_id = m.media_id
    WHERE o.order_id = $order_id";
    $stmt = $connection->prepare($sql);
    //$stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    //var_dump($result);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);

    } else {
        echo "Error: " . $stmt->error;
        return false; // no matching orders
    }
}

?>
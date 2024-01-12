<?php
// order_functions.php 

require_once __DIR__ . '/../models/model.php';

require_once __DIR__ . '/../models/orders.php';


// behandla ordern = behandla datan.
// add data to tables: orders and order_items.

$connection = getDatabaseConnection();


// ADD ORDER
function addOrder($connection, $customer_id, $status, $total) {
    
    $stmt = $connection->prepare("INSERT INTO orders (customer_id, status, total) VALUES (?, ?, ?)");
    
    $stmt->bind_param("iss", $customer_id, $status, $total);
    
    if ($stmt->execute()) {
        return $connection->insert_id; // return new order-id
    } else {
        return false; // error during adding an order
    }
}

// add order_item to order_items
function addOrderItem($connection, $order_id, $product_id, $quantity, $subtotal) {

    $stmt = $connection->prepare("INSERT INTO order_items (order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
    
    $stmt->bind_param("iiii", $order_id, $product_id, $quantity, $subtotal);
    
    if ($stmt->execute()) {
        return true; // order_item addd succesfully
    } else {
        return false; // order_item adding: error!
    }
}



// get price for product
function getProductPrice($connection, $productId) {
    $sql = "SELECT price FROM products WHERE product_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['price']; // return price för respektive product
    } else {
        return false; // Could not find proudct.
    }
}


// new created order => set status to value = processed.
function updateOrderStatus($connection, $newOrderId) {
    if (isset($newOrderId)) {
        $status = "processing";
        
        // Binder status till (1:a) frågetecknet (för säker införing) 
        $updateStatusQuery = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt = $connection->prepare($updateStatusQuery);
        $stmt->bind_param("si", $status, $newOrderId);
    
        if ($stmt->execute()) {
            // order-status set to "processed" succesfully
            echo "<p>Your order is now processed.</p>";
        } else {
            return false;
            // Could not update the status of the order
        }
    }
}




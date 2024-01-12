<?php
require_once "./../../models/model.php";
require_once "./../../models/orders.php";

$connection = getDatabaseConnection();


try {
    if (isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];

        if (deleteOrder($connection, $order_id)) {
            echo "<h1> 📦 Order with order id: $order_id removed successfully! 🧹🗑️</h1>";
            echo " <h2> Return to: <a href='admin_view.php'>Admin view ↩️</a></h2>";
        } else {
            echo "<h1> 🚨 Error during removal of order: $order_id</h1>";
        }
    } else {
        echo "<p>No order_id provided</p>";
    }
} catch (Exception $e) {
    $errorMessage = "An error occurred: " . $e->getMessage();
    error_log($errorMessage, 0);
    echo "<h1> 🚨 $errorMessage</h1>";
}






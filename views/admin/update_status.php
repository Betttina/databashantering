<?php

require_once __DIR__ . '/../../models/model.php';
require_once "../../models/orders.php";
$connection = getDatabaseConnection();

function updateOrdersStatus ($connection, $order_id, $new_status){
    try {
        $query = "UPDATE orders SET status = ? WHERE order_id = ?";

        // prepare statement
        $statement = $connection->prepare($query);

        if (!$statement) {
            throw new Exception("Couldn't prepare sql-query for updating order status..🚨 ");
        }

        $statement->bind_param("si", $new_status, $order_id);
        if ($statement->execute()) {
            $statement->close();
            return true;
        }else{
            throw new Exception("Error: Couldn't update order-status.. 🚨" . $statement->error);
        }
    } catch (Exception $e) {
        return false; }
}

// check if order-update-status form is sended
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // get order_id from post-data
    $order_id = $_POST['order_id'];

    // get new status from post-data
    $new_status = $_POST['new_status'];

    // update status in db
    if (updateOrdersStatus($connection, $order_id, $new_status)) {
        // status changed successfully!
        echo "<h1>status changed successfully to: " . "$new_status" . "! 📋📝✅</h1>";
        echo " <h2> Return to: " . '<a href="admin_view.php">Admin view</a>' . "</h2>";
        $connection->close();

    } else {
        // error during updating order-status.
        echo "❌ error during updating order-status. ❌ ";
    }
} else {
    // ifall formuläret inte har skickats, user omdirigeras tillbaka till adminsidan
    header("Location: admin_view.php");
    exit();
}

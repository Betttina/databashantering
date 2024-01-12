  <?php
    require_once __DIR__ . '/../../models/model.php';
    require_once __DIR__ . '/../../controllers/order_details.php';
    require_once __DIR__ . '/../../models/media.php';

    $connection = getDatabaseConnection();
    $order_id = $_GET['order_id'];

    $orderDetails = getOrderDetails($connection, $order_id);
    ?>
<!-- order_confirmation.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../assets/css/confirm.css">
    <title>Order Confirmation</title>
</head>
<body>

<div class="confirm">
    <?php

    // ------ order confirmation --------
    if ($orderDetails) {
        echo '<h2>🎉 Your purchase was successful! 🎉 Thank you for your order ' . $orderDetails[0]['customer_firstname'] . "!</h2>" ;
        echo '<h1> Order confirmation</h1>';

        // display current customer info
        echo '<h3>Customer Information</h3>';
        if (isset($orderDetails[0]['customer_firstname']) && isset($orderDetails[0]['customer_surname'])) {
            echo '<p>Customer Name: ' . $orderDetails[0]['customer_firstname'] . ' ' . $orderDetails[0]['customer_surname'] . ' 📦 '. 'Order ID: ' . $orderDetails[0]['order_id'] .'</p>'  ;
        }


        // display order details
        echo '<h3>Order Details</h3>';
        echo '<table>';
        echo '<thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Image</th></tr></thead>';
        echo '<tbody>';

        foreach ($orderDetails as $orderItem) {
            echo '<tr>';
            if (isset($orderItem['product_name'])) {
                echo '<td>' . $orderItem['product_name'] . '</td>';
            } else {
                echo '<td>N/A</td>';
            }

            if (isset($orderItem['price'])) {
                echo '<td>' . $orderItem['price'] . '</td>';
            } else {
                echo '<td>N/A</td>';
            }
            if (isset($orderItem['quantity'])) {
                echo '<td>' . $orderItem['quantity'] . '</td>';
            } else {
                echo '<td>N/A</td>';
            }
            if (isset($orderItem['subtotal'])) {
                echo '<td>' . $orderItem['subtotal'] . '</td>';
            } else {
                echo '<td>N/A</td>';
            }
            if (isset($orderItem['media_name'])) {
                echo '<td><img src="' . $orderItem['media_name'] . '" alt="Product Image" width="100"></td>';
            } else {
                echo '<td>No Image</td>';
            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        // error message
        echo '<h2>🚨 Your order is empty! Please add items to your order before confirming. 🚨</h2>';
    }
    ?>

    <a href="store_view.php" class="btn btn-primary">Back to Store</a>

</div>


</body>
</html>


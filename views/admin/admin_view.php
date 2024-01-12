<!-- admin.php -->

<?php
require_once __DIR__ . '/../../models/model.php';
require_once __DIR__ . '/../../models/media.php';
require_once __DIR__ . '/../../models/products.php';
require_once __DIR__ . '/../../models/order_items.php';
require_once __DIR__ . '/../../models/orders.php';
require_once __DIR__ . '/../../controllers/order_details.php';

$connection = getDatabaseConnection();
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin view</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

</head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    h1 {
        text-align: center;
    }
</style>
<body>


<?php
try {
    $sql = "SELECT
        customers.customer_id,
        customers.customer_firstname,
        customers.customer_surname,
        customers.created AS customer_created,
        orders.order_id,
        GROUP_CONCAT(DISTINCT orders.created ORDER BY orders.created DESC) AS order_dates,
        GROUP_CONCAT(orders.status ORDER BY orders.created DESC) AS order_statuses,
        GROUP_CONCAT(order_items.product_id ORDER BY orders.created DESC) AS product_ids,
        GROUP_CONCAT(products.product_name ORDER BY orders.created DESC) AS product_names,
        GROUP_CONCAT(order_items.quantity ORDER BY orders.created DESC) AS quantities
    FROM
        customers
    INNER JOIN orders ON customers.customer_id = orders.customer_id
    INNER JOIN order_items ON orders.order_id = order_items.order_id
    INNER JOIN products ON order_items.product_id = products.product_id
    GROUP BY
        customers.customer_id, customers.customer_firstname, customers.customer_surname, customers.created, orders.order_id
    ORDER BY
        customers.customer_id DESC, orders.order_id DESC;";

    // kör sql-query mot databasen
    $result = $connection->query($sql);

    // om det är sant så är operationen lyckad, om falskt skickas ett felmeddelande.
    if (!$result) {
        throw new Exception("Frågan misslyckades: " . $connection->error);
    }

    // kontroll om det returneras poster från sql-queryn som exekverats
    // om det returneras minst en rad, alltså i $result, så är villkoret sant och koden körs.
    if ($result->num_rows > 0) {
        echo '<h1>Admin page 👨🏻‍💻📋🛠️</h1>';
        echo '<table>';

        echo '<thead>';
        echo '<tr>';
        /*echo '<th>Customer ID</th>';
        echo '<th>Customer name</th>';
        echo '<th>Customer created</th>';*/
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // while = kör så länge som det finns poster att hämta
        // komma åt varje separat rad i dessa kolumner (nyckel) och värde (data)
        // lagra dessa i en assoc array ($row)
        // explode för att dela upp string och separera med komma tecken
        while ($row = $result->fetch_assoc()) {
            $orderDates = explode(',', $row['order_dates']);
            $orderStatuses = explode(',', $row['order_statuses']);
            $productIds = explode(',', $row['product_ids']);
            $productNames = explode(',', $row['product_names']);
            $quantities = explode(',', $row['quantities']);

            // table-head för kundinfo
            echo '<thead>';
            echo '<tr>';
            echo '<th colspan="5" class="customerinfo">Customer info</th>';
            echo '</tr>';
            echo '</thead>';

            // skapar assoc array för kundinfo
            $customerInfo = array(
                "Customer ID" => $row['customer_id'],
                "Customer name" => $row['customer_firstname'] . ' ' . $row['customer_surname'],
                "Customer created" => $row['customer_created']
            );

            // Loopa genom och visa kundinfo (table row och table data(cell))
            foreach ($customerInfo as $field_title => $field_value) {
                echo '<tr>';
                echo '<td>', $field_title, '</td>';
                echo '<td>', $field_value, '</td>';
                echo '</tr>';
            }

            // visa orderinfo-rubriker som ett table-head
            echo '<thead>';
            echo '<tr>';
            echo '<th>Order ID</th>';
            echo '<th>Order created</th>';
            echo '<th>Status</th>';
            echo '<th>Uppdatera status</th>';
            echo '<th>Åtgärder</th>';
            echo '</tr>';
            echo '</thead>';

            // for-loop genom orderinfo
            // kör lika många gånger som antalet rader lagrat i order-datum-variabeln
            //
            for ($i = 0; $i < count($orderDates); $i++) {
                // ny tabellrad för varje iteration av loopen
                echo '<tr>';
                // om det är den första iterationen så skrivs orderID, order-skapad och status. annars inte.
                // (detta för att endast skriva ut det en gång)
                if ($i === 0) {
                    // Visa order-id, status och datum bara för första raden i samma order
                    echo '<td rowspan="' . count($orderDates) . '">' . $row['order_id'] . '</td>';
                    echo '<td>' . $orderDates[$i] . '</td>';
                    echo '<td>' . $orderStatuses[$i] . '</td>';
                }

                // Visa knapp för att uppdatera status och länk för att ta bort
                echo '<td>';
                echo '<form action="update_status.php" method="post">';
                echo '<input type="hidden" name="order_id" value="' . $row['order_id'] . '">';
                echo '<select name="new_status">';
                echo '<option value="">Update status to:</option>';
                echo '<option value="processing">Processing</option>';
                echo '<option value="shipped">Shipped</option>';
                echo '<option value="completed">Completed</option>';
                echo '<option value="cancelled">Cancelled</option>';
                echo '</select>';
                echo '<input type="submit" value="Uppdatera status">';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<a href="delete_order.php?order_id=' . $row['order_id'] . '">Ta bort order</a>';
                echo '</td>';
                echo '</tr>';
            }

            // visa ordervaror som table-head
            echo '<thead>';
            echo '<tr>';
            echo '<th>Order items</th>';
            echo '<th>Order_item ID</th>';
            echo '<th>Product ID</th>';
            echo '<th>Product name</th>';
            echo '<th>Quantity</th>';
            echo '</tr>';
            echo '</thead>';

            // Loopa genom ordervaror och visa dem i table-cells
            for ($j = 0; $j < count($productIds); $j++) {
                echo '<tr>';
                echo '<td>Order items</td>';
                echo '<td>' . $productIds[$j] . '</td>';
                echo '<td>' . $productIds[$j] . '</td>';
                echo '<td>' . $productNames[$j] . '</td>';
                echo '<td>' . $quantities[$j] . '</td>';
                echo '</tr>';
            }
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'Inga ordrar hittades.';
    }

} catch (Exception $e) {
    echo "Fel: " . $e->getMessage();
}
?>




</body>
</html>

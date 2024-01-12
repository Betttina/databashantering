<?php
require_once __DIR__ . '/../models/model.php'; // db anslutning
require_once "customer_functions.php"; // kund
require_once "order_functions.php"; // order
require_once "../models/customers.php";
require_once "../models/products.php"; 

$connection = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get values från orderformulär
    $firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
    $surname = isset($_POST["surname"]) ? $_POST["surname"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
    $ssn = isset($_POST["ssn"]) ? $_POST["ssn"] : "";
    $address = isset($_POST["address"]) ? $_POST["address"] : "";
    $city = isset($_POST["city"]) ? $_POST["city"] : "";
    $zip = isset($_POST["zip"]) ? $_POST["zip"] : "";
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";
    $status = "processing";
    $created = date('Y-m-d');
    $total = isset($_POST["total"]) ? $_POST["total"] : 0;

    // validera formulär-data
    $errorMessages = validateFormData($_POST);

    if (!empty($errorMessages)) {
        displayErrorMessages($errorMessages);
    } else {
        $customer_id = addCustomerOrGetExisting($connection, $firstname, $surname, $ssn, $phone, $email, $address, $city, $zip);

        if ($customer_id === false) {
            echo "Error during adding customer.";
        } else {
            $newOrderId = addOrder($connection, $customer_id, "processing", $_POST["total"]);
            if ($newOrderId === false) {
                echo "Error: Could not add the order.";
            } else {
                addOrderItems($connection, $newOrderId, $_POST["products"], $_POST["quantity"]);

                updateOrderStatus($connection, $newOrderId);

                header("Location: ../views/store/order_confirmation_2.php?order_id=" . $newOrderId);
            }
        }
    }
}

function validateFormData($formData) {
    $errorMessages = [];

    // lista för obligatoriska fält
    $mandatoryFields = ["firstname", "surname", "email", "phone", "ssn", "address", "city", "zip"];

    // loopa genom och kolla om fälten är tomma
    foreach ($mandatoryFields as $field) {
        if (empty($formData[$field])) {
            // felmeddelande för de som är tomma
            $errorMessages[] = ucfirst($field) . " is mandatory and cannot be empty.";
        }
    }

    if (empty($formData["email"]) || !filter_var($formData["email"], FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = "Invalid email address. Format: example@email.com ";
    }

    if (!preg_match("/^\d{10}$/", $formData["phone"])) {
        $errorMessages[] = "Invalid phone number. Example: 0712345678";
    }

    if (!preg_match("/^\d{10}$/", $formData["ssn"])) {
        $errorMessages[] = "Invalid SSN. Put in format: YYMMDDXXXX.";
    }

    return $errorMessages;
}


function displayErrorMessages($errorMessages) {
    foreach ($errorMessages as $errorMessage) {
        echo "<p>$errorMessage</p>";
    }
}

function addOrderItems($connection, $orderId, $productIds, $quantities) {
    foreach ($productIds as $key => $product_id) {
        $quantity = $quantities[$key];
        $product = getProductById($connection, $product_id);

        if ($quantity > 0) {
            $product_price = $product->getPrice();

            if ($product_price !== false) {
                $subtotal = $product_price * $quantity;

                if (!addOrderItem($connection, $orderId, $product_id, $quantity, $subtotal)) {
                    echo "Error: Could not add order item.";
                    break;
                }
            } else {
                echo "Fel: Produktinformation kunde inte hämtas.";
                break;
            }
        }
    }
}


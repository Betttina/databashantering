<!-- customer_functions.php -->

<?php
require_once __DIR__ . '/../models/model.php';

require_once __DIR__ . '/../models/customers.php';

$connection = getDatabaseConnection();
// kontrollera om kunden finns sen tidigare
// om kunden finns returneras $customer_id
// misslyckad sökning: returnerar false om customer inte finns (för att senare kunna lägga till kunden)

// Check if customer exist, based on e-mail.
// Insert - Add new customer if not existing
// Insert data into table: customers.


// add customer
function addCustomer($connection, $firstname, $surname, $ssn, $phone, $email, $address, $city, $zip) {
    
    $stmt = $connection->prepare("INSERT INTO customers (customer_firstname, customer_surname, customer_ssn, customer_phone, customer_email, customer_address, customer_city, customer_zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssss", $firstname, $surname, $ssn, $phone, $email, $address, $city, $zip);
    
    if ($stmt->execute()) {
        return true; // successfully added customer
    } else {
        return false; // could not add customer
    }
}

// email is unique
function addCustomerOrGetExisting($connection, $firstname, $surname, $ssn, $phone, $email, $address, $city, $zip) {
    
    // check if customer exist
    $existingCustomerQuery = $connection->prepare("SELECT customer_id FROM customers WHERE customer_email = ?");
    $existingCustomerQuery->bind_param("s", $email);
    $existingCustomerQuery->execute();
    $result = $existingCustomerQuery->get_result();

    if ($result->num_rows > 0) {
        // if custmumer exist get customer_id
        $row = $result->fetch_assoc();
        return $row['customer_id'];
    } else {
        // no customer from before? add customer ;)
        $insertCustomerStmt = $connection->prepare("INSERT INTO customers (customer_firstname, customer_surname, customer_ssn, customer_phone, customer_email, customer_address, customer_city, customer_zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insertCustomerStmt->bind_param("ssssssss", $firstname, $surname, $ssn, $phone, $email, $address, $city, $zip);
        
        if ($insertCustomerStmt->execute()) {
            // return customer_id for newCustomer
            return $insertCustomerStmt->insert_id;
        } else {
            return false; // could not add customer :(
        }
    }
}

?>
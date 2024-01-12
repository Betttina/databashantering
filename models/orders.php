<!-- getOrder (){
    // hämta order med id från databasen samtidigt som en JOIN görs med order_items-tabellen.

    // skapa en ny instans orderklassen med order_idt
    // lägg till samtliga order_items lästa till instansen av order-klassen 
} -->

<?php

require_once('model.php');

class Order extends BaseModel
{

    protected $customer_id;
    protected $order_id;
    protected $total;
    protected $created;


    function __construct($customer_id, $order_id, $total, $created)
    {
        $this->customer_id = $customer_id;
        $this->order_id = $order_id;
        $this->total = $total;
        $this->created = $created;
        parent::__construct();
    }

    public function getCustomerId()
    {

//    $data = array();
//    $data['order_id'] = $this->orders;
//
        return $this->customer_id;
    }

// metoder för att sätta och hämta värden för de olika egenskaperna för Order

// set and get customer_id
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    public function getCustomer()
    {
        return $this->customer_id;
    }

// set and get order_id
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

// set and get created
    public function setCreated($created)
    {
        $this->order_id = $created;
    }

    public function getCreated()
    {
        return $this->created;
    }

// set and get total
    public function setTotal($total)
    {
        $this->order_id = $total;
    }

    public function getTotal()
    {
        return $this->total;
    }

// Printa ut
//function print(){
//    echo "<br>En order:<br>" . "CustomerID: " . $this->customer_id . " OrderID: " . $this->order_id . " Total: " . $this->total . " Created: " . $this->created;
//}

// Spara i databasen.
    function save()
    {
        $connection = parent::getConnection();
        $query = "UPDATE orders SET total = ?, customer_id = ? WHERE order_id = ? ";
        $statement = $connection->prepare($query);

        $statement->bind_param("dii", $this->total, $this->customer_id, $this->order_id); // Använd "d" för decimal (total).
        $result = $statement->execute();

        // Kör frågan

        if ($result) {
            // Kontrollerar om minst en rad har uppdaterats
            $affectedRows = $statement->affected_rows > 0;
            echo "såhär många rader: " . $affectedRows;
            return $affectedRows > 0;
        } else {
            // Om något gick fel, skriv ut felmeddelandet
            echo "Fel: " . $statement->error;
            return false;
        }
    }


    // få alla ordrar baserat på datum
    function getOrdersByDate($connection, $date) {
        $query = "SELECT * FROM orders WHERE created = ?";
        $statement = $connection->prepare($query);
        $statement->bind_param("s", $date);
        $statement->execute();
        $result = $statement->get_result();

        $orders = array();
        while ($row = $result->fetch_assoc()) {
            $customer_id = $row["customer_id"];
            $order_id = $row["order_id"];
            $total = $row["total"];
            $created = $row["created"];

            $order = new Order($customer_id, $order_id, $total, $created);
            $orders[] = $order;
        }
        $statement->close();
        return $orders;
    }

    // få alla ordrar baserat på kundens id.
    public static function getOrdersByCustomerId($connection, $customer_id)
    {
        $query = "SELECT * FROM orders WHERE customer_id = ?";
        $statement = $connection->prepare($query);
        $statement->bind_param("i", $customer_id);
        $statement->execute();
        $result = $statement->get_result();

        $orders = array();
        while ($row = $result->fetch_assoc()) {

            $customer_id = $row["customer_id"];
            $order_id = $row["order_id"];
            $total = $row["total"];
            $created = $row["created"];

            $order = new Order($order_id, $total, $created, $customer_id);

            // blir ett nytt orderobjekt varje gång det loopas igenom
            $orders[] = $order;
        }
        $statement->close();
        return $orders;
    }

    function updateOrdersStatus ($connection, $order_id, $new_status){
        try {
        $query = "UPDATE orders SET status = ? WHERE order_id = ?";

        // prepare statement
        $statement = $connection->prepare($query);

        if (!$statement) {
            throw new Exception("Couldn't prepare sql-query for updating order status..🚨 ");
        }

        $statement->bind_param("si", $order_id, $new_status);
        if ($statement->execute()) {
            $statement->close();
            return true;
        }else{
            throw new Exception("Error: Couldn't update order-status.. 🚨" . $statement->error);
        }
    } catch (Exception $e) {
        return false; }
    }




}

function deleteOrder($connection, $order_id) {
    try {
        // skapar en transaktion för att hantera båda borttagningarna
        $connection->begin_transaction();

        // tar bort relaterade ordervaror till ordern
        $deleteOrderItemsQuery = "DELETE FROM order_items WHERE order_id = ?";
        $deleteOrderItemsStatement = $connection->prepare($deleteOrderItemsQuery);
        $deleteOrderItemsStatement->bind_param("i", $order_id);

        if (!$deleteOrderItemsStatement->execute()) {
            throw new Exception("Error deleting order items: " . $deleteOrderItemsStatement->error);
        }

        // delete order
        $deleteOrderQuery = "DELETE FROM orders WHERE order_id = ?";
        $deleteOrderStatement = $connection->prepare($deleteOrderQuery);
        $deleteOrderStatement->bind_param("i", $order_id);

        if (!$deleteOrderStatement->execute()) {
            throw new Exception("Error deleting order: " . $deleteOrderStatement->error);
        }

        // om båda lyckas: commit transaktion
        $connection->commit();

        return true;
    } catch (Exception $e) {
        // om det uppstår fel -> rollback
        $connection->rollback();
        error_log("An error occurred: " . $e->getMessage(), 0);
        return false;
    }
}







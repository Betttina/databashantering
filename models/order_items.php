<?php
//require_once "../credentials/model.php";

class OrderItem extends BaseModel {

    protected $items_id;
    protected $order_id;
    protected $product_id;
    protected $quantity;
    protected $subtotal;
    protected $created;
    

    function __construct($items_id, $order_id, $product_id, $quantity, $subtotal, $created)
    {
        $this->items_id = $items_id;
        $this->product_id = $product_id;
        $this->subtotal = $subtotal;
        $this->order_id = $order_id;
        $this->quantity = $quantity;
        $this->created = $created;
        parent::__construct();
    }

    public function setId($items_id){
        $this->items_id = $items_id;
    }
    
    public function getId(){
        return $this->items_id;
    }
    
    public function setOrderId($order_id){
        $this->order_id = $order_id;
    }
    
    public function getOrderId(){
        return $this->order_id;
    }
    
    public function setProductId($product_id){
        $this->subtotal = $product_id;
    }
    
    public function getProductId(){
        return $this->product_id;
    }
    
    public function setTotal($subtotal){
        $this->order_id = $subtotal;
    }
    
    public function getTotal(){
        return $this->subtotal;
    }
    
//    function print(){
//        echo "Order item id: " . $this->items_id . " ProduktID: " . $this->product_id . " total: " . $this->subtotal . " OrderID:" . $this->order_id;
//    }


// hämta ordervaror baserat på order_id
    function getOrderItemsByOrderId($connection, $order_id)
    {
        $query = "SELECT * FROM order_item WHERE order_id = '". $order_id . "'";
        $statement = $connection->query($query);

        $order_items = array();
        while($result = $statement->fetch_assoc()){

            $items_id = $result['order_item_id'];
            $product_id = $result['product_id'];
            $subtotal = $result['subtotal'];
            $quantity = $result['quantity'];
            $created = $result['created'];


            $order_item = new OrderItem($items_id, $order_id, $product_id, $quantity, $subtotal, $created);
            $order_items[] = $order_item;
        }
        return $order_items;
    }

}


<?php


//namespace slutprojekt\models;


class Customers extends BaseModel {

    protected $customer_id;
    protected $customer_firstname;
    protected $customer_surname;
    protected $customer_phone;
    protected $customer_email;
    protected $ssn;
    protected $address;
    protected $city;
    protected $zip;
    protected $created;

    function __construct($customer_id, $customer_firstname, $customer_surname, $customer_phone, $customer_email, $ssn, $address, $city, $zip, $created)
    {
        // tilldela värdet av variabler till egenskaper ($customer_id är en parameter)
        $this->customer_id = $customer_id;
        $this->customer_firstname = $customer_firstname;
        $this->customer_surname = $customer_surname;
        $this->customer_phone = $customer_phone;
        $this->customer_email = $customer_email;
        $this->ssn = $ssn;
        $this->address = $address;
        $this->city = $city;
        $this->zip = $zip;
        $this->created = $created;
        parent::__construct();

        //$this->print();

    }

// ---SET FUNCTIONS----
    function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    function setCustomerName($customer_firstname)
    {
        $this->customer_firstname = $customer_firstname;
    }

    function setCustomerPhone($customer_phone)
    {
        $this->customer_phone = $customer_phone;
    }

    function setCustomerEmail($customer_email)
    {
        $this->customer_email = $customer_email;
    }

    function setSsn($ssn)
    {
        $this->ssn = $ssn;
    }

    function setAddress($address)
    {
        $this->address = $address;
    }

    function setCity($city)
    {
        $this->city = $city;
    }

    function setZip($zip)
    {
        $this->zip = $zip;
    }

    function setCreated($created)
    {
        $this->created = $created;
    }


// --------- GET FUNCTIONS ----------
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function getCustomerFirstname()
    {
        return $this->customer_firstname;
    }

    public function getCustomerSurname()
    {
        return $this->customer_surname;
    }

    public function getCustomerPhone()
    {
        return $this->customer_phone;
    }

    public function getCustomerEmail()
    {
        return $this->customer_email;
    }

    public function getSsn()
    {
        return $this->ssn;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function getCreated()
    {
        return $this->created;
    }



//public function print(){
//    //var_dump($this->customer_email);
//    echo "<br>Kund-ID: " . $this->customer_id . ", Kundnamn: " . $this->customer_firstname . ", Telefon nr: " . $this->customer_phone . ", E-post: " . $this->customer_email . ", Skapad: " . $this->created;
//}


// hämta kunden
    function getCustomer($connection, $customer_email)
    {
        $query = "SELECT * FROM customers WHERE customer_email = '" . $customer_email . "'";
        $statement = $connection->query($query);
        $result = $statement->fetch_assoc();

        if ($result != null) {

            $customer_id = $result["customer_id"];
            $customer_firstname = $result["customer_firstname"];
            $customer_surname = $result["customer_surname"];
            $customer_phone = $result["customer_phone"];
            $customer_email = $result["customer_email"];
            $ssn = $result["ssn"];
            $address = $result["customer_address"];
            $city = $result["customer_city"];
            $zip = $result["customer_zip"];

            //$customer_email = $result["customer_email"];
            $created = $result["created"];


            $customer = new Customers ($customer_id, $customer_firstname, $customer_surname,
                $customer_phone, $customer_email, $ssn, $address, $city, $zip, $created);
            return $customer;
        } else {
            echo "Kunden hittades inte!";
            return null;
        }
    }


    // Hämta kundinformation baserat på customer_id
    public static function getCustomerByCustomerId($connection) {
        $query = "SELECT * FROM customers";
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // instans av customers-klassen
            return new Customers(
                $row["customer_id"],
                $row["customer_firstname"],
                $row["customer_surname"],
                $row["customer_phone"],
                $row["customer_email"],
                $row["customer_ssn"],
                $row["customer_address"],
                $row["customer_city"],
                $row["customer_zip"],
                $row["created"]
            );


        } else {
            throw new Exception("Kund hittades inte.");
        }
    }


//    public static function getAllCustomersOrderedByDate($connection)
//    {
//        $query = "SELECT * FROM customers ORDER BY created DESC";
//        $statement = $connection->prepare($query);
//        $statement->execute();
//        $result = $statement->get_result();
//
//        $customers = array();
//        while ($row = $result->fetch_assoc()) {
//            // Skapa en ny instans av Customers-klassen för varje kund
//            $customer = new Customers(
//                $row["customer_id"],
//                $row["customer_firstname"],
//                $row["customer_surname"],
//                $row["customer_phone"],
//                $row["customer_email"],
//                $row["customer_ssn"],
//                $row["customer_address"],
//                $row["customer_city"],
//                $row["customer_zip"],
//                $row["created"]
//            );
//            $customers[] = $customer;
//        }
//        $statement->close();
//        return $customers;
//    }

    public static function getAllCustomersByDate($connection) {
        $query = "SELECT * FROM customers ORDER BY created DESC";
        $statement = $connection->query($query);

        $customers = array();
        while ($row = $statement->fetch_assoc()) {
            $customer = new Customers(
                $row["customer_id"],
                $row["customer_firstname"],
                $row["customer_surname"],
                $row["customer_phone"],
                $row["customer_email"],
                $row["customer_ssn"],
                $row["customer_address"],
                $row["customer_city"],
                $row["customer_zip"],
                $row["created"]
            );
            $customers[] = $customer;
        }

        return $customers;
    }


}






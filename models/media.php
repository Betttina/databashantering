<?php

//require_once "./credentials/model.php";

class Media extends BaseModel {

    protected $media_id = null;
    protected $media_name = null;
    protected $product_id = null;

    public function __construct($media_id, $media_name, $product_id) {
        $this->media_id = $media_id;
        $this->media_name = $media_name;
        $this->product_id = $product_id;
        
    }

    public function getMediaId() {
        return $this->media_id;
    }

    public function setMediaId($media_id) {
        $this->media_id = $media_id;
    }

    public function getMediaName() {
        return $this->media_name;
    }

    public function setMediaName($media_name) {
        $this->media_name = $media_name;
    }

    public function getMediaPathById($connection, $mediaId) {
        // Använd en parameteriserad fråga för att undvika SQL-injektioner
        $query_media = "SELECT media_name FROM media WHERE media_id = ?";
        
        // Förbered frågan
        $stmt = $connection->prepare($query_media);
        
        // Koppla media_id till frågan
        $stmt->bind_param("i", $mediaId);
        
        // Kör frågan
        $stmt->execute();
        
        // Hämta resultatet
        $result = $stmt->get_result();
        //var_dump($result);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            return $row['media_name'];
            var_dump($row);
           
    }}


}


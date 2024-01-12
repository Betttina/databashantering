

<?php

require_once __DIR__ . '/../credentials/database.php';


class BaseModel {

    private static $connection = null;

    function __construct()
    {
        
    }

    protected function getConnection(){
        if(Model::$connection == null){
            Model::$connection = getDatabaseConnection();
        }

        return Model::$connection;
    }

}


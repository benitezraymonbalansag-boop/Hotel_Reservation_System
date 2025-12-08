<?php

class Dbh {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbName = "hotel_reservation_system";

    public function connect() { 
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8");
        return $conn;
    }
}

?>





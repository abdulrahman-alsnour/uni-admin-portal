<?php 
class Database {
    private $host = 'localhost';
    private $db_name = 'school_db';
    private $username = 'school_user';
    private $password = 'Abdnsour$0216191';
    private $conn;

    public function connect () {
        if($this->conn === null) {
            try{
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->db_name}; charset=utf8",
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die( "Connection failed: " . $e->getMessage());
            }
        }
        return $this->conn;
    }

}
<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'ecommerce_platform');
    class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $database = DB_NAME;
    private $conn;
    
    public function __construct(){
         try {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        } catch (mysqli_sql_exception) {
        echo"<p>Could not connect!</p>";
        }
    }
    public function getConnection() {
        return $this->conn;
    }
    
    }
    $db = new Database();
?>
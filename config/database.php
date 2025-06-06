<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'wearhousedb');
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $database = DB_NAME;
    private $conn;

    public function __construct()
    {

        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public function getConnection()
    {
        return $this->conn;
    }
    function query(string $sql, $params = [], ?string $types = null): ?mysqli_result
    {
        $stmt = $this->conn->prepare($sql);
        //if no types were put in, just bind all parameters as strings.
        if (is_null($types)) {
            $stmt->execute($params);
            return $stmt->get_result() ?: null;
        }
        $stmt->bind_param($types, ...$params); //splat operator ...
        $stmt->execute();
        return $stmt->get_result() ?: null;
    }

    public function fetchAll($sql, $params = [], ?string $types = null)
    {
        $result = $this->query($sql, $params, $types);
        return $result->fetch_all(MYSQLI_ASSOC); //returns an array of all rows
    }
     public function fetchOne($sql, $params = [], ?string $types = null) {
        $result = $this->query($sql, $params, $types);
        return $result->fetch_assoc(); //returns an array of only the 1 next row
    }
    public function lastInsertId() {
        return $this->conn->insert_id;
    }
}
$db = new Database();

<?php




class SQLiteDB
{
    private $db;

    public function __construct($filename)
    {
        $this->db = new PDO('sqlite:' . $filename);
        // Set the fetch mode to associative arrays by default
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    private function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetchOneAsJson($sql, $params = [])
    {
        return json_encode($this->fetchOne($sql, $params));
    }

    public function fetchAllAsJson($sql, $params = [])
    {
        return json_encode($this->fetchAll($sql, $params));
    }

    public function __destruct()
    {
        $this->db = null;
    }
}

// Example usage:

// Create a new SQLiteDB object
$db = new SQLiteDB('E:/rmp-py-db/rmp-py.db');

// Fetch all records from the 'users' table as JSON
$teacher = $db->fetchAllAsJson('SELECT * FROM teachers LIMIT 5');
echo $teacher;

<?php
class DatabaseHandler {
    private $conn;
    private $host = 'localhost';
    private $dbname = 'expense_tracker';
    private $username = 'root';
    private $password = 'mysql@123';

    public function __construct() {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);

        // Check for connection errors
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit;
        }
    }

    public function closeDB()
    {
        if (connection_status() == 0)
            $this->conn->close();
    }

    public function query($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        
        if (!$result)
        {
            echo "Error: Unable to execute query " . mysqli_error($this->conn);
            exit;
        }
        return $result;
    }

    public function insertData($table, $data) {
        $columns = implode(',', array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";

        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        
        return $this->query($query);
    }

    public function readData($table, $constraints = array(), $columns = "*")
    {
        $conditionString = '';
        if (!empty($constraints)) {
            $conditionString = 'WHERE ';
            $conditionArray = array();

            foreach ($constraints as $key => $value) {
                $conditionArray[] = "$key = '$value'";
            }

            $conditionString .= implode(' AND ', $conditionArray);
        }

        $sql = "SELECT $columns FROM $table $conditionString";
        $result = $this->query($sql);

        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function updateData($table, $data, $constraints = array())
    {
        $setArray = array();
        foreach ($data as $key => $value) {
            $setArray[] = "$key = '$value'";
        }

        $setString = implode(', ', $setArray);

        $conditionString = '';
        if (!empty($constraints)) {
            $conditionString = 'WHERE ';
            $conditionArray = array();

            foreach ($constraints as $key => $value) {
                $conditionArray[] = "$key = '$value'";
            }

            $conditionString .= implode(' AND ', $conditionArray);
        }

        $sql = "UPDATE $table SET $setString $conditionString";
        return $this->query($sql);
    }

    public function deleteData($table, $constraints = array()) {
        $conditionString = '';
        if (!empty($constraints)) {
            $conditionString = 'WHERE ';
            $conditionArray = array();

            foreach ($constraints as $key => $value) {
                $conditionArray[] = "$key = '$value'";
            }

            $conditionString .= implode(' AND ', $conditionArray);
        }

        $sql = "DELETE FROM $table $conditionString";
        return $this->query($sql);
    }
}
?>
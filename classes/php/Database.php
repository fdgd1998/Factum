<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/php/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
    class DatabaseConnection {
        private $user = "root";
        private $pass = "";
        private $name = "factum";
        private $host = "localhost";
        public $conn;
        private $numRows;

        function __construct()
        {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
            $this->conn->set_charset("utf8");
        }

        function Connect() {
            if ($this->conn->connect_errno) {
                throw new Exception("Se ha producido un error: "+$this->conn->connect_error);
            } else {
                return true;
            }
        }

        function Transaction($queries) {
            try {
                $this->conn->begin_transaction();
                foreach($queries as $query) {
                    $this->conn->query($query);
                }
                if ($this->conn->commit()) return true;
            } catch (Exception $e) {
                $this->conn->rollback();
                return false;
            }
            
        }

        function Select($sql) {
            $output = array();
            if ($res = $this->conn->query($sql)) {
                foreach ($res->fetch_all(MYSQLI_ASSOC) as $key => $value) {
                    $output[$key] = $value;
                }
                $this->numRows = $res->num_rows;
            }
            if (sizeof($output) == 0) return false;
            else return $output;
        }

        function Delete($table, $cell, $value) {
            $sql = "delete from ".$table." where ".$cell." = '".$value."'";
            if ($this->conn->query($sql) === TRUE) return true;
            else return false;
        }

        function Update($table, $data, $where = null) {
            $sql = "update ".$table." set ";
            if (sizeof($data) > 1) {
                for ($i = 0; $i < sizeof($data)-1; $i++) {
                    $sql .= $data[$i][0]." = '".$data[$i][1]."',"; 
                }
                $sql .= $data[sizeof($data)-1][0]." = '".$data[sizeof($data)-1][1]."'";
            } else {
                $sql .= $data[0][0]." = '".$data[0][1]."'";
            }
            
            if (!is_null($where)) {
                $sql .= " where ".$where[0]." = '".$where[1]."'";
            }

            if ($this->conn->query($sql) === TRUE) return true;
            else return false;
        }

        function Insert($table, $columns, $values) {
            $sql = "insert into ".$table." (";
            for ($i = 0; $i < sizeof($columns)-1; $i++) {
                $sql .= $columns[$i].","; 
            }
            $sql .= $columns[sizeof($columns)-1].") values (";

            for ($i = 0; $i < sizeof($values)-1; $i++) {
                $sql .= "'".$values[$i]."',"; 
            }
            $sql .= "'".$values[sizeof($values)-1]."')";

            if ($this->conn->query($sql) === TRUE) return true;
            else return false;
        }

        function GetNumRows() {
            return $this->numRows;
        }

        function Close() {
            $this->conn->close();
        }
    }
?>
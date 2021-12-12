<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/classes/php/Database.php";
    function SelectFromDb($sql) {
        $conn = new DatabaseConnection();
        $res = array();

        if ($conn->Connect()) {
            $res = $conn->Select($sql);
        }

        $conn->Close();
        unset($conn);
        return $res;
    }
    
    function InsertIntoDb($table, $columns, $values) {
        $conn = new DatabaseConnection();
        $res = array();

        if ($conn->Connect()) {
            $res = $conn->Insert($table, $columns, $values);
        }

        $conn->Close();
        unset($conn);
        return $res;
    }

    function UpdateDb($table, $data, $where = null) {
        $conn = new DatabaseConnection();
        $res = false;
        
        if ($conn->Connect()) {
            if ($conn->Update($table, $data, $where) === TRUE) $res = true;
        }

        $conn->Close();
        unset($conn);
        return $res;
    }

    function DeleteFromDb($table, $cell, $value) {
        $conn = new DatabaseConnection();
        $res = false;
        
        if ($conn->Connect()) {
            if ($conn->Delete($table, $cell, $value) === TRUE) $res = true;
        }

        $conn->Close();
        unset($conn);
        return $res;
    }

    function DbTransaction($queries) {
        $conn = new DatabaseConnection();

        if ($conn->Connect()) {
            $res = $conn->Transaction($queries);
        }

        $conn->Close();
        unset($conn);
        return $res;
    }

?>
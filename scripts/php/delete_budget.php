<?php
    if ($_POST) {
        require "connection.php";

        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
        $conn->set_charset("utf8");

        if ($conn->connect_error) {
            echo "Se ha producido un error.";
            exit();
        } else {
            $sql = "delete from presupuestos where numero='".$_POST["numero"]."'";
            if ($conn->query($sql) === TRUE) {
                echo "El presupuesto se ha borrado correctamente";
            } else {
                echo "Se ha producido un error.";
            }
        }
        $conn->close();
    }
?>
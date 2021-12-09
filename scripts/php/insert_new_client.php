<?php
    if ($_POST) {
        require "connection.php";

        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
        $conn->set_charset("utf8");

        if ($conn->connect_error) {
            echo "Se ha producido un error.";
            exit();
        } else {
            $sql = (
                "insert into clientes values (
                    '".$_POST["nif"]."',
                    '".$_POST["nombre"]."',
                    '".$_POST["direccion"]."',
                    ".$_POST["cp"].",
                    '".$_POST["localidad"]."',
                    '".$_POST["telefono"]."',
                    '".$_POST["email"]."'
                )"
            );
            if ($conn->query($sql) === TRUE) {
                echo "El cliente se ha creado correctamente";
            } else {
                echo "Se ha producido un error.";
            }
        }
        $conn->close();
    }
?>
<?php
    if ($_POST) {
        require "connection.php";

        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
        $conn->set_charset("utf8");

        if ($conn->connect_error) {
            echo "Se ha producido un error.";
            exit();
        } else {
            $sql = 
                "update clientes set
                    nombre = '".$_POST["nombre"]."',
                    direccion = '".$_POST["direccion"]."',
                    cp = '".$_POST["cp"]."',
                    localidad = '".$_POST["localidad"]."',
                    telefono = '".$_POST["telefono"]."',
                    email ='".$_POST["email"]."'
                where nif='".$_POST["nif"]."'
                ";
            if ($conn->query($sql) === TRUE) {
                echo "El cliente se ha actualizado correctamente";
            } else {
                echo "Se ha producido un error.";
            }
        }
        $conn->close();
    }
?>
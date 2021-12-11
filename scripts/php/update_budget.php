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
                "update presupuestos set
                    fecha = '".$_POST["fecha"]."',
                    conceptos = '".$_POST["conceptos"]."',
                    observaciones = '".$_POST["observaciones"]."',
                    formapago = '".$_POST["formapago"]."',
                    tieneiva = '".$_POST["tieneiva"]."',
                    total = '".$_POST["total"]."',
                    imponible ='".$_POST["imponible"]."',
                    iva ='".$_POST["iva"]."'
                where numero='".$_POST["numero"]."'
                ";
            if ($conn->query($sql) === TRUE) {
                echo "El presupuesto se ha actualizado correctamente";
            } else {
                echo "Se ha producido un error.";
            }
        }
        $conn->close();
    }
?>
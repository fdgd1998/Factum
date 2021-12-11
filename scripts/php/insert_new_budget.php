<?php
    if ($_POST) {
        require "connection.php";

        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
        $conn->set_charset("utf8");

        if ($conn->connect_error) {
            echo "Se ha producido un error.";
            exit();
        } else {
            $conn->begin_transaction();
            $conn->query(
                "insert into presupuestos values (
                    '".$_POST["numero"]."',
                    '".$_POST["nif"]."',
                    '".$_POST["fecha"]."',
                    '".$_POST["conceptos"]."',
                    '".$_POST["observaciones"]."',
                    '".$_POST["formapago"]."',
                    '".$_POST["tieneiva"]."',
                    ".$_POST["total"].",
                    ".$_POST["imponible"].",
                    ".$_POST["iva"].",
                    '".$_POST["nombre"]."',
                    '".$_POST["direccion"]."',
                    ".$_POST["cp"].",
                    '".$_POST["localidad"]."'
                )"
            );
            
            $conn->query(
                "update controlfactura
                set anoultimafactura=".$_POST["year"].", numeroultimafactura=".substr($_POST["numero"],-5)." 
                where nombreserie='PR'"
            );
            
            if ($conn->commit()) {
                echo "El presupuesto se ha creado correctamente";
            } else {
                echo "Se ha producido un error.";
                $conn->rollback();
            }
        }
        $conn->close();
    }
?>
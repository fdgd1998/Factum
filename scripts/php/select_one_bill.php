<?php
    require "connection.php";

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
    $conn->set_charset("utf8");

    $output = [];

    if ($conn->connect_error) {
        echo "Se ha producido un error.";
        exit();
    } else {
        $sql = "select nif, nombre, direccion, cp, localidad from facturas where numero='".$_POST["numero"]."'";
        
        if ($res = $conn->query($sql)) {
            while ($rows = $res->fetch_assoc()) {
                $output["nif"] = $rows["nif"]; 
                $output["nombre"] = $rows["nombre"];
                $output["direccion"] = $rows["direccion"];
                $output["ciudad"] = $rows["localidad"];
                $output["cp"] = $rows["cp"];
            }
        }
    }
    $conn->close();
    echo json_encode($output);
?>
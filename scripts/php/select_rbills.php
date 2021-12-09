<?php
    require "connection.php";

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
    $conn->set_charset("utf8");

    $output = array(
        "draw" => 0,
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => array()
    );

    if ($conn->connect_error) {
        echo "Se ha producido un error.";
        exit();
    } else {
        $sql = "
            select numero, fecha, clientes.nif, clientes.nombre, total
            from facturasrec inner join clientes using(nif)
        ";
        
        if ($res = $conn->query($sql)) {
            $output["recordsTotal"] = $res->num_rows;
            $output["recordsFiltered"] = $res->num_rows;
            while ($rows = $res->fetch_assoc()) {
                array_push($output["data"], array(
                    "id" => $rows["numero"],
                    "idref" => $rows["facturaref"],
                    "fecha" => $rows["fecha"], 
                    "nif" => $rows["nif"], 
                    "nombre" => $rows["nombre"], 
                    "total" => $rows["total"]
                ));
            }
        }
    }
    $conn->close();
    echo json_encode($output);
?>
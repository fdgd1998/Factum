<?php

    require_once "../../classes/php/Database.php";

    $conn = new DatabaseConnection();
    $conn->Connect();
    
    $facturas = $conn->Select("select * from facturas where fecha between '".$_POST["fechai"]."' and '".$_POST["fechaf"]."'");
    $facturasrec = $conn->Select("select * from facturasrec where fecha between '".$_POST["fechai"]."' and '".$_POST["fechaf"]."'");

    $queries = array();

    if ($facturas) {
        foreach($facturas as $factura) {
            array_push($queries, "
                insert into facturas_archivo (
                    numero,
                    nif,
                    fecha,
                    formapago,
                    conceptos,
                    observaciones,
                    total,
                    imponible,
                    iva,
                    nombre,
                    direccion,
                    cp,
                    localidad,
                    grupo
                ) values (
                    '".$factura["numero"]."',
                    '".$factura["nif"]."',
                    '".$factura["fecha"]."',
                    '".$factura["formapago"]."',
                    '".$factura["conceptos"]."',
                    '".$factura["observaciones"]."',
                    ".$factura["total"].",
                    ".$factura["imponible"].",
                    ".$factura["iva"].",
                    '".$factura["nombre"]."',
                    '".$factura["direccion"]."',
                    ".$factura["cp"].",
                    '".$factura["localidad"]."',
                    '".$_POST["group"]."'
                )
    
            ");
        }
        array_push($queries, "delete from facturas where fecha between '".$_POST["fechai"]."' and '".$_POST["fechaf"]."'");
    }

    if ($facturasrec) {
        foreach($facturasrec as $factura) {
            array_push($queries, "
                insert into facturasrec_archivo (
                    numero,
                    facturaref,
                    nif,
                    fecha,
                    formapago,
                    conceptos,
                    observaciones,
                    total,
                    imponible,
                    iva,
                    nombre,
                    direccion,
                    cp,
                    localidad,
                    grupo
                ) values (
                    '".$factura["numero"]."',
                    '".$factura["facturaref"]."',
                    '".$factura["nif"]."',
                    '".$factura["fecha"]."',
                    '".$factura["formapago"]."',
                    '".$factura["conceptos"]."',
                    '".$factura["observaciones"]."',
                    ".$factura["total"].",
                    ".$factura["imponible"].",
                    ".$factura["iva"].",
                    '".$factura["nombre"]."',
                    '".$factura["direccion"]."',
                    ".$factura["cp"].",
                    '".$factura["localidad"]."',
                    '".$_POST["group"]."'
                )
    
            ");
        }
        array_push($queries, "delete from facturasrec where fecha between '".$_POST["fechai"]."' and '".$_POST["fechaf"]."'");
    }
    if ($conn->Transaction($queries)) echo "La base de datos se ha actualizado correctamente.";
    else echo "Ha ocurrido un error. Comprueba que los datos son correctos e inténtalo de nuevo.";

    $conn->Close();
?>
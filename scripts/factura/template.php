<?php
    include_once "datos_empresa.php";
    // require_once "../php/money_format.php";
    require_once "../php/connection.php";

    $fmt = new NumberFormatter('es_ES.UTF8', NumberFormatter::CURRENCY);

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
    $conn->set_charset("utf8");

    $datosCliente = [];
    $datosFactura = [];

    if ($conn->connect_error) {
        echo "Se ha producido un error.";
        exit();
    } else {
        $sql = "select * from ";
        if (str_contains($_GET["numero"], "FIVA")) $sql .= " facturas ";
        if (str_contains($_GET["numero"], "RFIVA")) $sql .= " facturasred ";
        if (str_contains($_GET["numero"], "PR")) $sql .= " presupuestos ";
        $sql .= " where numero='".$_GET["numero"]."'";
        
        if ($res = $conn->query($sql)) {
            $output["recordsTotal"] = $res->num_rows;
            $output["recordsFiltered"] = $res->num_rows;
            while ($rows = $res->fetch_assoc()) {
                $datosCliente["nif"] = $rows["nif"];
                $datosCliente["nombre"] = $rows["nombre"];
                $datosCliente["direccion"] = $rows["direccion"];
                $datosCliente["localidad"] = $rows["localidad"];
                $datosCliente["cp"] = $rows["cp"];
                $datosFactura["numero"] = $rows["numero"];
                $datosFactura["formapago"] = $rows["formapago"];
                $datosFactura["fecha"] = date("Y-m-d", strtotime($rows["fecha"]));
                $datosFactura["conceptos"] = json_decode($rows["conceptos"], true);
                $datosFactura["observaciones"] = $rows["observaciones"];
                $datosFactura["imponible"] = $fmt->formatCurrency($rows["imponible"], "EUR");
                $datosFactura["iva"] = $fmt->formatCurrency($rows["iva"], "EUR");
                $datosFactura["total"] = $fmt->formatCurrency($rows["total"], "EUR");
            }
        }
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <link rel="stylesheet" href="factura.css" type="text/css">
</head>
<body>
    <table width="100%">
        <tr>
            <td width="68%">
                <h1 class="company">ViGal Artesana</h1>
            </td>
            <td>
                <label><?=$nombreEmpresa?> (NIF:<?=$nifEmpresa?>)</label><br>
                <label><?=$direccionEmpresa?></label><br>
                <label><?=$telefonoEmpresa?></label><br>
                <label><?=$emailEmpresa?> | <?=$webEmpresa?></label><br>
            </td>
        </tr>
    </table>
    <h1 class="title">Factura</h1>
    <table width="100.9%" style="margin-left: -5px !important">
        <tr>
            <td width="60%">   
                <table width="100%">
                    <tr>
                        <td width="25%">
                            <label>Número:</label><br>
                            <label>Fecha:</label><br>
                            <label>Forma de pago:</label><br>
                            <?php if ($datosFactura["formapago"] == "banco"): ?>
                            <label>IBAN: </label><br>
                            <?php endif; ?>
                        </td>
                        <td>
                            <label><?=$datosFactura["numero"]?></label><br>
                            <label>08/12/2021</label><br>
                            <label><?=$datosFactura["formapago"] == "efectivo"?"Efectivo":"Transferencia bancaria"?></label><br>
                            <?php if ($datosFactura["formapago"] == "banco"): ?>
                            <label>ES20 0073 0100 5005 3471 8033</label><br>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
                </td>
                <td style="border: 1px solid black; padding: 10px">
                    <label>DATOS DEL CLIENTE</label><br>
                    <div style="height: 5px"></div>
                    <label>NIF: <?=$datosCliente["nif"]?></label><br>
                    <label><?=$datosCliente["nombre"]?></label><br>
                    <label><?=$datosCliente["direccion"]?></label><br>
                    <label><?=$datosCliente["cp"]?> <?=$datosCliente["localidad"]?></label>
                </td>
        </tr>
    </table>
    <table id="conceptos">
        <thead>
            <tr nobr="true">
                <th width="10%" style="text-align: left;">Cantidad</th>
                <th width="50%" style="text-align: left;">Descripción</th>
                <th width="15%" style="text-align: right;">Precio unitario</th>
                <th width="13%" style="text-align: right;">IVA unitario</th>
                <th width="15%" style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr nobr="true">
            <?php foreach($datosFactura["conceptos"] as $concepto): ?>
            <tr nobr="true">
                <td><?=$concepto["cantidad"]?></td>
                <td><?=$concepto["descripcion"]?></td>
                <td class="money"><?=$fmt->formatCurrency($concepto["precio"], "EUR")?></td>
                <td class="money"><?=$fmt->formatCurrency($concepto["iva"], "EUR")?></td>
                <td class="money"><?=$fmt->formatCurrency($concepto["total"], "EUR")?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <table width="100%">
        <tr>
            <td style="text-align: right;">
                <label>Base imponible: </label><br>
                <label>IVA (21%): </label><br>
                <br>
                <label style="font-size: 15px">Total a pagar: </label>
            </td>
            <td width="15%" style="text-align: right">
                <label><?=$datosFactura["imponible"]?></label><br>
                <label><?=$datosFactura["iva"]?></label><br>
                <br>
                <label style="font-size: 15px"><?=$datosFactura["total"]?></label>
            </td>
        </tr>
    </table>
    <div class="row text-end">
        <div class="col">
           
        </div>
        <div class="col-2">
           
        </div>
    </div>
    <div id="observaciones">
        <p style="font-size: 15px">Observaciones:</p>
        <p><?=$datosFactura["observaciones"]?></p>
    </div>
</body>
</html>
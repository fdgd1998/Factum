<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include_once "datos_empresa.php";
    // require_once "../php/money_format.php";
    // require_once "../php/connection.php";
    require_once "../../classes/php/Database.php";

    $conn = new DatabaseConnection();
    $fmt = new NumberFormatter('es_ES.UTF8', NumberFormatter::CURRENCY);

    // $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
    // $conn->set_charset("utf8");

    $datosCliente = [];
    $datosFactura = [];

    if ($conn->Connect()) {
        $sql = "select * from ";
        if (str_contains($_GET["numero"], "RFIVA")) $sql .= isset($_GET["archivo"]) ? "facturasrec_archivo" : " facturasrec ";
        elseif (str_contains($_GET["numero"], "PR")) $sql .= " presupuestos ";
        else $sql .= isset($_GET["archivo"]) ? "facturas_archivo" : " facturas ";
        $sql .= " where numero='".$_GET["numero"]."'";
        
        if ($rows = $conn->Select($sql)[0]) {
            $datosCliente["nif"] = $rows["nif"];
            $datosCliente["nombre"] = $rows["nombre"];
            $datosCliente["direccion"] = $rows["direccion"];
            $datosCliente["localidad"] = $rows["localidad"];
            $datosCliente["cp"] = $rows["cp"];

            if (str_contains($_GET["numero"], "RFIVA")) {
                $datosFactura["numero"] = $rows["numero"];
                $datosFactura["facturaref"] = $rows["facturaref"];
                $datosFactura["formapago"] = $rows["formapago"];
                $datosFactura["fecha"] = date("d/m/Y", strtotime($rows["fecha"]));
                $datosFactura["conceptos"] = json_decode(preg_replace('/[\xE1\xE9\xED\xF3\xFA\xC1\xC9\xCD\xD3\xDA\xF1\xD1\xFC\xDC\x0D\x0A]/',' ',$rows["conceptos"]), true);
                $datosFactura["observaciones"] = $rows["observaciones"];
                $datosFactura["imponible"] = $fmt->formatCurrency($rows["imponible"], "EUR");
                $datosFactura["iva"] = $fmt->formatCurrency($rows["iva"], "EUR");
                $datosFactura["total"] = $fmt->formatCurrency($rows["total"], "EUR");
                
            } elseif (str_contains($_GET["numero"], "PR")) {
                $datosFactura["numero"] = $rows["numero"];
                $datosFactura["tieneiva"] = $rows["tieneiva"];
                $datosFactura["fecha"] = date("d/m/Y", strtotime($rows["fecha"]));
                $datosFactura["conceptos"] = json_decode(preg_replace('/[\xE1\xE9\xED\xF3\xFA\xC1\xC9\xCD\xD3\xDA\xF1\xD1\xFC\xDC\x0D\x0A]/',' ',$rows["conceptos"]), true);
                $datosFactura["formapago"] = $rows["formapago"];
                $datosFactura["observaciones"] = $rows["observaciones"];
                $datosFactura["imponible"] = $fmt->formatCurrency($rows["imponible"], "EUR");
                $datosFactura["iva"] = $fmt->formatCurrency($rows["iva"], "EUR");
                $datosFactura["total"] = $fmt->formatCurrency($rows["total"], "EUR");
            } else {
                $datosFactura["numero"] = $rows["numero"];
                $datosFactura["formapago"] = $rows["formapago"];
                $datosFactura["fecha"] = date("d/m/Y", strtotime($rows["fecha"]));
                $datosFactura["conceptos"] = json_decode(preg_replace('/[\xE1\xE9\xED\xF3\xFA\xC1\xC9\xCD\xD3\xDA\xF1\xD1\xFC\xDC\x0D\x0A]/',' ',$rows["conceptos"]), true);
                $datosFactura["observaciones"] = $rows["observaciones"];
                $datosFactura["imponible"] = $fmt->formatCurrency($rows["imponible"], "EUR");
                $datosFactura["iva"] = $fmt->formatCurrency($rows["iva"], "EUR");
                $datosFactura["total"] = $fmt->formatCurrency($rows["total"], "EUR");
            }
        }
    }
    $conn->Close();
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
            <td width="55%">
                <h1 class="company">ViGal Artesana</h1>
            </td>
            <td>
                <label><?=$nombreEmpresa?> (NIF: <?=$nifEmpresa?>)</label><br>
                <label><?=$direccionEmpresa?></label><br>
                <label><?=$telefonoEmpresa?></label><br>
                <label><?=$emailEmpresa?> | <?=$webEmpresa?></label><br>
            </td>
        </tr>
    </table>
    <?php if (str_contains($_GET["numero"], "RFIVA")):?>
    <h1 class="title">Factura rectificativa</h1>
    <?php elseif (str_contains($_GET["numero"], "PR")): ?>
    <h1 class="title">Presupuesto</h1>
    <?php else: ?>
    <h1 class="title">Factura</h1>
    <?php endif; ?>
    <table width="100.9%" style="margin-left: -5px !important">
        <tr>
            <td width="54%">   
                <table width="100%">
                    <tr>
                        <td width="35%">
                            <label>Número:</label><br>
                            <?php if (isset($datosFactura["facturaref"])): ?>
                            <label>Rectifica a: </label><br>
                            <?php endif; ?>
                            <label>Fecha:</label><br>
                            <?php if (isset($datosFactura["tieneiva"])): ?>
                            <label>Presupuesto con IVA:</label><br>
                            <?php endif; ?>
                            <?php if (isset($datosFactura["formapago"])): ?>
                            <label>Forma de pago:</label><br>
                            <?php if ($datosFactura["formapago"] == "banco"): ?>
                            <label>IBAN: </label><br>
                            <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <label><?=$datosFactura["numero"]?></label><br>
                            <?php if (isset($datosFactura["facturaref"])): ?>
                            <label><?=$datosFactura["facturaref"]?></label><br>
                            <?php endif; ?>
                            <label><?=$datosFactura["fecha"]?></label><br>
                            <?php if (isset($datosFactura["tieneiva"])): ?>
                            <label><?=$datosFactura["tieneiva"]=="si"?"Sí":"No"?></label><br>
                            <?php endif; ?>
                            <?php if (isset($datosFactura["formapago"])): ?>
                            <label><?=$datosFactura["formapago"] == "efectivo"?"Efectivo":"Transferencia bancaria"?></label><br>
                            <?php if ($datosFactura["formapago"] == "banco"): ?>
                            <label><?=$ibanEmpresa?></label><br>
                            <?php endif; ?>
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
                <?php if ((isset($datosFactura["tieneiva"]) && $datosFactura["tieneiva"] == "si") || str_contains($_GET["numero"], "FIVA")): ?>
                <th width="13%" style="text-align: right;">IVA unitario</th>
                <?php endif; ?>
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
                <?php if ((isset($datosFactura["tieneiva"]) && $datosFactura["tieneiva"] == "si") || str_contains($_GET["numero"], "FIVA")): ?>
                <td class="money"><?=$fmt->formatCurrency($concepto["iva"], "EUR")?></td>
                <?php endif; ?>
                <td class="money"><?=$fmt->formatCurrency($concepto["total"], "EUR")?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <table width="100%">
        <tr>
            <td style="text-align: right;">
                <?php if ((isset($datosFactura["tieneiva"]) && $datosFactura["tieneiva"] == "si") || str_contains($_GET["numero"], "FIVA")): ?>
                <label>Base imponible: </label><br>
                <label>IVA (21%): </label><br>
                <?php endif; ?>
                <br>
                <label style="font-size: 15px">Total a pagar: </label>
            </td>
            <td width="15%" style="text-align: right">
                <?php if ((isset($datosFactura["tieneiva"]) && $datosFactura["tieneiva"] == "si") || str_contains($_GET["numero"], "FIVA")): ?>
                <label><?=$datosFactura["imponible"]?></label><br>
                <label><?=$datosFactura["iva"]?></label><br>
                <?php endif; ?>
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

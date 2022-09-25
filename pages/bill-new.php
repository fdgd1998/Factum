<?php

    $action = $_GET["page"];
    $numerofactura = "";
    $viewBillData = [];
    $rectifyBills = array();
    $archived = false;

    require_once $_SERVER["DOCUMENT_ROOT"]."/classes/php/Database.php";

    $conn = new DatabaseConnection();
    $fmt = new NumberFormatter('es_ES.UTF8', NumberFormatter::CURRENCY);
    
    echo "<script>var action = '".$action."'</script>"; 

    if ($action == "new-bill") {
        if ($conn->Connect()) {
            $sql = "select * from controlfactura where nombreserie='FIVA'";
            
            if ($rows = $conn->Select($sql)[0]) {
                if ($rows["anoultimafactura"] < date("y")) {
                    $numerofactura .= date("y");
                    $numerofactura .= $rows["nombreserie"];
                    $numerofactura .= str_pad(1, 5, "0", STR_PAD_LEFT);
                } else {
                    $numerofactura .= $rows["anoultimafactura"];
                    $numerofactura .= $rows["nombreserie"];
                    $numerofactura .= str_pad($rows["numeroultimafactura"]+1, 5, "0", STR_PAD_LEFT);
                }
                
            }
        }
        $conn->Close();
    } else if ($action == "edit-budget") {
        if ($conn->Connect()) {
            $sql = "select * from presupuestos where numero='".$_GET["numero"]."'";
            
            if ($rows = $conn->Select($sql)[0]) {
                $viewBillData["numero"] = $rows["numero"];
                $viewBillData["nif"] = $rows["nif"];
                $viewBillData["fecha"] = date("Y-m-d", strtotime($rows["fecha"]));
                $viewBillData["conceptos"] = json_decode(preg_replace('/[\xE1\xE9\xED\xF3\xFA\xC1\xC9\xCD\xD3\xDA\xF1\xD1\xFC\xDC\x0D\x0A]/',' ',$rows["conceptos"]), true);
                $viewBillData["observaciones"] = $rows["observaciones"];
                $viewBillData["total"] = $rows["total"];
                $viewBillData["formapago"] = $rows["formapago"];
                $viewBillData["iva"] = $rows["iva"];
                $viewBillData["tieneiva"] = $rows["tieneiva"];
                $viewBillData["imponible"] = $rows["imponible"];
                $viewBillData["nombre"] = $rows["nombre"];
                $viewBillData["direccion"] = $rows["direccion"];
                $viewBillData["cp"] = $rows["cp"];
                $viewBillData["localidad"] = $rows["localidad"];
            }
            echo "
                <script>
                    iva_global = ".$viewBillData["iva"].";
                    imponible_global = ".$viewBillData["imponible"].";
                    total_global = ".$viewBillData["total"].";
                </script>
            ";
        }
        $conn->Close();
    } else if ($action == "new-budget") {
        if ($conn->Connect()) {
            $sql = "select * from controlfactura where nombreserie='PR'";
            
            if ($rows = $conn->Select($sql)[0]) {
                if ($rows["anoultimafactura"] < date("y")) {
                    $numerofactura .= date("y");
                    $numerofactura .= $rows["nombreserie"];
                    $numerofactura .= str_pad(1, 5, "0", STR_PAD_LEFT);
                } else {
                    $numerofactura .= $rows["anoultimafactura"];
                    $numerofactura .= $rows["nombreserie"];
                    $numerofactura .= str_pad($rows["numeroultimafactura"]+1, 5, "0", STR_PAD_LEFT);
                }
                
            }
        }
        $conn->Close();
    } else if ($action == "rectify-bill") {
        if ($conn->Connect()) {
            $sql = "select * from controlfactura where nombreserie='RFIVA'";
            
            if ($rows = $conn->Select($sql)[0]) {
                if ($rows["anoultimafactura"] < date("y")) {
                    $numerofactura .= date("y");
                    $numerofactura .= $rows["nombreserie"];
                    $numerofactura .= str_pad(1, 5, "0", STR_PAD_LEFT);
                } else {
                    $numerofactura .= $rows["anoultimafactura"];
                    $numerofactura .= $rows["nombreserie"];
                    $numerofactura .= str_pad($rows["numeroultimafactura"]+1, 5, "0", STR_PAD_LEFT);
                }
                
            }
        }
        $conn->Close();
    } else if ($action == "edit-bill") {
        if ($conn->Connect()) {
            $sql = "select * from facturas where numero='".$_GET["numero"]."'";
            
            if ($rows = $conn->Select($sql)[0]) {
                $viewBillData["numero"] = $rows["numero"];
                $viewBillData["nif"] = $rows["nif"];
                $viewBillData["fecha"] = date("Y-m-d", strtotime($rows["fecha"]));
                $viewBillData["conceptos"] = json_decode(preg_replace('/[\xE1\xE9\xED\xF3\xFA\xC1\xC9\xCD\xD3\xDA\xF1\xD1\xFC\xDC\x0D\x0A]/',' ',$rows["conceptos"]), true);
                $viewBillData["observaciones"] = $rows["observaciones"];
                $viewBillData["total"] = $rows["total"];
                $viewBillData["formapago"] = $rows["formapago"];
                $viewBillData["iva"] = $rows["iva"];
                $viewBillData["imponible"] = $rows["imponible"];
                $viewBillData["nombre"] = $rows["nombre"];
                $viewBillData["direccion"] = $rows["direccion"];
                $viewBillData["cp"] = $rows["cp"];
                $viewBillData["localidad"] = $rows["localidad"];
            }
            echo "
                <script>
                    iva_global = ".$viewBillData["iva"].";
                    imponible_global = ".$viewBillData["imponible"].";
                    total_global = ".$viewBillData["total"].";
                </script>
            ";
        }
        $conn->Close();
    } else if (str_contains($_GET["numero"], "RFIVA")) {
        if ($conn->Connect()) {
            $sql = "select * from facturasrec where numero='".$_GET["numero"]."'";
            
            if ($rows = $conn->Select($sql)[0]) {
                $viewBillData["numero"] = $rows["numero"];
                $viewBillData["facturaref"] = $rows["facturaref"];
                $viewBillData["nif"] = $rows["nif"];
                $viewBillData["fecha"] = date("Y-m-d", strtotime($rows["fecha"]));
                $viewBillData["formapago"] = $rows["formapago"];
                $viewBillData["conceptos"] = json_decode($rows["conceptos"], true);
                $viewBillData["observaciones"] = $rows["observaciones"];
                $viewBillData["total"] = $rows["total"];
                $viewBillData["iva"] = $rows["iva"];
                $viewBillData["imponible"] = $rows["imponible"];
                $viewBillData["nombre"] = $rows["nombre"];
                $viewBillData["direccion"] = $rows["direccion"];
                $viewBillData["cp"] = $rows["cp"];
                $viewBillData["localidad"] = $rows["localidad"];
            } else {
                $archived = true;
                echo "<script>archivo = true</script>";
                $sql = "select * from facturasrec_archivo where numero='".$_GET["numero"]."'";
            
                if ($rows = $conn->Select($sql)[0]) {
                    $viewBillData["numero"] = $rows["numero"];
                    $viewBillData["facturaref"] = $rows["facturaref"];
                    $viewBillData["nif"] = $rows["nif"];
                    $viewBillData["fecha"] = date("Y-m-d", strtotime($rows["fecha"]));
                    $viewBillData["formapago"] = $rows["formapago"];
                    $viewBillData["conceptos"] = json_decode($rows["conceptos"], true);
                    $viewBillData["observaciones"] = $rows["observaciones"];
                    $viewBillData["total"] = $rows["total"];
                    $viewBillData["iva"] = $rows["iva"];
                    $viewBillData["imponible"] = $rows["imponible"];
                    $viewBillData["nombre"] = $rows["nombre"];
                    $viewBillData["direccion"] = $rows["direccion"];
                    $viewBillData["cp"] = $rows["cp"];
                    $viewBillData["localidad"] = $rows["localidad"];
                }
            }
        }
        $conn->Close();
    } else if (str_contains($_GET["numero"], "FIVA")) {
        if ($conn->Connect()) {
            $sql = "select * from facturas where numero='".$_GET["numero"]."'";
            if ($rows = $conn->Select($sql)[0]) {
                $viewBillData["numero"] = $rows["numero"];
                $viewBillData["nif"] = $rows["nif"];
                $viewBillData["fecha"] = date("Y-m-d", strtotime($rows["fecha"]));
                $viewBillData["formapago"] = $rows["formapago"];
                $viewBillData["conceptos"] = json_decode($rows["conceptos"], true);
                $viewBillData["observaciones"] = $rows["observaciones"];
                $viewBillData["total"] = $rows["total"];
                $viewBillData["iva"] = $rows["iva"];
                $viewBillData["imponible"] = $rows["imponible"];
                $viewBillData["nombre"] = $rows["nombre"];
                $viewBillData["direccion"] = $rows["direccion"];
                $viewBillData["cp"] = $rows["cp"];
                $viewBillData["localidad"] = $rows["localidad"];
            } else {
                $archived = true;
                echo "<script>archivo = true</script>";
                $sql = "select * from facturas_archivo where numero='".$_GET["numero"]."'";
                if ($rows = $conn->Select($sql)[0]) {
                    $viewBillData["numero"] = $rows["numero"];
                    $viewBillData["nif"] = $rows["nif"];
                    $viewBillData["fecha"] = date("Y-m-d", strtotime($rows["fecha"]));
                    $viewBillData["formapago"] = $rows["formapago"];
                    $viewBillData["conceptos"] = json_decode($rows["conceptos"], true);
                    $viewBillData["observaciones"] = $rows["observaciones"];
                    $viewBillData["total"] = $rows["total"];
                    $viewBillData["iva"] = $rows["iva"];
                    $viewBillData["imponible"] = $rows["imponible"];
                    $viewBillData["nombre"] = $rows["nombre"];
                    $viewBillData["direccion"] = $rows["direccion"];
                    $viewBillData["cp"] = $rows["cp"];
                    $viewBillData["localidad"] = $rows["localidad"];
                }
            }

            if ($archived) $sql = "select numero from facturasrec_archivo where facturaref='".$viewBillData["numero"]."'";
            else $sql = "select numero from facturasrec where facturaref='".$viewBillData["numero"]."'";

            if ($res = $conn->Select($sql)) {
                foreach ($res as $ref)
                    array_push($rectifyBills, $ref);      
            }
        }
        $conn->Close();
    }
?>
<?php
    if ($action == "new-bill") echo "<h1>Nueva factura</h1>";
    if ($action == "new-budget") echo "<h1>Nuevo presupuesto</h1>";
    if ($action == "edit-budget") echo "<h1>Editar presupuesto</h1>";
    if ($action == "edit-bill") echo "<h1>Editar factura</h1>";
    if (str_contains($_GET["numero"], "RFIVA")) echo "<h1>Ver factura rectificativa </h1>";
    else if (str_contains($_GET["numero"], "FIVA") && $action != "edit-bill") echo "<h1>Ver factura </h1>";
    if ($action == "rectify-bill") echo "<h1>Nueva factura rectificativa</h1>";
?>

<div class="content">
    <div class="row">
        <div class="col-12 col-md-5 col-lg-4">
            <?php
                if ($action == "new-bill" || $action == "view-bill" || $action=="edit-bill" || $action == "rectify-bill") echo "<p>Datos de la factura ".($archived?"<span style='color: black' class='badge bg-warning'>Archivo</span>":"")."</p>";
                if ($action == "new-budget" || $action == "edit-budget") echo "<p>Datos del presupuesto</p>";
            ?>
            <div class="input-group mb-3">
                <span class="input-group-text">Número:</span>
                <?php if($action=="new-bill" || $action == "new-budget" || $action == "rectify-bill"):?>
                <input disabled id="numero" type="text" class="form-control" value=<?=$numerofactura?>>
                <?php endif; ?>
                <?php if($action=="view-bill" || $action=="edit-bill" || $action=="edit-budget"):?>
                <input disabled id="numero" type="text" class="form-control" value=<?=$viewBillData["numero"]?>>
                <?php endif; ?>
            </div>
            <?php if($action == "rectify-bill" || str_contains($_GET["numero"], "RFIVA")): ?>
            <div class="input-group mb-3" colspan="4">
                <span class="input-group-text">Factura:</span>
                <input disabled id="bill-reference" type="text" class="form-control" value="<?=str_contains($_GET["numero"], "RFIVA")?$viewBillData["facturaref"]:""?>">
                <?php if($action == "rectify-bill"): ?>
                <button class="input-group-text my-button" id="nif-letter" data-bs-toggle="modal" data-bs-target="#billSearchModal"><i class="bi bi-search no-margin"></i></button>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="input-group mb-3">
                <span class="input-group-text">Fecha:</span>
                <?php if($action=="view-bill" || $action=="edit-bill"):?>
                <input disabled id="fecha" type="date" class="form-control" value="<?=$viewBillData["fecha"]?>">
                <?php elseif($action=="edit-budget"):?>
                <input id="fecha" type="date" class="form-control" value="<?=$viewBillData["fecha"]?>">
                <?php else: ?>
                <input id="fecha" type="date" class="form-control">
                <?php endif; ?>
            </div>
            <?php if ($action == "new-budget" || $action == "edit-budget"): ?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="presupuesto-iva">Presupuesto con IVA: </label>
                <select class="form-select" id="presupuesto-iva">
                    <option <?=isset($viewBillData["tieneiva"])?($viewBillData["tieneiva"]=="si"?"selected":""):"selected"?> value="si">Sí</option>
                    <option <?=isset($viewBillData["tieneiva"])?($viewBillData["tieneiva"]=="no"?"selected":""):""?> value="no">No</option>
                </select>
            </div>
            <?php endif; ?>

            <?php if ($action != "view-bill" && $action != "edit-budget"): ?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="forma-pago">Forma de pago: </label>
                <select class="form-select" id="forma-pago">
                    <option selected value="efectivo">Efectivo</option>
                    <option value="banco">Transferencia bancaria</option>
                </select>
            </div>
            <?php else: ?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="forma-pago">Forma de pago: </label>
                <select <?=$action=="edit-budget"?"":"disabled"?> class="form-select" id="forma-pago">
                    <option <?=$viewBillData["formapago"]=="efectivo"?"selected":""?> value="efectivo">Efectivo</option>
                    <option <?=$viewBillData["formapago"]=="banco"?"selected":""?> value="banco">Transferencia bancaria</option>
                </select>
            </div>
            <?php endif; ?> 
            <?php if (sizeof($rectifyBills) > 0): ?>
            <p>Las siguientes facturas rectificativas modifican a esta:</p>
            <ul style="list-style-type: none; padding-left: 0">
                <?php foreach ($rectifyBills[0] as $bill): ?>
                    <li><a href="?page=view-bill&numero=<?=$bill?>"><?=$bill?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <?php if (str_contains($viewBillData["numero"], "RFIVA")): ?>
            <p>Ver factura original: <a href="?page=view-bill&numero=<?=$viewBillData["facturaref"]?>"><?=$viewBillData["facturaref"]?></a></p>
            <?php endif; ?>
        </div>
        <div class="col-12 col-md-7 col-lg-8">
            <p>Datos del cliente</p>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text">NIF:</span>
                        <input disabled id="nif" type="text" class="form-control" value="<?=($action=="view-bill" || $action=="edit-bill" || $action=="edit-budget")?$viewBillData["nif"]:""?>">
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="input-group mb-3" colspan="4">
                        <span class="input-group-text">Nombre:</span>     
                        <input disabled id="nombre" type="text" class="form-control" value="<?=($action=="view-bill" || $action=="edit-bill" || $action=="edit-budget")?$viewBillData["nombre"]:""?>">
                        <?php if ($action == "new-bill" || $action == "new-budget"): ?>
                        <button class="input-group-text my-button" data-bs-toggle="modal" data-bs-target="#clientSearchModal"><i class="bi bi-search no-margin"></i></button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Dirección:</span>
                        <input disabled id="direccion" type="text" class="form-control" value="<?=($action=="view-bill" || $action=="edit-bill" || $action=="edit-budget")?$viewBillData["direccion"]:""?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-3 col-xl-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text">CP:</span>
                        <input disabled id="cp" type="text" class="form-control" value="<?=($action=="view-bill" || $action=="edit-bill" || $action=="edit-budget")?$viewBillData["cp"]:""?>">
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Ciudad:</span>
                        <input disabled id="localidad" type="text" class="form-control" value="<?=($action=="view-bill" || $action=="edit-bill" || $action=="edit-budget")?$viewBillData["localidad"]:""?>">
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <hr>
    <div id="bill-content">
        <?php if ($action != "view-bill"): ?>
        <?php if ($action == "new-bill" || $action == "new-budget") : ?>
        <div id="continue-alert" class="alert alert-warning" role="alert">
            Para continuar, selecciona un cliente primero.
        </div>
        <?php endif; ?>
        <div class="my-btn-group">
            <button <?=($action=="new-bill"||$action=="new-budget")?"disabled":""?> id="NewBtn" class="btn my-button" data-bs-toggle="modal" data-bs-target="#newConceptModal"><i class="bi bi-plus-circle"></i>Nuevo</button>
            <button disabled id="EditBtn" class="btn my-button-3" data-bs-toggle="modal" data-bs-target="#editConceptModal"><i class="bi bi-pencil"></i>Editar</button>
            <button disabled id="DeleteBtn" class="btn my-button-2"><i class="bi bi-x-circle"></i>Borrar</button>
        </div>
        <?php endif; ?>
        <div class="table-responsive mt-1">
            <table id="dTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%">Cantidad</th>
                        <th width="55%">Descripción</th>
                        <th width="15%">Precio unitario</th>
                        <th width="10%">IVA unitario</th>
                        <th width="10%">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($action == "view-bill" || $action=="edit-bill" || $action == "edit-budget"):?>
                        <?php $i=0; foreach($viewBillData["conceptos"] as $concepto):?>
                        <tr id="concept<?=$i?>">
                            <td class="cantidad"><?=$concepto["cantidad"]?></td>
                            <td class="descripcion"><?=$concepto["descripcion"]?></td>
                            <td class="precio"><?=$fmt->formatCurrency($concepto["precio"], "EUR")?></td>
                            <td class="iva"><?=$viewBillData["tieneiva"]=="no"?"--":$fmt->formatCurrency($concepto["iva"], "EUR")?></td>
                            <td class="total"><?=$fmt->formatCurrency($concepto["total"], "EUR")?></td>
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="w-100 text-end mt-2">
            <div class="row">
                <div class="col-10">
                    <p>Base imponible: </p>
                    <p>IVA (21%): </p>
                    <strong><p>Total a pagar: </p></strong>
                </div>
                <div class="col-2">
                    <?php if($action == "view-bill" || $action=="edit-bill" || $action == "edit-budget"): ?>
                    <p id="base-imponible"><?=$fmt->formatCurrency($viewBillData["imponible"], "EUR")?></p>
                    <p id="total-iva"><?=$viewBillData["tieneiva"]=="no"?"--":$fmt->formatCurrency($viewBillData["iva"], "EUR")?></p>
                    <strong><p id="total-factura"><?=$fmt->formatCurrency($viewBillData["total"], "EUR")?></p></strong>
                    <?php else: ?>
                    <p id="base-imponible">--</p>
                    <p id="total-iva">--</p>
                    <strong><p id="total-factura">--</p></strong>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <?php if ($action == "view-bill" || $action == "edit-bill" || $action == "edit-budget"): ?>
            <textarea <?=($action=="view-bill")?"disabled":""?> class="form-control" id="observaciones" rows="3"><?=$viewBillData["observaciones"]?></textarea>
            <?php else : ?>
            <textarea <?=($action=="new-budget"||$action=="new-bill")?"disabled":""?> class="form-control" id="observaciones" rows="3">No se realizan devoluciones del dinero pagado (consultar condiciones).</textarea>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($action == "new-bill" ||  $action == "edit-bill" || $action == "new-budget" || $action == "rectify-bill" || $action == "edit-budget"): ?>
    <div class="my-button-group mt-4 mb-5 float-end">
        <button id="cancelBtn" class="btn my-button-2"><i class="bi bi-x-square"></i>Cancelar</button>
        <button <?=($action=="edit-budget"||$action=="edit-bill")?"":"disabled"?> id="SaveBtn" class="btn my-button-3"><i class="bi bi-save"></i>Guardar</button>
        <!-- <button <?=($action=="edit-budget"||$action=="edit-bill")?"":"disabled"?> id="<?=($action=="view-bill" || $action == "view-bill")?"PrintBtn":"SavePrintBtn"?>" class="btn my-button-4"><i class="bi bi-printer"></i>Guardar e imprimir</button> -->
    </div>
    <?php endif; ?>
    <?php if ($action == "view-bill"): ?>
    <div class="my-button-group mt-4 mb-5 float-end">
        <button id="cancelBtn" class="btn my-button-2"><i class="bi bi-x-square"></i>Cancelar</button>
        <button id="PrintBtn" class="btn my-button-4"><i class="bi bi-printer"></i>Imprimir</button>
    </div>
    <?php endif; ?>

</div>

<?php if ($action = "new-bill" || $action = "edit-budget" || $action = "edit-bill" || $action = "new-budget" || $action = "rectify-bill"): ?>
<!-- New concept modal -->
<div class="modal fade" id="newConceptModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newConceptLabel">Añadir concepto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
            <span class="input-group-text">Cantidad</span>
            <input id="cantidad" type="number" step="1" min="1" class="form-control">
            <div class="invalid-feedback">
                Introduce una cantidad válida.
            </div>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Precio unitario:</span>
            <input id="precio-unitario" type="number" step="0.01" min="0" class="form-control">
            <div class="invalid-feedback">
                Introduce un precio válido.
            </div>
        </div>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" class="form-control" rows="5"></textarea>
        <div class="w-100 text-end mt-2">
            <div class="row">
                <div class="col-8">
                    <p>IVA (21%): </p>
                    <strong><p>Total: </p></strong>
                </div>
                <div class="col-4">
                    <p><span id="concepto-iva">--</span></p>
                    <strong><p><span id="concepto-total">--</span></p></strong>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn my-button-2" data-bs-dismiss="modal">Cerrar</button>
        <button disabled id="conceptCreateBtn" type="button" class="btn my-button-3">Añadir</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit concept modal -->
<div class="modal fade" id="editConceptModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editConceptLabel">Editar concepto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
            <span class="input-group-text">Cantidad</span>
            <input id="cantidad-edit" type="number" step="1" min="1" max="99999999999" class="form-control">
            <div class="invalid-feedback">
                Introduce una cantidad válida.
            </div>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Precio unitario:</span>
            <input id="precio-unitario-edit" type="number" step="0.01" min="0" max="9999999999" class="form-control">
            <div class="invalid-feedback">
                Introduce un precio válido.
            </div>
        </div>
        <label for="descripcion-edit">Descripción:</label>
        <textarea id="descripcion-edit" class="form-control" rows="5"></textarea>
        <div class="w-100 text-end mt-2">
            <div class="row">
                <div class="col-8">
                    <p>IVA (21%): </p>
                    <strong><p>Total: </p></strong>
                </div>
                <div class="col-4">
                    <p><span id="concepto-iva-edit">--</span></p>
                    <strong><p><span id="concepto-total-edit">--</span></p></strong>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn my-button-2" data-bs-dismiss="modal">Cerrar</button>
        <button disabled id="conceptEditBtn" type="button" class="btn my-button-3">Editar</button>
      </div>
    </div>
  </div>
</div>


<!-- Clients search and choose -->
<div class="modal fade" id="clientSearchModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="clientSearchLabel">Buscar cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Si el cliente que buscas no existe, <a href="?page=new-client">regístralo primero</a> y vuelve más tarde a esta página.</p>
        <table id="dTableClients" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th width="10%">NIF</th>
                    <th width="30%">Nombre</th>
                    <th width="35%">Dirección</th>
                    <th width="5%">CP</th>
                    <th width="20%">Ciudad</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn my-button-2" data-bs-dismiss="modal">Cerrar</button>
        <button disabled id="selectClientBtn" type="button" class="btn my-button-3">Seleccionar</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if ($action = "rectify-bill"): ?>
<!-- Bill search and choose -->
<div class="modal fade" id="billSearchModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="billSearchLabel">Buscar factura</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table id="dTableBills" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th width="10%">Número</th>
                    <th width="10%">Fecha</th>
                    <th width="15%">NIF</th>
                    <th width="30%">Nombre</th>
                    <th width="20%">Total</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn my-button-2" data-bs-dismiss="modal">Cerrar</button>
        <button disabled id="selectBillBtn" type="button" class="btn my-button-3">Seleccionar</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
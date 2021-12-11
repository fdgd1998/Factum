<?php
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
    $action = $_GET["page"];
    $numerofactura = "";
    $viewBillData = [];

    $fmt = new NumberFormatter('es_ES.UTF8', NumberFormatter::CURRENCY);
    
    echo "<script>var action = '".$action."'</script>";

    require "scripts/php/money_format.php";
    require "scripts/php/connection.php";  

    if ($action == "new-bill") {
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
        if ($conn->connect_error) {
            echo "Se ha producido un error.";
            exit();
        } else {
            $sql = "select * from controlfactura where nombreserie='FIVA'";
            
            if ($rows = $conn->query($sql)->fetch_assoc()) {
                if ($rows["anoultimafactura"] > date("y")) 
                    $numerofactura .= $rows["anoultimafactura"];
                else $numerofactura .= date("y");
                
                $numerofactura .= $rows["nombreserie"];
                $numerofactura .= str_pad($rows["numeroultimafactura"]+1, 5, "0", STR_PAD_LEFT);
            }
        }
        $conn->close();
    }

    if ($action == "new-budget") {
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
        if ($conn->connect_error) {
            echo "Se ha producido un error.";
            exit();
        } else {
            $sql = "select * from controlfactura where nombreserie='PR'";
            
            if ($rows = $conn->query($sql)->fetch_assoc()) {
                if ($rows["anoultimafactura"] > date("y")) 
                    $numerofactura .= $rows["anoultimafactura"];
                else $numerofactura .= date("y");
                
                $numerofactura .= $rows["nombreserie"];
                $numerofactura .= str_pad($rows["numeroultimafactura"]+1, 5, "0", STR_PAD_LEFT);
            }
        }
        $conn->close();
    }

    
    if ($action == "rectify-bill") {
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
        if ($conn->connect_error) {
            echo "Se ha producido un error.";
            exit();
        } else {
            $sql = "select * from controlfactura where nombreserie='RFIVA'";
            
            if ($rows = $conn->query($sql)->fetch_assoc()) {
                if ($rows["anoultimafactura"] > date("y")) 
                    $numerofactura .= $rows["anoultimafactura"];
                else $numerofactura .= date("y");
                
                $numerofactura .= $rows["nombreserie"];
                $numerofactura .= str_pad($rows["numeroultimafactura"]+1, 5, "0", STR_PAD_LEFT);
            }
        }
        $conn->close();
    }

    if ($action == "view-bill") {
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
        if ($conn->connect_error) {
            echo "Se ha producido un error.";
            exit();
        } else {
            $sql = "select * from facturas where numero='".$_GET["id"]."'";
            
            if ($rows = $conn->query($sql)->fetch_assoc()) {
                $viewBillData["numero"] = $rows["numero"];
                $viewBillData["nif"] = $rows["nif"];
                $viewBillData["fecha"] = date("Y-m-d", strtotime($rows["fecha"]));
                $viewBillData["formapago"] = $rows["formapago"];
                $viewBillData["conceptos"] = json_decode($rows["conceptos"], true);
                $viewBillData["observaciones"] = $rows["observaciones"];
                $viewBillData["total"] = money_format("%i", $rows["total"]);
                $viewBillData["iva"] = money_format("%i", $rows["iva"]);
                $viewBillData["imponible"] = money_format("%i", $rows["imponible"]);
                $viewBillData["nombre"] = $rows["nombre"];
                $viewBillData["direccion"] = $rows["direccion"];
                $viewBillData["cp"] = $rows["cp"];
                $viewBillData["localidad"] = $rows["localidad"];
            }
        }
        $conn->close();
    }
?>
<?php
    if ($action == "new-bill") echo "<h1>Nueva factura</h1>";
    if ($action == "view-bill") echo "<h1>Ver factura</h1>";
    if ($action == "new-budget") echo "<h1>Nuevo presupuesto</h1>";
    if ($action == "rectify-bill") echo "<h1>Nueva factura rectificativa</h1>";
?>
<div class="content">
    <div class="row">
        <div class="col-12 col-md-5 col-lg-4">
            <?php
                if ($action == "new-bill" || $action == "view-bill" || $action == "rectify-bill") echo "<p>Datos de la factura</p>";
                if ($action == "new-budget") echo "<p>Datos del presupuesto</p>";
            ?>
            <div class="input-group mb-3">
                <span class="input-group-text">Número:</span>
                <?php if($action=="new-bill" || $action == "new-budget" || $action == "rectify-bill"):?>
                <input disabled id="numero" type="text" class="form-control" value=<?=$numerofactura?>>
                <?php endif; ?>
                <?php if($action=="view-bill"):?>
                <input disabled id="numero" type="text" class="form-control" value=<?=$viewBillData["numero"]?>>
                <?php endif; ?>
            </div>
            <?php if($action == "rectify-bill"): ?>
            <div class="input-group mb-3" colspan="4">
                <span class="input-group-text">Factura:</span>
                <input disabled id="bill-reference" type="text" class="form-control">
                <button class="input-group-text my-button" id="nif-letter" data-bs-toggle="modal" data-bs-target="#billSearchModal"><i class="bi bi-search no-margin"></i></button>
            </div>
            <?php endif; ?>
            <div class="input-group mb-3">
                <span class="input-group-text">Fecha:</span>
                <?php if($action=="view-bill"):?>
                <input disabled id="fecha" type="date" class="form-control" value="<?=$viewBillData["fecha"]?>">
                <?php else: ?>
                <input id="fecha" type="date" class="form-control">
                <?php endif; ?>
            </div>
            <?php if ($action == "new-budget"): ?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="presupuesto-iva">Presupuesto con IVA: </label>
                <select class="form-select" id="presupuesto-iva">
                    <option selected value="si">Sí</option>
                    <option value="no">No</option>
                </select>
            </div>
            <?php endif; ?>

            <?php if ($action == "new-bill" || $action == "rectify-bill"): ?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="forma-pago">Forma de pago: </label>
                <select class="form-select" id="forma-pago">
                    <option selected value="efectivo">Efectivo</option>
                    <option value="banco">Transferencia bancaria</option>
                </select>
            </div>
            <?php endif; ?> 
            <?php if ($action == "view-bill"): ?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="forma-pago">Forma de pago: </label>
                <select disabled class="form-select" id="forma-pago">
                    <option <?=$viewBillData["formapago"]=="efectivo"?"selected":""?> value="efectivo">Efectivo</option>
                    <option <?=$viewBillData["formapago"]=="banco"?"selected":""?> value="banco">Transferencia bancaria</option>
                </select>
            </div>
            <?php endif; ?> 

        </div>
        <div class="col-12 col-md-7 col-lg-8">
            <p>Datos del cliente</p>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text">NIF:</span>
                        <?php if ($action == "view-bill"): ?>
                        <input disabled id="nif" type="text" class="form-control" value="<?=$viewBillData["nif"]?>">
                        <?php else: ?>
                        <input disabled id="nif" type="text" class="form-control">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="input-group mb-3" colspan="4">
                        <span class="input-group-text">Nombre:</span>     
                        <?php if ($action != "view-bill"): ?>
                        <input disabled id="nombre" type="text" class="form-control">
                        <button class="input-group-text my-button" id="nif-letter" data-bs-toggle="modal" data-bs-target="#clientSearchModal"><i class="bi bi-search no-margin"></i></button>
                        <?php endif; ?>
                        <?php if ($action == "view-bill"): ?>
                        <input disabled id="nombre" type="text" class="form-control" value="<?=$viewBillData["nombre"]?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Dirección:</span>
                        <?php if ($action == "view-bill"): ?>
                        <input disabled id="direccion" type="text" class="form-control" value="<?=$viewBillData["direccion"]?>">
                        <?php else: ?>
                        <input disabled id="direccion" type="text" class="form-control">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-3 col-xl-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text">CP:</span>
                        <?php if ($action == "view-bill"): ?>
                        <input disabled id="cp" type="text" class="form-control" value="<?=$viewBillData["cp"]?>">
                        <?php else: ?>
                        <input disabled id="cp" type="text" class="form-control">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Ciudad:</span>
                        <?php if ($action == "view-bill"): ?>
                        <input disabled id="localidad" type="text" class="form-control" value="<?=$viewBillData["localidad"]?>">
                        <?php else: ?>
                        <input disabled id="localidad" type="text" class="form-control">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <hr>
    <?php if ($action != "view-bill"): ?>
    <div class="my-btn-group">
        <button id="NewBtn" class="btn my-button" data-bs-toggle="modal" data-bs-target="#newConceptModal"><i class="bi bi-plus-circle"></i>Nuevo</button>
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
                <?php if ($action == "view-bill"):?>
                    <?php foreach($viewBillData["conceptos"] as $concepto):?>
                    <tr>
                        <td><?=$concepto["cantidad"]?></td>
                        <td><?=$concepto["descripcion"]?></td>
                        <td><?=$fmt->formatCurrency($concepto["precio"], "EUR")?></td>
                        <td><?=$fmt->formatCurrency($concepto["iva"], "EUR")?></td>
                        <td><?=$fmt->formatCurrency($concepto["total"], "EUR")?></td>
                    </tr>
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
                <?php if($action == "view-bill"): ?>
                <p id="base-imponible"><?=$fmt->formatCurrency($viewBillData["imponible"], "EUR")?></p>
                <p id="total-iva"><?=$fmt->formatCurrency($viewBillData["iva"], "EUR")?></p>
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
        <?php if ($action == "view-bill"): ?>
        <textarea disabled class="form-control" id="observaciones" rows="3"><?=$viewBillData["observaciones"]?></textarea>
        <?php else: ?>
        <textarea class="form-control" id="observaciones" rows="3">No se admiten devoluciones (consultar condiciones).</textarea>
        <?php endif; ?>
    </div>

    <?php if ($action == "new-bill" || $action == "new-budget" || $action == "rectify-bill"): ?>
    <div class="my-button-group mt-4 mb-5 float-end">
        <button id="cancelBtn" class="btn my-button-2"><i class="bi bi-x-square"></i>Cancelar</button>
        <button disabled id="SaveBtn" class="btn my-button-3"><i class="bi bi-save"></i>Guardar</button>
        <button disabled id="SavePrintBtn" class="btn my-button-4"><i class="bi bi-printer"></i>Guardar e imprimir</button>
    </div>
    <?php endif; ?>
    <?php if ($action == "view-bill"): ?>
    <div class="my-button-group mt-4 mb-5 float-end">
        <button id="cancelBtn" class="btn my-button-2"><i class="bi bi-x-square"></i>Cancelar</button>
        <button id="SavePrintBtn" class="btn my-button-4"><i class="bi bi-printer"></i>imprimir</button>
    </div>
    <?php endif; ?>

</div>

<?php if ($action = "new-bill" || $action = "new-budget" || $action = "rectify-bill"): ?>
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
        <label for="descripcion">Descripción:</label>
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
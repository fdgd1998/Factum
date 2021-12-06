<h1><?=$_GET["page"] == "new-bill" ? "Nueva factura":"Nuevo prespuesto"?></h1>
<div class="content">
    <div class="row">
        <div class="col-12 col-md-5 col-lg-4">
            <p>Datos <?=$_GET["page"] == "new-bill" ? "de la factura":"del prespuesto"?></p>
            <?php if ($_GET["page"] == "new-bill"):?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="forma-pago">Serie: </label>
                <select class="form-select" id="forma-pago">
                    <option selected>Seleccionar...</option>
                    <option value="1">Serie 1</option>
                    <option value="2">Serie 2</option>
                </select>
            </div>
            <?php endif; ?>
            <div class="input-group mb-3">
                <span class="input-group-text">Número:</span>
                <input disabled id="numero" type="text" class="form-control">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Fecha:</span>
                <input id="fecha" type="date" class="form-control">
            </div>
            <?php if ($_GET["page"] == "new-bill"):?>

            <div class="input-group mb-3">
                <span class="input-group-text">Factura con IVA:</span>
                <input disabled id="tiene-iva" type="text" class="form-control" value="Sí">
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="forma-pago">Forma de pago: </label>
                <select class="form-select" id="forma-pago">
                    <option selected value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia bancaria</option>
                </select>
            </div>
            <?php else: ?>
            <div class="input-group mb-3">
                <label class="input-group-text" for="presupuesto-iva">Presupuesto con IVA: </label>
                <select class="form-select" id="presupuesto-iva">
                    <option selected value="si">Sí</option>
                    <option value="no">No</option>
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
                        <input disabled id="nif" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="input-group mb-3" colspan="4">
                        <span class="input-group-text">Nombre:</span>
                        <input disabled id="nombre" type="text" class="form-control">
                        <button class="input-group-text my-button" id="nif-letter" data-bs-toggle="modal" data-bs-target="#clientSearchModal"><i class="bi bi-search no-margin"></i></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Dirección:</span>
                        <input disabled id="direccion" type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-3 col-xl-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text">CP:</span>
                        <input disabled id="numero" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Ciudad:</span>
                        <input disabled id="numero" type="text" class="form-control">
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <hr>
    <div class="my-btn-group">
        <button id="NewBtn" class="btn my-button" data-bs-toggle="modal" data-bs-target="#newConceptModal"><i class="bi bi-plus-circle"></i>Nuevo</button>
        <button disabled id="EditBtn" class="btn my-button-3" data-bs-toggle="modal" data-bs-target="#editConceptModal"><i class="bi bi-pencil"></i>Editar</button>
        <button disabled id="DeleteBtn" class="btn my-button-2"><i class="bi bi-x-circle"></i>Borrar</button>
    </div>
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
                <p id="base-imponible">--</p>
                <p id="total-iva">--</p>
                <strong><p id="total-factura">--</p></strong>
            </div>
        </div>
    </div>
    <hr>
    <div class="mb-3">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea class="form-control" id="observaciones" rows="3"></textarea>
    </div>
    <div class="my-button-group mt-4 mb-5 float-end">
        <button id="cancelBtn" class="btn my-button-2"><i class="bi bi-x-square"></i>Cancelar</button>
        <button disabled id="SaveBtn" class="btn my-button-3"><i class="bi bi-save"></i>Guardar</button>
        <button disabled id="SavePrintBtn" class="btn my-button-4"><i class="bi bi-printer"></i>Guardar e imprimir</button>
    </div>
</div>

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
        <button disabled id="conceptCreateBtn" type="button" class="btn my-button-3">Guardar</button>
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
        <button disabled id="conceptEditBtn" type="button" class="btn my-button-3">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Clients search and choose -->
<div class="modal fade" id="clientSearchModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newConceptLabel">Buscar cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table id="dTableClients" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th width="10%">NIF</th>
                    <th width="30%">Nombre</th>
                    <th width="30%">Dirección</th>
                    <th width="10%">CP</th>
                    <th width="20%">Localidad</th>
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
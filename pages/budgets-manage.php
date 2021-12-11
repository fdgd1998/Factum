<h1 class="title">Presupuestos</h1>
<div class="my-btn-group">
    <button id="NewBtn" class="btn my-button"><i class="bi bi-plus-square"></i>Nuevo presupuesto</button>
    <span class="button-spacing"></span>
    <button disabled id="EditBtn" class="btn my-button-3"><i class="bi bi-pencil-square"></i>Editar</button>
    <button disabled id="DeleteBtn" class="btn my-button-2" data-bs-toggle="modal" data-bs-target="#deleteBudgetModal"><i class="bi bi-trash"></i>Borrar</button>
    <button disabled id="PrintBtn" class="btn my-button-4"><i class="bi bi-printer"></i>Imprimir</button>
</div>
<table id="dTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th width="10%">ID</th>
            <th width="10%">Fecha</th>
            <th width="15%">NIF cliente</th>
            <th width="55%">Nombre cliente</th>
            <th width="20%">Total</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="modal fade" id="deleteBudgetModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteBudgetLabel">Borrar presupuesto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>¿Quieres borrar este presupuesto?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn my-button" data-bs-dismiss="modal">Cerrar</button>
        <button id="deleteBudgetBtn" type="button" class="btn my-button-2"><i class="bi bi-trash"></i>Borrar</button>
      </div>
    </div>
  </div>
</div>
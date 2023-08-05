<h2 class="title">Clientes</h2>
<div class="my-btn-group">
    <button id="NewBtn" class="btn my-button"><i class="bi bi-person-add"></i>Nuevo cliente</button>
    <span class="button-spacing"></span>
    <button disabled id="EditBtn" class="btn my-button-3"><i class="bi bi-person-gear"></i>Editar</button>
    <button disabled id="DeleteBtn" data-bs-toggle="modal" data-bs-target="#deleteClientModal" class="btn my-button-2"><i class="bi bi-person-x"></i>Borrar</button>
</div>
<table id="dTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th width="10%">NIF</th>
            <th width="30%">Nombre</th>
            <th width="5%">CP</th>
            <th width="20%">Localidad</th>
            <th width="13%">Teléfono</th>
            <th width="22%">Email</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="modal fade" id="deleteClientModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteClientLabel">Borrar cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>¿Quieres borrar este cliente?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn my-button" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>Cerrar</button>
        <button id="deleteClientBtn" type="button" class="btn my-button-2"><i class="bi bi-trash"></i>Borrar</button>
      </div>
    </div>
  </div>
</div>
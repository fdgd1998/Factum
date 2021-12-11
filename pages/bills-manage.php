<h1><?=$_GET["page"] == "bills"?"Facturas ordinarias":"Facturas rectificativas"?></h1>
<div class="my-btn-group">
    <button id="<?=$_GET["page"] == "bills" ? "NewBtn":"NewRecBtn"?>" class="btn my-button"><i class="bi bi-plus-square"></i>Nueva factura</button>

    <span class="button-spacing"></span>
    <button disabled id="ViewBtn" class="btn my-button-3"><i class="bi bi-eye"></i>Ver</button>
    <button disabled id="PrintBtn" class="btn my-button-4"><i class="bi bi-printer"></i>Imprimir</button>
</div>
<table id="dTable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th width="10%">Número</th>
            <?php if ($_GET["page"] == "rbills"):?>
            <th>Referencia</th>
            <?php endif; ?>
            <th width="10%">Fecha</th>
            <th width="15%">NIF cliente</th>
            <th width="45%">Nombre cliente</th>
            <th width="20%">Total</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
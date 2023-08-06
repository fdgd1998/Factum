<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/php/check_url_direct_access.php";
    checkUrlDirectAcces(realpath(__FILE__), realpath($_SERVER['SCRIPT_FILENAME']));
?>
<?php if($_GET["page"] == "archive"): ?>
    <?php if(!isset($_GET["group"]) || $_GET["group"] == "all"): ?>
    <script>seleccion = "select numero, fecha, nif, nombre, total from facturas_archivo union select  numero, fecha, nif, nombre, total from facturasrec_archivo"</script>
    <?php else: ?>
    <script>seleccion = "select numero, fecha, nif, nombre, total from facturas_archivo where grupo = '<?=$_GET["group"]?>' union select  numero, fecha, nif, nombre, total from facturasrec_archivo where grupo = '<?=$_GET["group"]?>'"</script>
    <?php endif; ?>
<?php endif; ?>
<?php
    switch ($_GET["page"]) {
        case "bills":
            echo "<h2>Facturas ordinarias</h2>";
            break;
        case "rbills":
            echo "<h2>Facturas rectificativas</h2>";
            break;
        case "archive":
            echo "<h2>Archivo</h2>";
            echo "<p>Aquí puedes ver e imprimir todas las facturas archivadas.<p>";
            break;
    }

    echo "<script>action='".$_GET["page"]."'; console.log('action: '+action)</script>";

    require_once $_SERVER["DOCUMENT_ROOT"]."/classes/php/Database.php";

    $conn =  new DatabaseConnection();
    $conn->Connect();

    $groups = $conn->Select("select distinct grupo from facturas_archivo union select distinct grupo from facturasrec_archivo");
    $conn->Close();

?>
<div class="my-btn-group">
    <?php if($_GET["page"] != "archive"): ?>
    <button id="<?=$_GET["page"] == "bills" ? "NewBtn":"NewRecBtn"?>" class="btn my-button"><i class="bi bi-plus-circle"></i>Nueva factura</button>
    <span class="button-spacing"></span>
    <?php endif; ?>
    
    <button disabled id="ViewBtn" class="btn my-button-5"><i class="bi bi-eye"></i>Ver</button>
    <?php if($_GET["page"] != "archive"): ?>
    <button disabled id="EditBtn" class="btn my-button-3"><i class="bi bi-pencil"></i>Editar</button>
    <?php endif; ?>
    <button disabled id="PrintBtn" class="btn my-button-4"><i class="bi bi-printer"></i>Imprimir</button>
</div>

<?php if($_GET["page"] == "archive"): ?>
<div clas="row">
    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
        <div class="input-group mb-3">
            <label class="input-group-text" for="archive-groups">Ver grupo:</label>
            <select class="form-select" id="archive-groups">
                <?php if(!isset($_GET["group"]) || $_GET["group"] == "all"): ?>
                <option value="all" selected>Todos</option>
                <?php else: ?>
                <option value="all">Todos</option>
                <?php endif; ?>
                <?php foreach($groups as $group): ?>
                    <option value="<?=$group["grupo"]?>" <?=$group["grupo"] === $_GET["group"]?"selected":""?>><?=$group["grupo"]?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<?php endif; ?>

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
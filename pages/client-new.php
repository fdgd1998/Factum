<?php
    if (isset($_GET["id"])) {
        require_once "scripts/php/db_functions.php";
        $userData = SelectFromDb("select * from clientes where nif='".$_GET["id"]."'")[0];
    }
?>
<h1><?=$_GET["page"] == "edit-client"?"Editar":"Nuevo"?> cliente</h1>
<div class="content">
    <p>Datos personales</p>
    <div class="row">
        <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-4">
            <div class="input-group mb-3">
                <input disabled type="text" class="form-control" value="NIF/CIF/NIE">
                <?php if ($_GET["page"]=="edit-client"):?>
                <input disabled type="text" class="form-control" value="<?=$userData["nif"]?>">
                <?php else: ?>
                <input id="nif" type="text" class="form-control">
                <?php endif; ?>
                <div id="nif-feedback" class="invalid-feedback">
                    Introduce un CIF/NIF/NIE correcto.
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-8 col-xl-8">
            <div class="input-group mb-3">
                <span class="input-group-text">Nombre:</span>
                <?php if ($_GET["page"]=="edit-client"):?>
                <input id="nombre" type="text" class="form-control is-valid" value="<?=$userData["nombre"]?>">
                <?php else: ?>
                <input id="nombre" type="text" class="form-control">
                <?php endif; ?>
                <div class="invalid-feedback">
                    El nombre no puede estar vacío.
                </div>
            </div>
        </div>
    </div>
    <hr>
    <p>Domicilio</p>
    <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <span class="input-group-text">Dirección:</span>
                <?php if ($_GET["page"]=="edit-client"):?>
                <input id="direccion" type="text" class="form-control is-valid" value="<?=$userData["direccion"]?>">
                <?php else: ?>
                <input id="direccion" type="text" class="form-control">
                <?php endif; ?>
                <div class="invalid-feedback">
                    La dirección no puede estar vacía.
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
            <div class="input-group mb-3">
                <span class="input-group-text">CP:</span>
                <?php if ($_GET["page"]=="edit-client"):?>
                <input id="cp" type="number" step="1" min="11111" max="99999" class="form-control is-valid" value="<?=$userData["cp"]?>">
                <?php else: ?>
                <input id="cp" type="number" step="1" min="11111" max="99999" class="form-control">
                <?php endif; ?>
                <div class="invalid-feedback">
                    Introduce un CP correcto.
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
            <div class="input-group mb-3">
                <span class="input-group-text">Localidad:</span>
                <?php if ($_GET["page"]=="edit-client"):?>
                <input id="localidad" type="text" class="form-control is-valid" value="<?=$userData["localidad"]?>">
                <?php else: ?>
                <input id="localidad" type="text" class="form-control">
                <?php endif; ?>
                <div class="invalid-feedback">
                    La localidad no puede estar vacía.
                </div>
            </div>
        </div>
    </div>
    <hr>
    <p>Datos de contacto (opcional)</p>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-3">
            <div class="input-group mb-3">
                <span class="input-group-text">Teléfono:</span>
                <?php if ($_GET["page"]=="edit-client"):?>
                <input id="telefono" type="text" class="form-control" value="<?=$userData["telefono"]?>">
                <?php else: ?>
                <input id="telefono" type="text" class="form-control">
                <?php endif; ?>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Email:</span>
                <?php if ($_GET["page"]=="edit-client"):?>
                <input id="email" type="email" class="form-control" value="<?=$userData["email"]?>">
                <?php else: ?>
                <input id="email" type="email" class="form-control">
                <?php endif; ?>
                <div class="invalid-feedback">
                    Introduce un email válido.
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <button id="cancelBtn" type="button" class="btn my-button-2"><i class="bi bi-x-square"></i>Cancelar</button>
        <button <?=$_GET["page"]=="edit-client"?"":"disabled"?> id="<?=$_GET["page"]=="edit-client"?"editBtn":"createBtn"?>" type="button" class="btn my-button-3"><i class="bi bi-save"></i>Guardar</button>
    </div>
</div>
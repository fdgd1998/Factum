<div class="content">
    <h1>Descargar y archivar facturas</h1>
    <br><p>Desde esta página podrás descargar todas las facturas dentro de un rango de fechas dado en un fichero zip, o bien archivarlas.</p><br>
    <p>Selecciona un rango:</p>
    <div class="row">
        <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-3">
            <div class="input-group mb-3">
                <span class="input-group-text">Desde:</span>
                <input id="fecha-i" type="date" class="form-control">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Hasta:</span>
                <input id="fecha-f" type="date" class="form-control">
            </div>
        </div>
    </div>
    <br><p>Selecciona una opción:</p>
    <div class="row">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="download-rbtn" checked>
                <label class="form-check-label" for="flexRadioDefault1">
                    Sólo descargar
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="archive-rbtn">
                <label class="form-check-label" for="flexRadioDefault1">
                    Sólo archivar
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="options" id="both-rbtn">
                <label class="form-check-label" for="flexRadioDefault2">
                    Archivar y descargar
                </label>
            </div>
            <div class="input-group mb-3 mt-3">
                <span class="input-group-text" id="basic-addon1">Nombre del grupo:</span>
                <input type="text" class="form-control" id="group-name" disabled>
            </div>
        </div>
    </div>
    <button disabled id="submitBtn" type="button" class="btn my-button-3 mt-4">Aceptar</button>
</div>
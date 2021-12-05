<h1>Nuevo cliente</h1>
<div class="content">
    <p>Datos personales</p>
    <div class="row">
        <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-3">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">NIF (sin letra):</span>
                <input id="nif" type="number" step="1" min="11111111" max="99999999" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                <span class="input-group-text" id="nif-letter">--</span>
                <div class="invalid-feedback">
                    Introduce un NIF correcto.
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-8 col-xl-9">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Nombre:</span>
                <input id="nombre" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
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
                <span class="input-group-text" id="inputGroup-sizing-default">Dirección:</span>
                <input id="direccion" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                <div class="invalid-feedback">
                    La dirección no puede estar vacía.
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3 col-lg-2 col-xl-2">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">CP:</span>
                <input id="cp" type="number" step="1" min="11111" max="99999" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                <div class="invalid-feedback">
                    Introduce un CP correcto.
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Localidad:</span>
                <input id="localidad" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                <div class="invalid-feedback">
                    La localidad no puede estar vacía.
                </div>
            </div>
        </div>
    </div>
    <hr>
    <p>Datos de contacto</p>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-6 col-lg-5 col-xl-3">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Teléfono:</span>
                <input id="telefono" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-default">Email:</span>
                <input id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" type="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                <div class="invalid-feedback">
                    Introduce un email válido.
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <button id="cancelBtn" type="button" class="btn my-button-2">Cancelar</button>
        <button id="createBtn" type="button" class="btn my-button-3" disabled>Guardar</button>
    </div>
</div>
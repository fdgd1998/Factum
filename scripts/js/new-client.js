function isIDValid (isValid, type) {
    console.log();
    if (isValid) {
        $("#nif").addClass("is-valid");
        $("#nif").removeClass("is-invalid");
    } else {
        $("#nif-feedback").html("Introduce un "+(type=="nif"?"NIF":"CIF")+" válido.");
        $("#nif").addClass("is-invalid");
        $("#nif").removeClass("is-valid");
    }
}

function EnableCreateBtn () {
    var totalInputs = 0;
    var emailValid = 1;
    if ($("#nif").hasClass("is-valid")) totalInputs++;
    if ($("#nombre").hasClass("is-valid")) totalInputs++;
    if ($("#direccion").hasClass("is-valid")) totalInputs++;
    if ($("#cp").hasClass("is-valid")) totalInputs++;
    if ($("#localidad").hasClass("is-valid")) totalInputs++;
    if ($("#email").hasClass("is-invalid")) emailValid = 0;
    if (totalInputs == 5 && emailValid) $("#createBtn").removeAttr("disabled");
    else $("#createBtn").attr("disabled", "disabled");
}

function EnableEditBtn () {
    var totalInputs = 0;
    var emailValid = 1;
    if ($("#nombre").hasClass("is-valid")) totalInputs++;
    if ($("#direccion").hasClass("is-valid")) totalInputs++;
    if ($("#cp").hasClass("is-valid")) totalInputs++;
    if ($("#localidad").hasClass("is-valid")) totalInputs++;
    if ($("#email").hasClass("is-invalid")) emailValid = 0;
    if (totalInputs == 4 && emailValid) $("#editBtn").removeAttr("disabled");
    else $("#editBtn").attr("disabled", "disabled");
}

function validateID() {
    if ($("#nif").siblings("select").find(":selected").val() == "nif") {
        isIDValid(isValidNif($("#nif").val()), "nif");
    } else {
        isIDValid(isValidCif($("#nif").val()), "cif");
    }
    EnableCreateBtn();
}

$(document).ready(function() {
    $("#id-select").on("change",function(){
        validateID();
    })
    $("#nif").on("keyup", function() {
        validateID();
    })

    $("#nombre, #direccion, #localidad").on("keyup", function() {
        var nombre = $.trim($(this).val());
        if (nombre != "") {
            $(this).addClass("is-valid");
            $(this).removeClass("is-invalid");
        } else {
            $(this).addClass("is-invalid");
            $(this).removeClass("is-valid");
        }
        EnableCreateBtn();
    })

    $("#email").on("keyup", function() {
        if (EsEmail($.trim($(this).val()))) {
            $(this).addClass("is-valid");
            $(this).removeClass("is-invalid");
        } else {
            $(this).addClass("is-invalid");
            $(this).removeClass("is-valid");
        }

        if ($(this).val() == "") {
            $(this).removeClass("is-invalid");
            $(this).removeClass("is-valid");
        }
        EnableCreateBtn();
    })

    $("#cp").on("keyup", function() {
        var cp = $(this).val();
        if (cp.indexOf(' ') == -1 && cp != "" && cp.length == 5) {
            $("#cp").addClass("is-valid");
            $("#cp").removeClass("is-invalid");
        } else {
            $("#cp").addClass("is-invalid");
            $("#cp").addClass("is-valid");
        }
        EnableCreateBtn();
    })

    $("#cancelBtn").on("click", function() {
        window.location.href = "?page=clients";
    })

    $("#createBtn").on("click", function() {
        var formData = new FormData();
        formData.append("nif", $("#nif").val());
        formData.append("nombre", $("#nombre").val());
        formData.append("direccion", $("#direccion").val());
        formData.append("cp", $("#cp").val());
        formData.append("localidad", $("#localidad").val());
        formData.append("telefono", $("#telefono").val() != ""?$("#telefono").val():"");
        formData.append("email", $("#email").val() != ""?$("#email").val():"");
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }
        $.ajax({
            url: "scripts/php/insert_new_client.php", // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location.href = "?page=clients";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
                // HideSpinner();
            }
        });
    })

    $("#editBtn").on("click", function() {
        var formData = new FormData();
        formData.append("nif", $("#nif").val());
        formData.append("nombre", $("#nombre").val());
        formData.append("direccion", $("#direccion").val());
        formData.append("cp", $("#cp").val());
        formData.append("localidad", $("#localidad").val());
        formData.append("telefono", $("#telefono").val() != ""?$("#telefono").val():"");
        formData.append("email", $("#email").val() != ""?$("#email").val():"");
        for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }
        $.ajax({
            url: "scripts/php/update_client.php", // this is the target
            type: 'post', // method
            dataType: 'text',
            cache: false,
            data: formData, // pass the input value to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location.href = "?page=clients";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
                // HideSpinner();
            }
        });
    })
})
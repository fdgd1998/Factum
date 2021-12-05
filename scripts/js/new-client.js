var letras = ["T", "R", "W", "A", "G", "M", "Y", "F", "P", "D", "X", "B", "N", "J", "Z", "S", "Q", "V", "H", "L", "C", "K", "E"];
function GetNifLetter (nif) {
    var rest = nif%23;
    return letras[rest];
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

$(document).ready(function() {
    $("#nif").on("keyup", function() {
        // $(this).val(this.value.match(/[0-9]*/));
        var nifNumber = $(this).val();
        if (nifNumber.indexOf(' ') == -1 && nifNumber != "" && nifNumber.length == 8) {
            $("#nif-letter").html(GetNifLetter(parseInt(nifNumber)));
            $("#nif").addClass("is-valid");
            $("#nif").removeClass("is-invalid");
        } else {
            $("#nif-letter").html("--");
            $("#nif").addClass("is-invalid");
            $("#nif").removeClass("is-valid");
        }
        EnableCreateBtn();
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
        if (/^([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4})$/.test($.trim($(this).val()))) {
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
})
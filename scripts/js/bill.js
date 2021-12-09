var options = {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
}

var editingRowIdN = 0;

var tiene_iva = 1;

var total_global = 0;
var iva_global = 0;
var imponible_global = 0;

var conceptsArr = [];

var iva_concepto= 0;
var cantidad = 0;
var precioUnitario_concepto = 0;
var total_concepto = 0;
var descripcion = "";

function addToTable(concept, index) {
    dTable.row.add( [
        concept.cantidad,
        concept.descripcion,
        new Intl.NumberFormat("es-ES", options).format(concept.precio),
        tiene_iva == 1 ? new Intl.NumberFormat("es-ES", options).format(concept.iva):"--",
        new Intl.NumberFormat("es-ES", options).format(concept.total)
    ] ).node().id = "concept"+index;
    dTable.draw();
    // console.log("new concept added: array "+objectIndex)
    // console.log(conceptsArr);
}

function reloadConcepts() {
    dTable.clear().draw();
    $.each(conceptsArr, function (index, value) {
        addToTable(value, index)
    })
}

function removeFromTable(selectedRow, id) {
    dTable.row(selectedRow).remove().draw();
    conceptsArr.splice(id, 1);
    console.log(conceptsArr);
    $("#dTable tbody tr").each(function(i, obj){
        console.log(obj);
        $(obj).attr("id","concept"+i);
    });
    console.log(conceptsArr);
    updateTotalPrices();
}

function updateTotalPrices () {
    total_global = 0;
    iva_global = 0;
    imponible_global = 0;

    conceptsArr.forEach(concept => {
        total_global = total_global + concept.total;
        if (tiene_iva == 1) iva_global = iva_global + concept.iva*concept.cantidad;
        imponible_global = imponible_global + concept.precio*concept.cantidad;
    })

    $("#base-imponible").html(new Intl.NumberFormat("es-ES", options).format(imponible_global));
    $("#total-iva").html(tiene_iva == 1 ? new Intl.NumberFormat("es-ES", options).format(iva_global):"--");
    $("#total-factura").html(new Intl.NumberFormat("es-ES", options).format(total_global));
}

function CleanModalAndData() {
    $("#cantidad").val("");
    $("#precio-unitario").val("");
    $("#descripcion").val("");
    $("#concepto-iva").html("--");
    $("#concepto-total").html("--");
    $("#conceptCreateBtn").attr("disabled", "disabled");
    iva_concepto = 0;
    cantidad = 0;
    precioUnitario_concepto = 0;
    total_concepto = 0;
}

function UpdateConceptsIva() {
    if (tiene_iva == 1) {
        conceptsArr.forEach(concept => {
            concept.iva = concept.precio*0.21;
            concept.total = concept.cantidad*(concept.precio + concept.iva)
        })
    } else {
        conceptsArr.forEach(concept => {
            concept.iva = 0;
            concept.total = concept.cantidad*concept.precio;
        })
        $("#concepto-iva-edit").html("--");
        $("#concepto-iva").html("--");
    }
    reloadConcepts();
    // UpdatePrice("new");
    updateTotalPrices();

    $("#EditBtn").attr("disabled","disabled");
    $("#DeleteBtn").attr("disabled","disabled");
}

function EnableNewConceptBtn() {
    var total_inputs = 0;
    if ($("#precio-unitario").hasClass("is-valid")) total_inputs++;
    if ($("#cantidad").hasClass("is-valid")) total_inputs++;
    if ($("#descripcion").val() != "") total_inputs++;
    if (total_inputs == 3 ) $("#conceptCreateBtn").removeAttr("disabled");
    else $("#conceptCreateBtn").attr("disabled", "disabled");
}

function EnableEditConceptBtn() {
    var total_inputs = 0;
    if ($("#precio-unitario-edit").hasClass("is-valid")) total_inputs++;
    if ($("#cantidad-edit").hasClass("is-valid")) total_inputs++;
    if ($("#descripcion-edit").val() != "") total_inputs++;
    if (total_inputs == 3 ) $("#conceptEditBtn").removeAttr("disabled");
    else $("#conceptEditBtn").attr("disabled", "disabled");
}

function UpdatePrice(action) {
    if (action == "new") {
        precioUnitario_concepto = parseFloat($("#precio-unitario").val());
        cantidad = parseInt($("#cantidad").val());
        if (tiene_iva == 1) iva_concepto = precioUnitario_concepto*0.21;
        total_concepto = (iva_concepto + precioUnitario_concepto)*cantidad;
        if (tiene_iva == 1) $("#concepto-iva").html(new Intl.NumberFormat("es-ES", options).format(iva_concepto*cantidad));
        $("#concepto-total").html(new Intl.NumberFormat("es-ES", options).format(total_concepto));
    } else if (action == "edit") {
        precioUnitario_concepto = parseFloat($("#precio-unitario-edit").val());
        cantidad = parseInt($("#cantidad-edit").val());

        if (tiene_iva == 1) iva_concepto = precioUnitario_concepto*0.21;
        else iva_concepto = 0;
        
        total_concepto = (iva_concepto + precioUnitario_concepto)*cantidad;
        if (tiene_iva == 1) $("#concepto-iva-edit").html(new Intl.NumberFormat("es-ES", options).format(iva_concepto*cantidad));
        $("#concepto-total-edit").html(new Intl.NumberFormat("es-ES", options).format(total_concepto));
    }
}

function enableSaveBtn() {
    var total_data = 0;
    if ($("#numero").val() != "") total_data++;
    if ($("#nif").val() != "") total_data++;
    if ($("#fecha").val() != "") total_data++;
    console.log("conceptsArr.length: "+conceptsArr.length)
    if (conceptsArr.length > 0) total_data++;
    if (total_data == 4) {
        $("#SaveBtn").removeAttr("disabled");
        $("#SavePrintBtn").removeAttr("disabled");
    } else {
        $("#SaveBtn").attr("disabled","disabled");
        $("#SavePrintBtn").attr("disabled","disabled");
    }
}

$(document).ready(function() {
    $("#cantidad, #precio-unitario").on("change, keyup", function() {
        if ($(this).attr("id") == "cantidad") {
            if (/^[0-9]*[^.]$/.test($(this).val())) {
                $(this).addClass("is-valid");
                $(this).removeClass("is-invalid");
            } else {
                $(this).addClass("is-invalid");
                $(this).removeClass("is-valid");
            }
        } else {
            // if (/[\d\.]/g.test($(this).val())) {
            if (/^([0-9]*)+\.?\d{1,2}$/.test($(this).val())) {
                $(this).addClass("is-valid");
                $(this).removeClass("is-invalid");
            } else {
                $(this).addClass("is-invalid");
                $(this).removeClass("is-valid");
            }
        }
        if ($("#cantidad").hasClass("is-valid") && $("#precio-unitario").hasClass("is-valid")) {
            UpdatePrice("new");
            EnableNewConceptBtn();
        } else {
            $("#concepto-iva").html("--");
            $("#concepto-total").html("--");
            EnableNewConceptBtn();
        }
    })

    $("#cantidad-edit, #precio-unitario-edit").on("change, keyup", function() {
        if ($(this).attr("id") == "cantidad-edit") {
            if (/^[0-9]*[^.]$/.test($(this).val())) {
                $(this).addClass("is-valid");
                $(this).removeClass("is-invalid");
            } else {
                $(this).addClass("is-invalid");
                $(this).removeClass("is-valid");
            }
        } else {
            if (/^([0-9]*)+\.?\d{1,2}$/.test($(this).val())) {
                $(this).addClass("is-valid");
                $(this).removeClass("is-invalid");
            } else {
                $(this).addClass("is-invalid");
                $(this).removeClass("is-valid");
            }
        }
        if ($("#cantidad-edit").hasClass("is-valid") && $("#precio-unitario-edit").hasClass("is-valid")) {
            UpdatePrice("edit");
            EnableEditConceptBtn();
        } else {
            $("#concepto-iva-edit").html("--");
            $("#concepto-total-edit").html("--");
            EnableEditConceptBtn();
        }
    })

    $("#descripcion").on("change, keyup", function() {
        descripcion = $(this).val();
        EnableNewConceptBtn();
    })

    $("#conceptCreateBtn").on("click", function() {
        var concept = new BillConcept(cantidad, descripcion, precioUnitario_concepto, iva_concepto);
        conceptsArr.push(concept);
        addToTable(concept, conceptsArr.indexOf(concept));
        updateTotalPrices();
        $("#newConceptModal").modal("hide");
        CleanModalAndData();
        enableSaveBtn();
    })

    $("#conceptEditBtn").on("click", function() {
        conceptsArr[editingRowIdN].cantidad = cantidad;
        conceptsArr[editingRowIdN].precio = precioUnitario_concepto;
        conceptsArr[editingRowIdN].iva = tiene_iva == 1 ? iva_concepto:0;
        conceptsArr[editingRowIdN].total = tiene_iva == 1 ? cantidad*(iva_concepto+precioUnitario_concepto):cantidad*precioUnitario_concepto;
        reloadConcepts();
        updateTotalPrices();
        $("#editConceptModal").modal("hide");
        $("#EditBtn").attr("disabled","disabled");
        $("#DeleteBtn").attr("disabled","disabled");
        CleanModalAndData();
    })

    $("#newConceptModal").on("hide.bs.modal", function() {
        $("#cantidad").removeClass("is-valid");
        $("#precio-unitario").removeClass("is-valid");
        $("#cantidad").removeClass("is-invalid");
        $("#precio-unitario").removeClass("is-invalid");
        CleanModalAndData();
    })

    $("#DeleteBtn").on("click", function(){
        var selectedRow = $("#dTable tbody").find("tr.selected");
        var rowIdN = selectedRow.attr("id").substring(7);
        removeFromTable(selectedRow, rowIdN);
        $("#EditBtn").attr("disabled", "disabled");
        $("#DeleteBtn").attr("disabled", "disabled");
        enableSaveBtn();
    })

    $("#EditBtn").on("click", function(){
        var selectedRow = $("#dTable tbody").find("tr.selected");
        editingRowIdN = selectedRow.attr("id").substring(7);
        console.log(editingRowIdN);
        var editingConcept = conceptsArr[editingRowIdN];

        cantidad = editingConcept.cantidad;
        precioUnitario_concepto = editingConcept.precio;
        descripcion = editingConcept.descripcion;

        $("#cantidad-edit").val(cantidad);
        $("#precio-unitario-edit").val(precioUnitario_concepto);
        $("#cantidad-edit").addClass("is-valid");
        $("#precio-unitario-edit").addClass("is-valid");
        $("#descripcion-edit").val(descripcion);
        UpdatePrice("edit");
        EnableEditConceptBtn();
        enableSaveBtn();
    })

    $("#presupuesto-iva").on("change", function(){
        console.log($(this).find(":selected").val());
        switch ($(this).find(":selected").val()) {
            case "si":
                tiene_iva = 1;
                console.log("tiene_iva: "+tiene_iva);
                UpdateConceptsIva();
                break;
            case "no":
                tiene_iva = 2;
                console.log("tiene_iva: "+tiene_iva);
                UpdateConceptsIva();
                break;
        }
    })

    $("#clientSearchModal").on("hide.bs.modal", function(){
        $(this).find("tbody tr.selected").removeClass("selected");
        $("#selectClientBtn").attr("disabled","disabled");
    })

    $("#selectClientBtn").on("click", function() {
        cliente = dTableClients.row(".selected").data();
        $("#nif").val(cliente.nif);
        $("#nombre").val(cliente.nombre);
        $("#direccion").val(cliente.direccion);
        $("#cp").val(cliente.cp);
        $("#localidad").val(cliente.ciudad);
        $("#clientSearchModal").find("tbody tr.selected").removeClass("selected");
        $("#selectClientBtn").attr("disabled","disabled");
        $("#clientSearchModal").modal("hide");
        enableSaveBtn();
    });

    $("#billSearchModal").on("hide.bs.modal", function(){
        $(this).find("tbody tr.selected").removeClass("selected");
        $("#selectBillBtn").attr("disabled","disabled");
    })

    $("#selectBillBtn").on("click", function() {
        bill = dTableBills.row(".selected").data();
        $("#bill-reference").val(bill.id);
        $("#billSearchModal").find("tbody tr.selected").removeClass("selected");
        $("#selectBillBtn").attr("disabled","disabled");
        $("#billSearchModal").modal("hide");
        // enableSaveBtn();
    });

    $("#cancelBtn").on("click", function(){
        window.location.href = "?page=bills";
    })

    $("#fecha").on("change", function(){
        enableSaveBtn();
    })

    function Save() {
        var formData = new FormData();
        if (action == "new-bill") {
            formData.append("numero", $("#numero").val());
            formData.append("nif", $("#nif").val());
            formData.append("fecha", new Date($("#fecha").val()).toISOString().slice(0,19).replace('T',' '));
            formData.append("formapago", $("#forma-pago").find(":selected").val());
            formData.append("conceptos", JSON.stringify(conceptsArr));
            formData.append("observaciones", $("#observaciones").val());
            formData.append("total", total_global);
            formData.append("iva", iva_global);
            formData.append("imponible", imponible_global);
            formData.append("year", new Date().getFullYear().toString().substr(-2));
            formData.append("nombre", $("#nombre").val());
            formData.append("direccion", $("#direccion").val());
            formData.append("cp", $("#cp").val());
            formData.append("localidad", $("#localidad").val());
            for (var pair of formData.entries()) {
                console.log(pair[0]+ ', ' + pair[1]); 
            }
            $.ajax({
                url: "scripts/php/insert_new_bill.php", // this is the target
                type: 'post', // method
                dataType: 'text',
                cache: false,
                data: formData, // pass the input value to serve
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                success: function(response) { // if the http response code is 200
                    alert(response);
                    window.location.href = "?page=bills";
                },
                error: function(response) { // if the http response code is other than 200
                    alert(response);
                    // HideSpinner();
                }
            });
        }   
    }

    $("#SaveBtn").on("click", function(){
        Save();
    });

    $("#SavePrintBtn").on("click", function() {
        Save();
        window.location.href = "scripts/factura/factura.php?numero="+$("#numero").val();
    });

    $("#PrintBtn").on("click", function() {
        window.location.href = "scripts/factura/factura.php?numero="+$("#numero").val();
    });
})
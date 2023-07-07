var options = {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
}

var regexpPPositive = /^([0-9]*)+\.?\d{1,2}$/;
var regexpPNegative = /^(\-?[0-9]*)+\.?\d{1,2}$/;

var editingRowIdN = 0;
var tiene_iva = 1;

var total_global;
var iva_global;
var imponible_global;

var conceptsArr = [];

var iva_concepto;
var cantidad;
var precioUnitario_concepto;
var total_concepto;
var descripcion;
var descripcion_edit;

var reload = true;

function addToTable(concept, index) {
    dTable.row.add( [
        concept.cantidad,
        concept.descripcion,
        new Intl.NumberFormat("es-ES", options).format(concept.precio),
        tiene_iva == 1 ? new Intl.NumberFormat("es-ES", options).format(concept.iva):"--",
        new Intl.NumberFormat("es-ES", options).format(concept.total)
    ] ).node().id = "concept"+index;
    dTable.draw();
}

function reloadConcepts() {
    dTable.clear().draw();
    
    $.each(conceptsArr, function (index, value) {
        console.log(value.iva + ", " +index);
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
        total_global = parseFloat((total_global + concept.total).toFixed(2));
        if (tiene_iva == 1) iva_global = parseFloat((iva_global + concept.iva*concept.cantidad).toFixed(2));
        imponible_global += parseFloat((concept.precio*concept.cantidad).toFixed(2));
    })

    $("#base-imponible").html(new Intl.NumberFormat("es-ES", options).format(imponible_global));
    $("#total-iva").html(tiene_iva == 1 ? new Intl.NumberFormat("es-ES", options).format(iva_global):"--");
    $("#total-factura").html(new Intl.NumberFormat("es-ES", options).format(total_global));
}

function CleanModalAndData() {
    $("#cantidad").val("");
    $("#precio-unitario").val("");
    $("#descripcion").val("");
    $("#descripcion-edit").val("");
    $("#concepto-iva").html("--");
    $("#concepto-total").html("--");
    $("#conceptCreateBtn").attr("disabled", "disabled");
    iva_concepto = 0;
    cantidad = 0;
    precioUnitario_concepto = 0;
    total_concepto = 0;
    descripcion = "";
    descripcion_edit = "";
}

function UpdateConceptsIva() {
    if (tiene_iva == 1) {
        conceptsArr.forEach(concept => {
            concept.iva = parseFloat((concept.precio*0.21).toFixed(2));
            concept.total = parseFloat((concept.cantidad*(concept.precio + concept.iva)).toFixed(2));
        })
    } else {
        conceptsArr.forEach(concept => {
            concept.iva = 0;
            concept.total = parseFloat((concept.cantidad*concept.precio).toFixed(2));
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

        if (tiene_iva == 1) iva_concepto = parseFloat((parseFloat(precioUnitario_concepto)*0.21).toFixed(2));
        else iva_concepto = 0;

        total_concepto = parseFloat(((parseFloat(iva_concepto) + parseFloat(precioUnitario_concepto))*cantidad).toFixed(2));

        if (tiene_iva == 1) $("#concepto-iva").html(new Intl.NumberFormat("es-ES", options).format(iva_concepto*cantidad));
        else $("#concepto-iva").html(new Intl.NumberFormat("es-ES", options).format(iva_concepto*cantidad));
        $("#concepto-total").html(new Intl.NumberFormat("es-ES", options).format(total_concepto));
    } else if (action == "edit") {
        precioUnitario_concepto = parseFloat($("#precio-unitario-edit").val());
        cantidad = parseInt($("#cantidad-edit").val());

        if (tiene_iva == 1) iva_concepto = parseFloat((parseFloat(precioUnitario_concepto)*0.21).toFixed(2));
        else iva_concepto = 0;
        
        total_concepto = parseFloat(((parseFloat(iva_concepto) + parseFloat(precioUnitario_concepto))*cantidad).toFixed(2));
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
    if (action == "edit-budget" || action == "edit-bill" || action == "new-bill-from-budget") {
        $("#dTable tbody tr").each(function(){
            cantidad = $(this).find(".cantidad").html();
            descripcion = $(this).find(".descripcion").html();
            precio = $(this).find(".precio").html().slice(0, -7).replace(',','.');
            console.log(precio);
            iva = $(this).find(".iva").html() == "--" ? 0.00 : $(this).find(".iva").html().slice(0, -7).replace(',','.');
            console.log("iva: "+parseFloat(iva));
            total = $(this).find(".total").html().slice(0, -7).replace(',','.');
            conceptsArr.push(new BillConcept(parseInt(cantidad), descripcion, parseFloat(precio), parseFloat(iva), parseFloat(total)));
            console.log(conceptsArr);
        });
    }
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
            if ((action=="rectify-bill"?regexpPNegative:regexpPPositive).test($(this).val())) {
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

    $("#descripcion-edit").on("keyup", function() {
        //descripcion_edit = $(this).val();
        EnableEditConceptBtn();
    })

    $("#conceptCreateBtn").on("click", function() {
        var concept = new BillConcept(cantidad, descripcion, precioUnitario_concepto, iva_concepto);
        conceptsArr.push(concept);
        console.log(conceptsArr);
        addToTable(concept, conceptsArr.indexOf(concept));
        updateTotalPrices();
        $("#newConceptModal").modal("hide");
        CleanModalAndData();
        enableSaveBtn();
    })

    $("#conceptEditBtn").on("click", function() {
        console.log("editing row: "+editingRowIdN);
        conceptsArr[editingRowIdN].cantidad = cantidad;
        conceptsArr[editingRowIdN].precio = precioUnitario_concepto;
        conceptsArr[editingRowIdN].descripcion = $("#descripcion-edit").val();
        conceptsArr[editingRowIdN].iva = (tiene_iva == 1 ? iva_concepto:0);
        conceptsArr[editingRowIdN].total = (tiene_iva == 1 ? parseFloat((cantidad*(iva_concepto+precioUnitario_concepto)).toFixed(2)):parseFloat((cantidad*precioUnitario_concepto).toFixed(2)));
        console.log(conceptsArr);
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
        console.log("tiene iva: "+tiene_iva);
        var editingConcept = conceptsArr[editingRowIdN];
        console.log(editingConcept);

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
        $("#localidad").val(cliente.localidad);
        $("#clientSearchModal").find("tbody tr.selected").removeClass("selected");
        $("#selectClientBtn").attr("disabled","disabled");
        $("#clientSearchModal").modal("hide");
        $("#observaciones").removeAttr("disabled");
        $("#NewBtn").removeAttr("disabled");
        $("#continue-alert").remove();
        enableSaveBtn();
    });

    $("#billSearchModal").on("hide.bs.modal", function(){
        $(this).find("tbody tr.selected").removeClass("selected");
        $("#selectBillBtn").attr("disabled","disabled");
    })

    $("#selectBillBtn").on("click", function() {
        var numeroFactura = dTableBills.row(".selected").data().numero;
        var cliente;
        $.ajax({
            url: "scripts/php/select_from_db.php", // this is the target
            type: 'post', // method
            async: false,
            dataType: 'json',
            data: {sql: "select nif, nombre, direccion, cp, localidad from facturas where numero='"+numeroFactura+"'"}, // pass the input value to serve
            success: function(response) { // if the http response code is 200
                cliente = response[0];
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
        
        $("#bill-reference").val(numeroFactura);
        $("#nif").val(cliente["nif"]);
        $("#nombre").val(cliente["nombre"]);
        $("#direccion").val(cliente["direccion"]);
        $("#cp").val(cliente["cp"]);
        $("#localidad").val(cliente["localidad"]);
        $("#billSearchModal").find("tbody tr.selected").removeClass("selected");
        $("#selectBillBtn").attr("disabled","disabled");
        $("#billSearchModal").modal("hide");
        // enableSaveBtn();
    });

    $("#cancelBtn").on("click", function(){
        console.log("FIVA: "+$("#numero").val().includes("FIVA"));
        console.log("RFIVA: "+$("#numero").val().includes("RFIVA"));
        console.log(action);
        if (typeof archivo !== "undefined")
            window.location.href = "?page=archive";
        else if (action == "new-budget" || action == "edit-budget")
            window.location.href = "?page=budgets";
        else if ((action == "view-bill" && $("#numero").val().includes("RFIVA")) || action == "rectify-bill")
            window.location.href = "?page=rbills";
        else if ((action == "view-bill" && $("#numero").val().includes("FIVA")) || action == "new-bill" || action == "edit-bill" || action == "new-bill-from-budget")
            window.location.href = "?page=bills";
    })

    $("#fecha").on("change", function(){
        enableSaveBtn();
    })

    function Save(save) {
        if (action == "edit-bill") {
           
            var data = [
                ["numero", $("#numero").val()],
                ["nif", $("#nif").val()],
                ["fecha",new Date($("#fecha").val()).toISOString().slice(0,19).replace('T',' ')],
                ["formapago",$("#forma-pago").find(":selected").val()],
                ["conceptos",JSON.stringify(conceptsArr)],
                ["observaciones", $("#observaciones").val()],
                ["total",total_global],
                ["iva", iva_global],
                ["imponible", imponible_global],
                ["nombre", $("#nombre").val()],
                ["direccion",$("#direccion").val()],
                ["cp",$("#cp").val()],
                ["localidad",$("#localidad").val()]
            ]

            $.ajax({
                url: "scripts/php/update_db.php",
                type: 'post',
                dataType: 'text',
                data: {table: "facturas", data: JSON.stringify(data), where: JSON.stringify(["numero", $("#numero").val()])},
                success: function(response) { 
                    reload = false;
                    console.log(response);
                    alert(response);
                    if (save == "saveOnly") {
                        window.location.href = "?page=bills";
                    }
                },
                error: function(response) {
                    alert(response);
                }
            });

            // sql1 = "insert into facturas (";
            // for (i = 0; i < columns.length-1; i++) {
            //     sql1 += columns[i]+",";
            // }
            // sql1 += columns[columns.length-1]+") values (";
            // for (i = 0; i < values.length-1; i++) {
            //     sql1 += "'"+values[i]+"',";
            // }
            // sql1 += "'"+values[values.length-1]+"')";

            // sql2 = "update controlfactura set anoultimafactura = ";
            // sql2 += new Date().getFullYear().toString().substr(-2);
            // sql2 += " , numeroultimafactura = ";
            // sql2 += $("#numero").val().substr(6);
            // sql2 += " where nombreserie = 'FIVA'";

            // $.ajax({
            //     url: "scripts/php/transaction_db.php", 
            //     type: 'post', 
            //     dataType: 'text',
            //     data: {sql: JSON.stringify([sql1, sql2])}, 

            //     success: function(response) { 
            //         alert(response);
            //         if (save == "saveOnly") {
            //             window.location.href = "?page=bills";
            //         }
            //     },
            //     error: function(response) { 
            //         alert(response);
            //     }
            // });
        }
        if (action == "new-bill" || action == "new-bill-from-budget") {
            var columns = [
                "numero", 
                "nif", 
                "fecha", 
                "formapago", 
                "conceptos", 
                "observaciones", 
                "total", 
                "iva",
                "imponible",
                "nombre",
                "direccion",
                "cp",
                "localidad"
            ];
            var values = [
                $("#numero").val(),
                $("#nif").val(),
                new Date($("#fecha").val()).toISOString().slice(0,19).replace('T',' '),
                $("#forma-pago").find(":selected").val(),
                JSON.stringify(conceptsArr),
                $("#observaciones").val(),
                total_global,
                iva_global,
                imponible_global,
                $("#nombre").val(),
                $("#direccion").val(),
                $("#cp").val(),
                $("#localidad").val()
            ]
            sql1 = "insert into facturas (";
            for (i = 0; i < columns.length-1; i++) {
                sql1 += columns[i]+",";
            }
            sql1 += columns[columns.length-1]+") values (";
            for (i = 0; i < values.length-1; i++) {
                sql1 += "'"+values[i]+"',";
            }
            sql1 += "'"+values[values.length-1]+"')";

            sql2 = "update controlfactura set anoultimafactura = ";
            sql2 += new Date().getFullYear().toString().substr(-2);
            sql2 += " , numeroultimafactura = ";
            sql2 += $("#numero").val().substr(6);
            sql2 += " where nombreserie = 'FIVA'";

            $.ajax({
                url: "scripts/php/transaction_db.php", 
                type: 'post', 
                dataType: 'text',
                data: {sql: JSON.stringify([sql1, sql2])}, 

                success: function(response) { 
                    reload = false;
                    alert(response);
                    if (save == "saveOnly") {
                        window.location.href = "?page=bills";
                    }
                },
                error: function(response) { 
                    alert(response);
                }
            });
        }
        
        if (action == "rectify-bill") {
            var columns = [
                "numero", 
                "facturaref",
                "nif", 
                "fecha", 
                "formapago", 
                "conceptos", 
                "observaciones",
                "total", 
                "iva",
                "imponible",
                "nombre",
                "direccion",
                "cp",
                "localidad"
            ];
            var values = [
                $("#numero").val(),
                $("#bill-reference").val(),
                $("#nif").val(),
                new Date($("#fecha").val()).toISOString().slice(0,19).replace('T',' '),
                $("#forma-pago").find(":selected").val(),
                JSON.stringify(conceptsArr),
                $("#observaciones").val(),
                total_global,
                iva_global,
                imponible_global,
                $("#nombre").val(),
                $("#direccion").val(),
                $("#cp").val(),
                $("#localidad").val()
            ];

            sql1 = "insert into facturasrec (";
            for (i = 0; i < columns.length-1; i++) {
                sql1 += columns[i]+",";
            }
            sql1 += columns[columns.length-1]+") values (";
            for (i = 0; i < values.length-1; i++) {
                sql1 += "'"+values[i]+"',";
            }
            sql1 += "'"+values[values.length-1]+"')";

            sql2 = "update controlfactura set anoultimafactura = ";
            sql2 += new Date().getFullYear().toString().substr(-2);
            sql2 += " , numeroultimafactura = ";
            sql2 += $("#numero").val().substr(7);
            sql2 += " where nombreserie = 'RFIVA'";

            $.ajax({
                url: "scripts/php/transaction_db.php", 
                type: 'post',
                dataType: 'text',
                data: {sql: JSON.stringify([sql1, sql2])}, 
                success: function(response) {
                    reload = false;
                    console.log(response);
                    alert(response);
                    if (save == "saveOnly") {
                        window.location.href = "?page=rbills";
                    }
                },
                error: function(response) { 
                    alert(response);
                }
            });
        }

        if (action == "new-budget") {
            var columns = [
                "numero", 
                "nif", 
                "fecha",  
                "conceptos", 
                "observaciones",
                "formapago",
                "tieneiva", 
                "total", 
                "iva",
                "imponible",
                "nombre",
                "direccion",
                "cp",
                "localidad"
            ];
            var values = [
                $("#numero").val(),
                $("#nif").val(),
                new Date($("#fecha").val()).toISOString().slice(0,19).replace('T',' '),
                JSON.stringify(conceptsArr),
                $("#observaciones").val(),
                $("#forma-pago option:selected").val(),
                $("#presupuesto-iva option:selected").val(),
                total_global,
                iva_global,
                imponible_global,
                $("#nombre").val(),
                $("#direccion").val(),
                $("#cp").val(),
                $("#localidad").val()
            ];

            sql1 = "insert into presupuestos (";
            for (i = 0; i < columns.length-1; i++) {
                sql1 += columns[i]+",";
            }
            sql1 += columns[columns.length-1]+") values (";
            for (i = 0; i < values.length-1; i++) {
                sql1 += "'"+values[i]+"',";
            }
            sql1 += "'"+values[values.length-1]+"')";

            sql2 = "update controlfactura set anoultimafactura = ";
            sql2 += new Date().getFullYear().toString().substr(-2);
            sql2 += " , numeroultimafactura = ";
            sql2 += $("#numero").val().substr(4);
            sql2 += " where nombreserie = 'PR'";

            $.ajax({
                url: "scripts/php/transaction_db.php", 
                type: 'post', 
                dataType: 'text',
                data: {sql: JSON.stringify([sql1, sql2])}, 
                success: function(response) {
                    reload = false;
                    console.log(response);
                    alert(response);
                    if (save == "saveOnly") {
                        window.location.href = "?page=budgets";
                    }
                },
                error: function(response) { 
                    alert(response);
                }
            });
        }

        if (action == "edit-budget") {
            var iva = $("#presupuesto-iva option:selected").val();
            // console.log("iva: "+iva);
            // console.log("total: "+total_global);
            // console.log("imponible: "+imponible_global);
            // console.log("iva: "+iva_global);
            // console.log("conceptos: "+JSON.stringify(conceptsArr));
            var data = [
                ["fecha", new Date($("#fecha").val()).toISOString().slice(0,19).replace('T',' ')], 
                ["conceptos", JSON.stringify(conceptsArr)], 
                ["observaciones", $("#observaciones").val()],
                ["formapago", $("#forma-pago option:selected").val()],
                ["tieneiva", iva == "si" ? "si" : "no"],
                ["total", total_global], 
                ["iva", iva_global],
                ["imponible", imponible_global]
            ];

            console.log(data);

            $.ajax({
                url: "scripts/php/update_db.php",
                type: 'post',
                dataType: 'text',
                data: {table: "presupuestos", data: JSON.stringify(data), where: JSON.stringify(["numero", $("#numero").val()])},
                success: function(response) { 
                    reload = false;
                    console.log(response);
                    alert(response);
                    if (save == "saveOnly") {
                        window.location.href = "?page=budgets";
                    }
                },
                error: function(response) {
                    alert(response);
                }
            });
        }
    }

    $("#SaveBtn").on("click", function(){
        //reload = true;
        console.log("Saving...");
        Save("saveOnly");
    });

    $("#SavePrintBtn").on("click", function() {
        Save("print");
        window.location.href = "scripts/factura/factura.php?action=display&numero="+$("#numero").val();
    });

    $("#PrintBtn").on("click", function() {
        reload = false;
        if ((typeof archivo !== "undefined") && archivo) window.location.href = "scripts/factura/factura.php?action=display&numero="+$("#numero").val()+"&archivo=si";
        else window.location.href = "scripts/factura/factura.php?action=display&numero="+$("#numero").val();
    });
    // console.log(conceptsArr);
    // console.log("iva: "+iva_global);
    // console.log("imponible: "+imponible_global);
    // console.log("total: "+total_global);
})
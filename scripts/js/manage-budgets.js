$(document).ready(function() {
    $("#NewBtn").on("click", function() {
        window.location.href = "?page=new-budget";
    });

    $("#EditBtn").on("click", function() {
        window.location.href = "?page=edit-budget&numero="+dTable.row(".selected").data().id;
    });

    $("#PrintBtn").on("click", function() {
        numeroPresupuesto = dTable.row(".selected").data().id;
        window.location.href = "scripts/factura/factura.php?numero="+numeroPresupuesto;
    });

    $("#deleteBudgetBtn").on("click", function() {
        numeroPresupuesto = dTable.row(".selected").data().id;
        $.ajax({
            url: "scripts/php/delete_budget.php", // this is the target
            type: 'post', // method
            dataType: 'text',
            data: {numero: numeroPresupuesto}, // pass the input value to serve
            success: function(response) { // if the http response code is 200
                console.log(response);
                alert(response);
                window.location.href = "?page=budgets";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
                // HideSpinner();
            }
        });
    });
} );
$(document).ready(function() {
    $("#NewBtn").on("click", function() {
        window.location.href = "?page=new-budget";
    });

    $("#EditBtn").on("click", function() {
        window.location.href = "?page=edit-budget&numero="+dTable.row(".selected").data().numero;
    });

    $("#PrintBtn").on("click", function() {
        window.location.href = "scripts/factura/factura.php?action=display&numero="+dTable.row(".selected").data().numero;
    });

    $("#ToBillBtn").on("click", function() {
        window.location.href = "?page=new-bill-from-budget&numero="+dTable.row(".selected").data().numero;
    });

    $("#deleteBudgetBtn").on("click", function() {
        $.ajax({
            url: "scripts/php/delete_from_db.php", // this is the target
            type: 'post', // method
            dataType: 'text',
            data: {table: "presupuestos", cell: "numero", value: dTable.row(".selected").data().numero}, // pass the input value to serve
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location.href = "?page=budgets";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
            }
        });
    });
} );
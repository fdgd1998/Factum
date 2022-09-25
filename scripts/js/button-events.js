
$(document).ready(function() {
    $("#PrintBtn").on("click", function() {
        numeroFactura = dTable.row(".selected").data().numero;
        if (action == "archive") window.location.href = "scripts/factura/factura.php?action=display&numero="+numeroFactura+"&archivo=si";
        else window.location.href = "scripts/factura/factura.php?action=display&numero="+numeroFactura;
    });

    $("#ViewBtn").on("click", function() {
        factura = dTable.row(".selected").data();
        console.log(factura);
        window.location.href = "?page=view-bill&numero="+factura.numero;
    });
})
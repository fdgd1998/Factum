$(document).ready(function() {
    $("#NewBtn").on("click", function() {
        window.location.href = "?page=new-bill";
    });

    $("#NewRecBtn").on("click", function() {
        window.location.href = "?page=rectify-bill";
    });

    $("#ViewBtn").on("click", function() {
        factura = dTable.row(".selected").data();
        console.log(factura);
        window.location.href = "?page=view-bill&id="+factura.id;
    });

    $("#PrintBtn").on("click", function() {
        numeroFactura = dTable.row(".selected").data().id;
        window.location.href = "scripts/factura/factura.php?numero="+numeroFactura;
    });
} );
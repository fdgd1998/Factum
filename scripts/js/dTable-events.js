function EnablePrintBtn(enable) {
    if (enable) $("#PrintBtn").removeAttr("disabled");
    else $("#PrintBtn").attr("disabled","disabled");
}

function EnableViewBtn(enable) {
    if (enable) $("#ViewBtn").removeAttr("disabled");
    else $("#ViewBtn").attr("disabled","disabled");
}

$(document).ready(function() {
    $("#PrintBtn").on("click", function() {
        numeroFactura = dTable.row(".selected").data().numero;
        window.location.href = "scripts/factura/factura.php?numero="+numeroFactura;
    });

    $("#ViewBtn").on("click", function() {
        factura = dTable.row(".selected").data();
        console.log(factura);
        window.location.href = "?page=view-bill&numero="+factura.numero;
    });

    $('#dTable tbody').on('click', 'tr', function () {
        if ($(this).children("td").hasClass("dataTables_empty")) {
            $(this).removeClass("selected");
        } else {
            EnableViewBtn(true);
            EnablePrintBtn(true);
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                
            }
            else {
                $("#dTable tr.selected").removeClass('selected');
                $(this).addClass('selected');
                console.log("seleccionado");
            }

            if ($("#dTable tr.selected").length == 0) {
                EnableViewBtn(true);
                EnablePrintBtn(true);
            }
        }
    });
})
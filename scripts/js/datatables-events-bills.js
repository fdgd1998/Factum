const currencyOptions = {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
}

const dateOptions = { year: 'numeric', month: 'numeric', day: 'numeric' };

var dTable;
$(document).ready(function() {
    dTable = $('#dTable').DataTable({
        language: {
            "decimal":        "",
            "emptyTable":     "No existen datos",
            "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas totales",
            "infoEmpty":      "Mostrando 0 de 0 de 0 entradas",
            "infoFiltered":   "(filtrando desde _MAX_ entradas totales)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No hay resultados coincidentes",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       ">",
                "previous":   "<"
            }
        },
        processing:true,     
        ajax:{
            url: './scripts/php/select_bills.php',
            type: 'POST',
            data: {action:'listEvent'},
            dataType: 'json'
            },
 
        columns: [
            { "data": "id" },
            { "data": "fecha" },
            { "data": "nif" },                       
            { "data": "nombre" },
            { "data": "total" }
        ],

        columnDefs: [
            {
                targets: 4,
                render: function(data, type, full, meta){
                return new Intl.NumberFormat("es-ES", currencyOptions).format(data);
                }
            },
            {
                targets: 1,
                render: function(data, type, full, meta){
                return new Date(data).toLocaleDateString('es-ES', dateOptions);
                }
            },
        ],
        searching: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [5, 10, 20],
        paging: true,
        pagingType: "simple_numbers" ,
        info: true,
        autoWidth: false,
        select: {
            style: 'single'
        }
    });
    
    $('#dTable tbody').on('click', 'tr', function () {
        if ($(this).children("td").hasClass("dataTables_empty")) {
            $(this).removeClass("selected");
        } else {
            $("#ViewBtn").removeAttr("disabled");
            $("#PrintBtn").removeAttr("disabled");
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                
            }
            else {
                $("#dTable tr.selected").removeClass('selected');
                $(this).addClass('selected');
            }

            if ($("#dTable tr.selected").length == 0) {
                $("#ViewBtn").attr("disabled", "disabled");
                $("#PrintBtn").attr("disabled", "disabled");
            }
        }
    });
})
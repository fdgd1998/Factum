
var dTable;

$(document).ready(function() {
    dTable = $('#dTable').DataTable({
        language: {
            "decimal":        "",
            "emptyTable":     "No existen datos",
            "info":           "Mostrando _START_ a _END_ (_TOTAL_ entradas totales)",
            "infoEmpty":      "No hay datos.",
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
            url: './scripts/php/get_data_for_table.php',
            type: 'POST',
            data: {sql: "select numero, fecha, nif, nombre, total from presupuestos"},
            dataType: 'json'
            },
 
        columns: [
            { "data": "numero" },
            { "data": "fecha" }, 
            { "data": "nif" },     
            { "data": "nombre" },
            { "data": "total" }
        ],
        columnDefs: [
            {
                targets: 4,
                render: function(data, type, full, meta){
                    return FormatCurrency(data);
                }
            },
            {
                targets: 1,
                render: function(data, type, full, meta){
                    return FormatDate(data);
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
            $("#EditBtn").removeAttr("disabled");
            $("#DeleteBtn").removeAttr("disabled");
            $("#PrintBtn").removeAttr("disabled");
            $("#ToBillBtn").removeAttr("disabled");
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                
            }
            else {
                $("#dTable tr.selected").removeClass('selected');
                $(this).addClass('selected');
            }

            if ($("#dTable tr.selected").length == 0) {
                $("#EditBtn").attr("disabled", "disabled");
                $("#DeleteBtn").attr("disabled", "disabled");
                $("#PrintBtn").attr("disabled", "disabled");
                $("#ToBillBtn").attr("disabled", "disabled");
            }
        }
    });
})
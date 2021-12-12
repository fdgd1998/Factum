var dTable;

$(document).ready(function() {
    dTable = $('#dTable').DataTable({
        language: {
            "decimal":        "",
            "emptyTable":     "No existen datos",
            "info":           "Mostrando _START_ a _END_ (_TOTAL_ entradas totales)",
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
            url: './scripts/php/get_data_for_table.php',
            type: 'POST',
            data: {sql: "select numero, fecha, nif, nombre, total from facturas"},
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
})
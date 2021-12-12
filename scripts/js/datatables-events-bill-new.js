var dTable;

$(document).ready(function() {
    dTable = $('#dTable').DataTable({
        language: {
            "decimal":        "",
            "emptyTable":     "No existen datos",
            "info":           "Mostrando _START_ a _END_  (_TOTAL_ entradas totales)",
            "infoEmpty":      "Mostrando 0 de 0 (0 entradas totales)",
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
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        lengthChange: true,
        info: false,
        searching: false,
        sort: false,
        paging: false,
        autoWidth: true,
        select: {
            style: 'single'
        }
    });
    
    dTableBills = $('#dTableBills').DataTable({
        language: {
            "decimal":        "",
            "emptyTable":     "No existen datos",
            "info":           "Mostrando _START_ a _END_ (_TOTAL_ entradas totales)",
            "infoEmpty":      "Mostrando 0 de 0 (0 entradas totales)",
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
                    return FormatDate(data);;
                }
            },
        ],
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
        lengthChange: false,
        info: true,
        ordering: false,
        pageLength: 5,
        searching: true,
        paging: true,
        autoWidth: false,
        select: {
            style: 'single'
        }
    });
    
    dTableClients = $('#dTableClients').DataTable({
        language: {
            "decimal":        "",
            "emptyTable":     "No existen datos",
            "info":           "Mostrando _START_ a _END_ (_TOTAL_ entradas totales)",
            "infoEmpty":      "Mostrando 0 de 0 (0 entradas)",
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
            data: {sql: "select nif, nombre, direccion, cp, localidad from clientes"},
            dataType: 'json'
            },
 
        columns: [
            { "data": "nif" },
            { "data": "nombre" },
            { "data": "direccion" },
            { "data": "cp" },                       
            { "data": "localidad" }
            ],
        lengthChange: false,
        info: true,
        ordering: false,
        pageLength: 5,
        searching: true,
        paging: true,
        autoWidth: false,
        select: {
            style: 'single'
        }
    });

    $('#dTableClients tbody').on('click', 'tr', function () {
        if ($(this).children("td").hasClass("dataTables_empty")) {
            $(this).removeClass("selected");
        } else {
            $("#selectClientBtn").removeAttr("disabled");

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                
            }
            else {
                $("#dTableClients tr.selected").removeClass('selected');
                $(this).addClass('selected');
            }

            if ($("#dTableClients tr.selected").length == 0) {
                $("#selectClientBtn").attr("disabled", "disabled");
            }
        }
    });

    $('#dTableBills tbody').on('click', 'tr', function () {
        if ($(this).children("td").hasClass("dataTables_empty")) {
            $(this).removeClass("selected");
        } else {
            $("#selectBillBtn").removeAttr("disabled");

            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                
            }
            else {
                $("#dTableBills tr.selected").removeClass('selected');
                $(this).addClass('selected');
            }

            if ($("#dTableBills tr.selected").length == 0) {
                $("#selectBillBtn").attr("disabled", "disabled");
            }
        }
    });

    $('#dTable tbody').on('click', 'tr', function () {
        if ($(this).children("td").hasClass("dataTables_empty")) {
            $(this).removeClass("selected");
        } else {
            $("#EditBtn").removeAttr("disabled");
            $("#DeleteBtn").removeAttr("disabled");

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
            }
        }
        
    });
    
})
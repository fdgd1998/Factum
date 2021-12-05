$(document).ready(function() {
    $('#dTable').DataTable({
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
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        searching: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [5, 10, 20],
        paging: true,
        pagingType: "simple_numbers" ,
        info: true,
        autoWidth: true,
        select: {
            style: 'single'
        }
    });
    
    $('#dTable tbody').on('click', 'tr', function () {
        $("#EditBtn").removeAttr("disabled");
        $("#DeleteBtn").removeAttr("disabled");
        $("#PrintBtn").removeAttr("disabled");

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
        }
    });
})
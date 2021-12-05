$(document).ready(function() {
    var table = $('#example').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "No data available in table",
            "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
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
            },
            "aria": {
                "sortAscending":  ": activar para ordenar la column ascendentemente",
                "sortDescending": ": activar para ordenar la column descendentemente"
            }
        }
    });
} );
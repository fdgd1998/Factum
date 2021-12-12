$(document).ready(function() {
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
    
    $("#NewBtn").on("click", function() {
        window.location.href = "?page=new-client";
    });

    $("#EditBtn").on("click", function() {
        window.location.href = "?page=edit-client&id="+dTable.row(".selected").data()["nif"];
    });

    $("#deleteClientBtn").on("click", function() {
        nif = dTable.row(".selected").data().nif;
        $.ajax({
            url: "scripts/php/delete_from_db.php", // this is the target
            type: 'post', // method
            dataType: 'text',
            data: {table: "clientes", cell: "nif", value: nif}, // pass the input value to serve
            success: function(response) { // if the http response code is 200
                alert(response);
                window.location.href = "?page=clients";
            },
            error: function(response) { // if the http response code is other than 200
                alert(response);
                // HideSpinner();
            }
        });
    });
} );
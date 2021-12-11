$(document).ready(function() {
    $("#NewBtn").on("click", function() {
        window.location.href = "?page=new-client";
    });

    $("#EditBtn").on("click", function() {
        window.location.href = "?page=edit-client&id="+dTable.row(".selected").data()["nif"];
    });

    $("#deleteClientBtn").on("click", function() {
        cliente = dTable.row(".selected").data().nif;
        console.log(cliente);
        $.ajax({
            url: "scripts/php/delete_client.php", // this is the target
            type: 'post', // method
            dataType: 'text',
            data: {id: cliente}, // pass the input value to serve
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
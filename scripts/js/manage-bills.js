$(document).ready(function() {
    $("#NewBtn").on("click", function() {
        window.location.href = "?page=new-bill";
    });

    $("#EditBtn").on("click", function() {
        window.location.href = "?page=edit-bill";
    });
} );
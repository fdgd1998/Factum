$(document).ready(function() {
    $("#NewBtn").on("click", function() {
        window.location.href = "?page=new-bill";
    });

    $("#NewRecBtn").on("click", function() {
        window.location.href = "?page=rectify-bill";
    });
} );
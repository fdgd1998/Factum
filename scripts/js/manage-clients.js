$(document).ready(function() {
    $("#NewBtn").on("click", function() {
        window.location.href = "?page=new-client";
    });

    $("#EditBtn").on("click", function() {
        window.location.href = "?page=edit-client";
    });
} );
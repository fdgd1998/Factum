$(document).ready(function() {
    $("#NewBtn").on("click", function() {
        window.location.href = "?page=new-budget";
    });

    $("#EditBtn").on("click", function() {
        window.location.href = "?page=edit-budget";
    });
} );
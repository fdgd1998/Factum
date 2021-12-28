function EnableNameInput(enable) {
    if (enable) $("#group-name").removeAttr("disabled");
    else $("#group-name").attr("disabled","disabled");
}

function EnableSubmitBtn() {
    var total_inputs = 0;
    var radio = $("input[name=options]:checked").attr("id");
    if($("#fecha-i").val() != "") total_inputs++;
    if($("#fecha-f").val() != "") total_inputs++;
    console.log($("#fecha-i").val())
    console.log(total_inputs)
    if(radio == "archive-rbtn" || radio == "both-rbtn") {
        if ($("#group-name").val() != "") total_inputs++;
        if (total_inputs == 3) $("#submitBtn").removeAttr("disabled");
        else $("#submitBtn").attr("disabled","disabled");
    } else {
        if (total_inputs == 2) $("#submitBtn").removeAttr("disabled");
        else $("#submitBtn").attr("disabled","disabled");
    }
}
$(document).ready(function(){
    $(".form-check-input").on("change", function() {
        switch ($(this).attr("id")) {
            case "download-rbtn":
                EnableNameInput(false);
                break;
            case "archive-rbtn":
                EnableNameInput(true);
                break;
            case "both-rbtn":
                EnableNameInput(true);
                break;
        }
        EnableSubmitBtn();
    })

    $("#fecha-i, #fecha-f").on("change", function(){
        EnableSubmitBtn();
    })

    $("#group-name").on("keyup", function(){
        EnableSubmitBtn();
    })
    
    $("#submitBtn").on("click", function(){
        var id = $("input[name=options]:checked").attr("id");
        console.log(id);
        switch(id) {
            case "download-rbtn":
                window.location.href = "http://localhost/scripts/factura/factura.php?action=download&i="+$("#fecha-i").val()+"&f="+$("#fecha-f").val();
                break;
            case "archive-rbtn":
                $.ajax({
                    url: "scripts/php/archive_bills.php",
                    type: 'post',
                    dataType: 'text',
                    data: {group: $("#group-name").val(), fechai: $("#fecha-i").val(), fechaf: $("#fecha-f").val()},
                    success: function(response) { 
                        alert(response);
                        window.location.href = "http://localhost?page=bill-options";
                    },
                    error: function(response) {
                        alert(response);
                    }
                });
                break;
            case "both-rbtn":
                var success = true;
                $.ajax({
                    url: "scripts/php/archive_bills.php",
                    type: 'post',
                    dataType: 'text',
                    data: {group: $("#group-name").val(), fechai: $("#fecha-i").val(), fechaf: $("#fecha-f").val()},
                    success: function(response) { 
                        alert(response);
                    },
                    error: function(response) {
                        alert(response);
                        success = false;
                    }
                });
                if (success) window.location.href = "http://localhost/scripts/factura/factura.php?action=download&i="+$("#fecha-i").val()+"&f="+$("#fecha-f").val();
                break;
        }
    })
})
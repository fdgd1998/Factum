function EnableNameInput(enable) {
    if (enable) $("#group-name").removeAttr("disabled");
    else $("#group-name").attr("disabled","disabled");
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
    })
})
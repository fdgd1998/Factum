var banner_msg = {
    "client_success" : "El cliente se ha creado correctamente.",
    "bill_success" : "La factura se ha creado correctamente.",
    "budget_success" : "El presupuesto se ha creado correctamente.",
    "client_error" : "Ha ocurrido un error al crear el cliente.",
    "bill_error": "Ha ocurrido un error al crear la factura.",
    "budget_error": "Ha ocurrido un error al crear el presupuesto."
}

function createSuccessBanner(msg) {
    var main_div = $('<div class="alert alert-warning alert-dismissible fade show" role="alert">');
    var icon = $('<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>');
    var dismiss_btn = $('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
    var text= $('<span>'+banner_msg[msg]+'</span>');
    
    main_div.append(icon);
    main_div.append(text);
    var element = main_div.append(dismiss_btn);
    $("#banner").insertAfter(element);

    console.log(main_div);
    
}

function createErrorBanner() {

}
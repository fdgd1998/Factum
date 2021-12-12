const currencyOptions = {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
}

const dateOptions = { year: 'numeric', month: 'numeric', day: 'numeric' };

function FormatCurrency(data){
    return new Intl.NumberFormat("es-ES", currencyOptions).format(data);
}

function FormatDate (data){
    return new Date(data).toLocaleDateString('es-ES', dateOptions);
}
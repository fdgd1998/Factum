class BillConcept {
    constructor(cantidad, descripcion, precio, iva) {
        this.cantidad = cantidad;
        this.descripcion = descripcion;
        this.precio = precio;
        this.iva = iva;
        this.total = cantidad*(precio + iva);
        // console.log(this);
    }
}
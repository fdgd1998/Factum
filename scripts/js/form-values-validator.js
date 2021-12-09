/** libreria de funciones javascript para validaciones de forms **/
/** Diego Di Camillo - diegodicamillo@diegodicamillo.com.ar     **/

function EsEmail(w_email) {
	
	var test = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var emailReg = new RegExp(test);

	return emailReg.test(w_email);
}

function EsTelefonoFijo(tel) {
				var test = /^[89]\d{8}$/;
				var telReg = new RegExp(test);
				return telReg.test(tel);
			}
function EsTelefonoMovil(tel) {
				var test = /^[6]\d{8}$/;
				var telReg = new RegExp(test);
				return telReg.test(tel);
			}


function isValidCif(abc){
	par = 0;
	non = 0;
	letras = "ABCDEFGHKLMNPQS";
	let = abc.charAt(0);
	
	if (abc.length!=9) {
		//alert('El Cif debe tener 9 dígitos');
		return false;
	}
	
	if (letras.indexOf(let.toUpperCase())==-1) {
		//alert("El comienzo del Cif no es válido");
		return false;
	}
	
	for (zz=2;zz<8;zz+=2) {
		par = par+parseInt(abc.charAt(zz));
	}
	
	for (zz=1;zz<9;zz+=2) {
		nn = 2*parseInt(abc.charAt(zz));
		if (nn > 9) nn = 1+(nn-10);
		non = non+nn;
	}
	
	parcial = par + non;
	control = (10 - ( parcial % 10));
	if (control==10) control=0;
	
	if (control!=abc.charAt(8)) {
		//alert("El Cif no es válido");
		return false;
	}
	//alert("El Cif es válido");
	return true;
}


function isValidNif(abc){
	dni=abc.substring(0,abc.length-1);
	let=abc.charAt(abc.length-1);
	if (!isNaN(let)) {
		//alert('Falta la letra');
		return false;
	}else{
		cadena = "TRWAGMYFPDXBNJZSQVHLCKET";
		posicion = dni % 23;
		letra = cadena.substring(posicion,posicion+1);
		if (letra!=let.toUpperCase()){
			//alert("Nif no válido");
			return false;
		}
	}
	//alert("Nif válido")
	return true;
}
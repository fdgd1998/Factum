/** libreria de funciones javascript para validaciones de forms **/
/** Diego Di Camillo - diegodicamillo@diegodicamillo.com.ar     **/

function EsEmail(w_email) {
	
	var test = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var emailReg = new RegExp(test);

	return emailReg.test(w_email);
}


// function isValidCif(abc){
// 	par = 0;
// 	non = 0;
// 	letras = "ABCDEFGHKLMNPQS";
// 	let = abc.charAt(0);
	
// 	if (abc.length!=9) {
// 		//alert('El Cif debe tener 9 dígitos');
// 		return false;
// 	}
	
// 	if (letras.indexOf(let.toUpperCase())==-1) {
// 		//alert("El comienzo del Cif no es válido");
// 		return false;
// 	}
	
// 	for (zz=2;zz<8;zz+=2) {
// 		par = par+parseInt(abc.charAt(zz));
// 	}
	
// 	for (zz=1;zz<9;zz+=2) {
// 		nn = 2*parseInt(abc.charAt(zz));
// 		if (nn > 9) nn = 1+(nn-10);
// 		non = non+nn;
// 	}
	
// 	parcial = par + non;
// 	control = (10 - ( parcial % 10));
// 	if (control==10) control=0;
	
// 	if (control!=abc.charAt(8)) {
// 		//alert("El Cif no es válido");
// 		return false;
// 	}
// 	//alert("El Cif es válido");
// 	return true;
// }


// function isValidNif(abc){
// 	dni=abc.substring(0,abc.length-1);
// 	let=abc.charAt(abc.length-1);
// 	if (!isNaN(let)) {
// 		//alert('Falta la letra');
// 		return false;
// 	}else{
// 		cadena = "TRWAGMYFPDXBNJZSQVHLCKET";
// 		posicion = dni % 23;
// 		letra = cadena.substring(posicion,posicion+1);
// 		if (letra!=let.toUpperCase()){
// 			//alert("Nif no válido");
// 			return false;
// 		}
// 	}
// 	//alert("Nif válido")
// 	return true;
// }

// function isValidNie( nie ) {

//     // Change the initial letter for the corresponding number and validate as DNI
//     var nie_prefix = nie.charAt( 0 );

//     switch (nie_prefix) {
//       case 'X': nie_prefix = 0; break;
//       case 'Y': nie_prefix = 1; break;
//       case 'Z': nie_prefix = 2; break;
//     }

//     return isValidNif( nie_prefix + nie.substr(1) );

//   };
/**
 * ValidateSpanishID. Returns the type of document and checks its validity.
 * 
 * Usage:
 *     ValidateSpanishID( str );
 * 
 *     > ValidateSpanishID( '12345678Z' );
 *     // { type: 'dni', valid: true }
 *     
 *     > ValidateSpanishID( 'B83375575' );
 *     // { type: 'cif', valid: false }
 * 
 * The algorithm is adapted from other solutions found at:
 * - http://www.compartecodigo.com/javascript/validar-nif-cif-nie-segun-ley-vigente-31.html
 * - http://es.wikipedia.org/wiki/C%C3%B3digo_de_identificaci%C3%B3n_fiscal
 */

ValidateSpanishID = (function() {
	'use strict';
	
	var DNI_REGEX = /^(\d{8})([A-Z])$/;
	var CIF_REGEX = /^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/;
	var NIE_REGEX = /^[XYZ]\d{7,8}[A-Z]$/;
  
	var ValidateSpanishID = function( str ) {
  
	  // Ensure upcase and remove whitespace
	  str = str.toUpperCase().replace(/\s/, '');
  
	  var valid = false;
	  var type = spainIdType( str );
  
	  switch (type) {
		case 'dni':
		  valid = validDNI( str );
		  break;
		case 'nie':
		  valid = validNIE( str );
		  break;
		case 'cif':
		  valid = validCIF( str );
		  break;
	  }
  
	  return {
		type: type,
		valid: valid
	  };
  
	};
  
	var spainIdType = function( str ) {
	  if ( str.match( DNI_REGEX ) ) {
		return 'dni';
	  }
	  if ( str.match( CIF_REGEX ) ) {
		return 'cif';
	  }
	  if ( str.match( NIE_REGEX ) ) {
		return 'nie';
	  }
	};
  
	var validDNI = function( dni ) {
	  var dni_letters = "TRWAGMYFPDXBNJZSQVHLCKE";
	  var letter = dni_letters.charAt( parseInt( dni, 10 ) % 23 );
	  
	  return letter == dni.charAt(8);
	};
  
	var validNIE = function( nie ) {
  
	  // Change the initial letter for the corresponding number and validate as DNI
	  var nie_prefix = nie.charAt( 0 );
  
	  switch (nie_prefix) {
		case 'X': nie_prefix = 0; break;
		case 'Y': nie_prefix = 1; break;
		case 'Z': nie_prefix = 2; break;
	  }
  
	  return validDNI( nie_prefix + nie.substr(1) );
  
	};
  
	var validCIF = function( cif ) {
  
	  var match = cif.match( CIF_REGEX );
	  var letter  = match[1],
		  number  = match[2],
		  control = match[3];
  
	  var even_sum = 0;
	  var odd_sum = 0;
	  var n;
  
	  for ( var i = 0; i < number.length; i++) {
		n = parseInt( number[i], 10 );
  
		// Odd positions (Even index equals to odd position. i=0 equals first position)
		if ( i % 2 === 0 ) {
		  // Odd positions are multiplied first.
		  n *= 2;
  
		  // If the multiplication is bigger than 10 we need to adjust
		  odd_sum += n < 10 ? n : n - 9;
  
		// Even positions
		// Just sum them
		} else {
		  even_sum += n;
		}
  
	  }
  
	  var control_digit = (10 - (even_sum + odd_sum).toString().substr(-1) );
	  var control_letter = 'JABCDEFGHI'.substr( control_digit, 1 );
  
	  // Control must be a digit
	  if ( letter.match( /[ABEH]/ ) ) {
		return control == control_digit;
  
	  // Control must be a letter
	  } else if ( letter.match( /[KPQS]/ ) ) {
		return control == control_letter;
  
	  // Can be either
	  } else {
		return control == control_digit || control == control_letter;
	  }
  
	};
  
	return ValidateSpanishID;
  })();
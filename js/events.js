//Buscar
function buscarTabla() {
  // Obtener el valor del campo de entrada
  var valorBuscado = document.getElementById("buscador").value.toLowerCase();
  
  // Obtener la tabla
  var tabla = document.getElementById("tbllistado");
  

  // Obtener todas las filas de la tabla, excepto la fila de encabezado
  var filas = tabla.querySelectorAll("tfoot tr");

  
  // Recorrer todas las filas de la tabla y comprobar si coinciden con el valor buscado
  for (var i = 0; i < filas.length; i++) {
    var mostrarFila = false;
    
    // Obtener todas las celdas de la fila actual
    var celdas = filas[i].getElementsByTagName("td");
    
    // Recorrer todas las celdas de la fila y comprobar si alguna coincide con el valor buscado
    for (var j = 0; j < celdas.length; j++) {
      var celda = celdas[j];
      if (celda) {
        var contenidoCelda = celda.innerHTML.toLowerCase();
        if (contenidoCelda.indexOf(valorBuscado) > -1) {
          mostrarFila = true;
          break;
        }
      }
    }
    
    // Mostrar u ocultar la fila según si se encontró una coincidencia o no
    if (mostrarFila) {
      filas[i].style.display = "";
    } else {
      filas[i].style.display = "none";
    }
  }
}

//Validaciones contraseña


function bloquearEspacio(event) {
    var tecla = event.keyCode || event.which;
    if (tecla == 32) {
        return false;
    }
    }

  function mostrarContrasena() {
    var contrasenaInput = document.getElementById("contraseña");
    var botonVerOcultar = document.getElementById("ver-ocultar");
    
    if (contrasenaInput.type === "password") {
      contrasenaInput.type = "text";
      botonVerOcultar.innerHTML = '<i class="zmdi zmdi-eye-off"></i>';
    } else {
      contrasenaInput.type = "password";
      botonVerOcultar.innerHTML = '<i class="zmdi zmdi-eye"></i>';
    }
  }

		function validarMayusculas(e) {
			var tecla = e.keyCode || e.which;
			var teclaFinal = String.fromCharCode(tecla).toUpperCase();
			var letras = /^[A-Z]+$/;

			if(!letras.test(teclaFinal)){
				e.preventDefault();
			}
		}


//Validar correo
function validarCorreo(event) {
  var correo = event.target.value;
  var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!regex.test(correo)) {
    event.target.setCustomValidity("Ingrese un correo electrónico válido");
  } else {
    event.target.setCustomValidity("");
  }
}







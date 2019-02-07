"use strict";

// VARIABLES E INICIALIZACIONES

var inputValor = document.getElementById("valor");
var spanMensajeError = document.getElementById("mensajeError");
var botonArrancar = document.getElementById("botonArrancar");
var botonParar = document.getElementById("botonParar");
var idTimeoutMensajeError;
var idIntervalProceso;

botonParar.disabled = true;



// HANDLERS (MANEJADORES) DE EVENTOS

function handleArrancarClick() {
    if (entradaEsValida()) {
        iniciarProcesoPotencias();
	    activarDesactivarBotones(false, true);
    }
}

function handlePararClick() {
    detenerProcesoPotencias();
    activarDesactivarBotones(true, false);
}

function handleReiniciarClick() {
    detenerProcesoPotencias();
    activarDesactivarBotones(true, false);
    ocultarAvisoYErrores();
    reiniciarValor();
}

function handleValorChangeOKeyUp() {
    cancelarMensajeError(); // Primero cancelamos el timeout

    // A continuación, ya valoramos si volver a programarlo, en cuyo caso se reiniciará la cuenta de tiempo.

    if (entradaEsValida()) {
    	ocultarAvisoYErrores();
	    activarDesactivarBotones(true, false);
    } else { // Entrada no válida
        mostrarAviso();
        programarMensajeError();
	    activarDesactivarBotones(false, false);
    }
}

function handleValorFocus() {
    activarDesactivarBotones(true, false); // Para el caso de que se metan con el proceso en marcha.
    detenerProcesoPotencias();
}

function handleValorBlur() {
    if (!entradaEsValida()) {
        cancelarMensajeError(); // Se cancela lo que haya programado.
        mostrarMensajeError(); // Y se muestra directamente
    }
}



// FUNCIONES PROPIAS

function reiniciarValor() {
	inputValor.value = 1;
}

function multiplicarValorX2() {
	inputValor.value = inputValor.value * 2;
}

function entradaEsPotenciaDe2(x) {
    var logaritmo = Math.log2(x); // Se obtiene el logaritmo binario del número.
    return logaritmo % 1 == 0; // Se indica si el logaritmo obtenido es entero o no. Si lo es, el número era potencia de 2.
}

function entradaEsValida() {
	var x = inputValor.value;
    return (!isNaN(x) && (x >= 1) && entradaEsPotenciaDe2(x));
}

function activarDesactivarBotones(botonIniciarActivo, botonPararActivo) {
	// Se les mete un not porque estar disabled es "lógica inversa".
    botonArrancar.disabled = !botonIniciarActivo;
    botonParar.disabled = !botonPararActivo;
}

function mostrarAviso() {
    inputValor.classList.add('aviso');
}

function mostrarMensajeError() {
    mostrarAviso(); // Por si no lo está (que es posible que no lo esté), porque activar el error implica activar el aviso.
    spanMensajeError.classList.remove("oculto");
}

function ocultarAvisoYErrores() {
    inputValor.classList.remove('aviso');
    spanMensajeError.classList.add("oculto");
}

function programarMensajeError() {
    idTimeoutMensajeError = setTimeout(mostrarMensajeError, 3000);
}

function cancelarMensajeError() {
    clearTimeout(idTimeoutMensajeError);
}

function iniciarProcesoPotencias() {
	idIntervalProceso = setInterval(multiplicarValorX2, 1000);
}

function detenerProcesoPotencias() {
	clearInterval(idIntervalProceso);
}
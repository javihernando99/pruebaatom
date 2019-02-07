<?php
	function conectar_bd() {
		$servidor = "localhost";
		$usuario = "admin";
		$csenna = "admin";
		$bd = "agenda";

		$conexion = mysqli_connect($servidor, $usuario, $csenna);

		if ($conexion) {
			loguear("Conectados correctamente con el servidor $servidor con usuario $usuario y contraseña $csenna.");
		} else {
			loguear("NO hemos podido conectar con el servidor $servidor con usuario $usuario y contraseña $csenna.");
		}

		if (mysqli_select_db( $conexion,$bd)) {
			loguear("Conectados correctamente con la BD $bd.");
		} else {
			loguear("NO hemos podido conectar con la BD $bd.");
		}

		return $conexion;
	}

	// Esto escribe en el error.log de Apache la variable recibida.
	function loguear($contenido) {
		file_put_contents("php://stderr", $contenido . "\n");
	}

	// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
	function redireccionar($url) {
		header("Location: $url");
		exit();
	}
?>
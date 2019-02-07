<?php
	require_once "_varios.php";
	$conexion = conectar_bd();

	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];
	$telefono = $_REQUEST["telefono"];
	$categoria_id = (int)$_REQUEST["categoria_id"];
	
	// Si id es -1 quieren INSERTAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren ACTUALIZAR la ficha de una persona existente
	// (y $nueva_entrada tomar false).
	$nueva_entrada = ($id == -1);	
	
	if ($nueva_entrada) {
		// Quieren CREAR una nueva entrada, así que es un INSERT.
 		$sentencia = "INSERT INTO persona (nombre, telefono, categoria_id) VALUES ('$nombre', '$telefono', $categoria_id)";
	} else {
		// Quieren MODIFICAR una persona existente y es un UPDATE.
 		$sentencia = "UPDATE persona SET nombre='$nombre', telefono='$telefono', categoria_id=$categoria_id WHERE id=$id";
 	}
 	
	//Este mysql_query devuelve true o false según si ha ido bien o mal.
 	$sql_con_exito = mysqli_query($conexion,$sentencia);

 	//Se consulta la cantidad de filas afectadas por la última sentencia sql.
 	$una_fila_afectada = (mysqli_affected_rows($conexion) == 1);
 	$ninguna_fila_afectada = (mysqli_affected_rows($conexion) == 0);
 	
 	// Está todo correcto de forma normal si NO ha habido errores
 	// y si se ha visto afectada UNA fila.
 	$correcto = ($sql_con_exito && $una_fila_afectada);
 	// Esto es lo mismo:
	//if ($sql_con_exito && $una_fila_afectada) $correcto = true;
	//else $correcto = false;

 	// Si los datos no se habían modificado, también está correcto.
 	$datos_no_modificados = ($sql_con_exito && $ninguna_fila_afectada);
 ?>



<html>

<head>
	<meta charset="UTF-8">
</head>

<body>

<?php
	// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
	if ($correcto || $datos_no_modificados) { ?>

		<?php if ($id == -1) { ?>
			<h1>Inserción completada</h1>
			<p>Se ha insertado correctamente la nueva entrada de <?php echo $nombre; ?>.</p>
		<?php } else { ?>
			<h1>Guardado completado</h1>
			<p>Se han guardado correctamente los datos de <?php echo $nombre; ?>.</p>

			<?php if ($datos_no_modificados) { ?>
				<p>En realidad, no había modificado nada, pero no está de más que se haya asegurado pulsando el botón de guardar :)</p>
			<?php } ?>
		<?php }
?>

<?php
	} else {
?>

	<h1>Error en la modificación.</h1>
	<p>No se han podido guardar los datos de la persona.</p>

<?php
	}
?>

<a href="listado-personas.php">Volver al listado de personas.</a>

</body>
</html>

<?php
	mysql_close($conexion);
?>
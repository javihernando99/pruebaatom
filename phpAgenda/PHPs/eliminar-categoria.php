<?php
	require_once "_varios.php";
	$conexion = conectar_bd();

	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	$consulta = "DELETE FROM categoria WHERE id=$id";

	//Este mysql_query devuelve true o false según si ha ido bien o mal.
 	$sql_con_exito = mysqli_query($conexion,$consulta);

 	//Se consulta la cantidad de filas afectadas por la ultima sentencia sql.
 	$una_fila_afectada = (mysqli_affected_rows($conexion) == 1);
 	$ninguna_fila_afectada = (mysqli_affected_rows($conexion) == 0);
 	
 	// Está todo correcto de forma normal si NO ha habido errores
 	// y si se ha visto afectada UNA fila.
 	$correcto = ($sql_con_exito && $una_fila_afectada);
 	// Esto es lo mismo:
	//if ($sql_con_exito && $una_fila_afectada) $correcto = true;
	//else $correcto = false;

 	// Caso raro: no había una categoría con esa id...
 	$no_existia = ($sql_con_exito && $ninguna_fila_afectada);
 ?>



<html>

<head>
	<meta charset="UTF-8">
</head>

<body>

<?php if ($correcto) { ?>

	<h1>Eliminación completada</h1>
	<p>Se ha eliminado correctamente la categoría.</p>

<?php } else if ($no_existia) { ?>

	<h1>Eliminación imposible</h1>
	<p>No existe la categoría que se pretende eliminar (¿ha manipulado Vd. el parámetro id?).</p>

<?php } else { ?>

	<h1>Error en la eliminación</h1>
	<p>No se ha podido eliminar la categoría o la categoría no existía.</p>

<?php } ?>

<a href="listado-categorias.php">Volver al listado de categorías.</a>

</body>
</html>

<?php
	mysql_close($conexion);
?>
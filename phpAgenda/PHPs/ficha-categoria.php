<?php
	require_once "_varios.php";
	$conexion = conectar_bd();
	
	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
	// (y $nueva_entrada tomará false).
	$nueva_entrada = ($id == -1);

	if ($nueva_entrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
		$categoria_nombre = "<introduzca nombre>";
	} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
		$consulta_categoria = "SELECT nombre FROM categoria WHERE id=$id";
		
		$rs_categoria = mysqli_query($conexion,$consulta_categoria);
		
		 // Con esto, se sitúa el ResultSet en la primera
		 // (y esperemos que única) fila que haya venido.
		$fila_categoria = mysqli_fetch_array($rs_categoria);
		
		$categoria_nombre = $fila_categoria["nombre"];
	}
?>



<html>

<head>
	<meta charset="UTF-8">
</head>

<body>

<?php if ($nueva_entrada) { ?>
	<h1>Nueva ficha de categoría</h1>
<?php } else { ?>
	<h1>Ficha de categoría</h1>
<?php } ?>

<form method="post" action="guardar-categoria.php">

<input type="hidden" name="id" value="<?=$id ?>" />

<ul>
	<li>
		<strong>Nombre: </strong>
		<input type="text" name="nombre" value="<?=$categoria_nombre ?>" />
	</li>
</ul>

<?php if ($nueva_entrada) { ?>
	<input type="submit" name="guardar" value="Crear categoría" />
<?php } else { ?>
	<input type="submit" name="guardar" value="Guardar cambios" />
<?php } ?>

</form>

<br />

<a href="eliminar-categoria.php?id=<?=$id ?>">Eliminar categoría</a>

<br />
<br />

<a href="listado-categorias.php">Volver al listado de categorías.</a>

</body>
</html>



<?php
	mysql_close($conexion);
?>
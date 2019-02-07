<?php
	require_once "_varios.php";
	$conexion = conectar_bd();
	
	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una persona existente
	// (y $nueva_entrada tomará false).
	$nueva_entrada = ($id == -1);
	
	if ($nueva_entrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
		$persona_nombre = "<introduzca nombre>";
		$persona_telefono = "<introduzca teléfono>";
		$persona_categoria_id = 0;
	} else { // Quieren VER la ficha de una persona existente, cuyos datos se cargan.
		$consulta_persona = "SELECT nombre, telefono, categoria_id FROM persona WHERE id=$id";
		
		$rs_persona = mysqli_query( $conexion,$consulta_persona);
		
		 // Con esto, se sitúa el ResultSet en la primera
		 // (y esperemos que única) fila que haya venido.
		$fila_persona = mysqli_fetch_array($rs_persona);
		
		$persona_nombre = $fila_persona["nombre"];
		$persona_telefono = $fila_persona["telefono"];
		$persona_categoria_id = $fila_persona["categoria_id"];
	}

	
	
	// Con lo siguiente se deja preparado un recordset con todas las categorias.
	
	$consulta_categorias = "SELECT id, nombre FROM categoria ORDER BY nombre";
	
	$rs_categorias = mysqli_query( $conexion,$consulta_categorias);
?>



<html>

<head>
	<meta charset="UTF-8">
</head>

<body>

<?php if ($nueva_entrada) { ?>
	<h1>Nueva ficha de persona</h1>
<?php } else { ?>
	<h1>Ficha de persona</h1>
<?php } ?>

<form method="post" action="guardar-persona.php">

<input type="hidden" name="id" value="<?= $id ?>" />

<ul>
	<li>
		<strong>Nombre: </strong>
		<input type="text" name="nombre" value="<?=$persona_nombre ?>" />
	</li>
	
	<li>
		<strong>Teléfono: </strong>
		<input type="text" name="telefono" value="<?=$persona_telefono ?>" />
	</li>
		
	<li>
		<strong>Categoría: </strong>
		<select name="categoria_id">
			<?php
				while ($fila_categoria = mysqli_fetch_array($rs_categorias)) {
					$categoria_id = $fila_categoria["id"];
					$categoria_nombre = $fila_categoria["nombre"];
					
					if ($categoria_id == $persona_categoria_id) $seleccion = "selected='true'";
					else $seleccion = "";
					
					echo "<option value='$categoria_id' $seleccion>$categoria_nombre</option>";
				}
			?>
		</select>
	</li>
</ul>

<?php if ($nueva_entrada) { ?>
	<input type="submit" name="guardar" value="Crear persona" />
<?php } else { ?>
	<input type="submit" name="guardar" value="Guardar cambios" />
<?php } ?>

</form>

<br />

<?php if (!$nueva_entrada) { ?>
	<a href="eliminar-persona.php?id=<?=$id ?>">Eliminar persona</a>
<?php } ?>

<br />
<br />

<a href="listado-personas.php">Volver al listado de personas.</a>

</body>
</html>



<?php
	mysqli_close($conexion);
?>
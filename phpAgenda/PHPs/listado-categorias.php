<?php
	require_once "_varios.php";

	$conexion = conectar_bd();
	
	$consulta = "SELECT id, nombre FROM categoria ORDER BY nombre";
		
	$rs = mysqli_query( $conexion,$consulta);
?>



<html>

<head>
	<meta charset="UTF-8">
</head>

<body>

<h1>Listado de Categorías</h1>

<table border="1">

	<tr>
		<th>Nombre</th>
	</tr>

	<?php
		while ($fila = mysqli_fetch_array($rs)) { ?>
			<tr>
				<td><a href="ficha-categoria.php?id=<?=$fila["id"] ?>"><?=$fila["nombre"] ?></a></td>
				<td><a href="eliminar-categoria.php?id=<?=$fila["id"] ?>">(X)</a></td>
			</tr>
	<?php } ?>

</table>

<br />

<a href="ficha-categoria.php?id=-1">Crear entrada</a>

<br />
<br />

<a href="listado-personas.php">Gestionar listado de Personas</a>

</body>

</html>

<?php
	mysqli_close($conexion);
?>
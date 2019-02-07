<?php
	require_once "_varios.php";

	$conexion = conectar_bd();

	$consulta = "SELECT
					p.id     AS p_id,
					p.nombre AS p_nombre,
					c.id     AS c_id,
					c.nombre AS c_nombre
				 FROM
					persona AS p INNER JOIN categoria AS c
					ON p.categoria_id = c.id
				 ORDER BY p.nombre";
	//$consulta = "SELECT id, nombre, categoria_id FROM persona ORDER BY nombre";

	$rs = mysqli_query($conexion,$consulta);
?>



<html>

<head>
	<meta charset="UTF-8">
</head>

<body>

<h1>Listado de Personas</h1>

<table border="1">

	<tr>
		<th>Nombre</th>
		<th>Categoría</th>
	</tr>

	<?php
		while ($fila = mysqli_fetch_array($rs)) { ?>
			<tr>
				<td><a href=   "ficha-persona.php?id=<?= $fila["p_id"] ?>">   <?= $fila["p_nombre"] ?>   </a></td>
				<td><a href= "ficha-categoria.php?id=<?= $fila["c_id"] ?>">   <?= $fila["c_nombre"] ?>   </a></td>
				<td><a href="eliminar-persona.php?id=<?= $fila["p_id"] ?>">   (X)                        </a></td>
			</tr>
	<?php } ?>

</table>

<br />

<a href="ficha-persona.php?id=-1">Crear entrada</a>

<br />
<br />

<a href="listado-categorias.php">Gestionar listado de Categorías</a>

</body>

</html>



<?php
	mysqli_close($conexion);
?>
<?php
$conexion = mysqli_connect("localhost", "root", "root", "personas");

$sql = "SELECT * FROM personas";
$resultado = mysqli_query($conexion, $sql);

while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila['id'] . "</td>";
    echo "<td>" . $fila['nombre'] . "</td>";
    echo "<td>" . $fila['apellido'] . "</td>";
    echo "<td>" . $fila['edad'] . "</td>";
    echo "<td>" . $fila['telefono'] . "</td>";
    echo "<td>" . $fila['email'] . "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($conexion);
?>

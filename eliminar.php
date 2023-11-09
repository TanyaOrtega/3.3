<?php

$dsn = 'mysql:host=localhost;dbname=personas';
$usuario = 'root';
$contraseña = 'root';
$opciones = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$conexion = new PDO($dsn, $usuario, $contraseña, $opciones);


$id = $_POST['id'];

// Eliminar de la base de datos
$consulta = "DELETE FROM personas WHERE id = :id";
$statement = $conexion->prepare($consulta);
$statement->bindParam(':id', $id);
$statement->execute();

echo json_encode(['success' => true, 'id' => $id]);
?>

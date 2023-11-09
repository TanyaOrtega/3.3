<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "personas";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}


$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = $_POST['edad'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];

$query = "UPDATE personas SET nombre='$nombre', apellido='$apellido', edad='$edad', telefono='$telefono', email='$email' WHERE id='$id'";

if(mysqli_query($conn, $query)) {
  echo "Actualización exitosa";
  echo "<script>alert('Datos actualizados correctamente');</script>";

  } else {
  echo "Error al actualizar: " . mysqli_error($conn);
  }
?>


<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "root";
$database = "personas";
$mysqli = new mysqli($host, $user, $password, $database);

// Verificar si la conexión fue exitosa
if ($mysqli->connect_errno) {
  echo "Lo siento, este sitio web está experimentando problemas.";
  echo "Error: Fallo al conectarse a MySQL debido a: \n";
  echo "Errno: " . $mysqli->connect_errno . "\n";
  echo "Error: " . $mysqli->connect_error . "\n";
  exit;
}

// Obtener la consulta de búsqueda del cliente
$busqueda = $_POST['busqueda'];

// Consulta a la base de datos
$sql = "SELECT * FROM personas WHERE nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%'";

if ($result = $mysqli->query($sql)) {
  // Crear un array para almacenar los resultados
  $resultArray = array();
  // Iterar sobre los resultados y almacenarlos en el array
  while ($row = $result->fetch_assoc()) {
    $resultArray[] = $row;
  }
  // Devolver los resultados en formato JSON
  echo json_encode($resultArray);
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>



<?php
$mysqli = new mysqli("localhost", "root", "root", "personas");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$xml = simplexml_load_file('usuarios.xml');

foreach ($xml->persona as $persona) {
    $nombre = $persona->nombre;
    $apellido = $persona->apellido;
    $edad = $persona->edad;
    $telefono = $persona->telefono;
    $email = $persona->email;

    $query = "INSERT INTO personas (nombre, apellido, edad, telefono, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssiss", $nombre, $apellido, $edad, $telefono, $email);
    $result = $stmt->execute();
    if ($result === false) {
        echo "Error en la consulta SQL: " . $stmt->error;
    } else {
        echo "Datos insertados correctamente en la base de datos.";
    }
    $stmt->close();
}

$mysqli->close();

$mysqli = new mysqli('localhost', 'root', 'root', 'personas');

if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

$query = "SELECT * FROM personas";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . "<br>";
        echo "Nombre: " . $row['nombre'] . "<br>";
        echo "Apellido: " . $row['apellido'] . "<br>";
        echo "Edad: " . $row['edad'] . "<br>";
        echo "Teléfono: " . $row['telefono'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "---------------<br>";
    }
} else {
    echo "No se encontraron registros.";
}

$mysqli->close();

?>


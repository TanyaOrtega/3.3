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

if (isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $edad = $_POST['edad'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $query = "INSERT INTO personas (nombre, apellido, edad, telefono, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiss", $nombre, $apellido, $edad, $telefono, $email);
    $result = $stmt->execute();
    if ($result === false) {
        $_SESSION['mensaje'] = "Error en la consulta SQL: " . $stmt->error;
    } else {
        header("Location: index.php?insertado=1");
        exit(); 
    }

    $stmt->close();
}

$conn->close();

if (isset($_SESSION['mensaje'])) {
    echo "<script>alert('" . $_SESSION['mensaje'] . "')</script>";
    unset($_SESSION['mensaje']);
}
?>

<script>
  const formulario = document.querySelector("form");
  const guardarBtn = document.querySelector("#guardar");
  guardarBtn.addEventListener("click", function(event) {
if (!formulario.nombre.value || !formulario.apellido.value || !formulario.edad.value || !formulario.telefono.value || !formulario.email.value) {
    alert("Debe completar todos los campos antes de guardar");
    event.preventDefault();
  }
});


 </script>






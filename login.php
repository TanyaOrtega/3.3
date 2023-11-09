<!DOCTYPE html>
<html>
<head>
	<title>Iniciar sesión</title>
      <head>
        <title>Iniciar sesión</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      </head>
      <script>
        $(document).ready(function() {
    $('h1').css('text-align', 'center'); 
    $('form').css({
        'width': '400px',
        'margin': 'auto',
        'border': '1px solid #ccc',
        'padding': '20px',
        'border-radius': '5px'
    }); 
    $('form label').css('display', 'block'); 
    $('form input').css({
        'width': '100%',
        'padding': '10px',
        'margin-bottom': '10px',
        'border-radius': '5px',
        'border': '1px solid #ccc'
    }); 
    $('form button').css({
        'background-color': '#4CAF50',
        'color': '#fff',
        'padding': '10px 20px',
        'border': 'none',
        'border-radius': '5px',
        'cursor': 'pointer'
    }); 
});
      </script>
<body>
<h1>Iniciar sesión</h1>
    <form method="POST" action="login.php">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>

        <label for="token">Token:</label>
        <input type="text" name="token" required>

        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>

<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "personas";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];
    $token = $_POST['token'];

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE username = :username AND password = :password AND token = :token');
    $stmt->execute([
        ':username' => $username,
        ':password' => $password,
        ':token' => $token
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    $_SESSION['user_id'] = $user['id'];
    header('Location: /3.3');
    exit;
        } else {
    echo 'Usuario, token o contraseña incorrectos';
        }
    }
?>



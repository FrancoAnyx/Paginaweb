<?php
// Inicializar la variable para almacenar el mensaje de error
$loginError = "";

// Verificar si se enviaron datos de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el nombre de usuario y la contraseña del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Leer el archivo JSON de usuarios
    $usuariosJSON = file_get_contents("usuarios.json");
    $usuarios = json_decode($usuariosJSON, true);

    // Verificar las credenciales
    foreach ($usuarios["usuarios"] as $usuario) {
        if ($usuario["username"] === $username && $usuario["password"] === $password) {
            // Las credenciales son correctas, redirigir al usuario a la página principal
            header("Location: index.html");
            exit; // Detener la ejecución del script después de redirigir
        }
    }

    // Si llegamos aquí, las credenciales son incorrectas, establecer el mensaje de error
    $loginError = "Nombre de usuario o contraseña incorrectos.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<style>
        /* Estilos para el formulario */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        #login-form {
            width: 300px;
            margin: 100px auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Iniciar sesión">
    </form>
    
    <!-- Mostrar mensaje de error si existe -->
    <?php if (!empty($loginError)) { ?>
        <p style="color: red;"><?php echo $loginError; ?></p>
    <?php } ?>
</body>
</html>

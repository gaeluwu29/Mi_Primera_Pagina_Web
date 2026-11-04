
<?php

session_start();

require_once __DIR__ . '/../config/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $correo = trim($_POST["correo"] ?? "");
    $clave = $_POST["password"] ?? "";

    $consulta = $conexion->prepare("
        SELECT id, nombre, correo, password, rol
        FROM usuarios
        WHERE correo = ?
    ");

    $consulta->execute([$correo]);

    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($clave, $usuario["password"])) {

        session_regenerate_id(true);

        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["usuario_nombre"] = $usuario["nombre"];
        $_SESSION["usuario_correo"] = $usuario["correo"];
        $_SESSION["usuario_rol"] = $usuario["rol"];

        header("Location: panel.php");
        exit;

    } else {

        $mensaje = "Correo o contraseña incorrectos.";

    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión</title>

    <link rel="stylesheet" href="../css/usuarios.css">
</head>

<body>

    <div class="contenedor">

        <h1>Iniciar sesión</h1>

        <?php if ($mensaje !== ""): ?>
            <p class="mensaje">
                <?= htmlspecialchars($mensaje) ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <label for="correo">Correo electrónico:</label>

            <input
                type="email"
                id="correo"
                name="correo"
                required
            >

            <label for="password">Contraseña:</label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

            <button type="submit">
                Entrar
            </button>

        </form>

        <p>
            ¿No tienes cuenta?
            <a href="registro.php">Regístrate aquí</a>
        </p>

        <p>
            <a href="../index.html">Volver a la página principal</a>
        </p>

    </div>

</body>
</html>


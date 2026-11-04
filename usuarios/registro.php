
<?php
require_once __DIR__ . '/../config/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmar = $_POST["confirmar"] ?? "";

    if ($nombre === "" || $correo === "" || $password === "" || $confirmar === "") {

        $mensaje = "Todos los campos son obligatorios.";

    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

        $mensaje = "El correo electrónico no es válido.";

    } elseif (strlen($password) < 8) {

        $mensaje = "La contraseña debe tener al menos 8 caracteres.";

    } elseif ($password !== $confirmar) {

        $mensaje = "Las contraseñas no coinciden.";

    } else {

        $consulta = $conexion->prepare(
            "SELECT id FROM usuarios WHERE correo = ?"
        );

        $consulta->execute([$correo]);

        if ($consulta->fetch()) {

            $mensaje = "Este correo ya está registrado.";

        } else {

            $passwordHash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $insertar = $conexion->prepare(
                "INSERT INTO usuarios (nombre, correo, password)
                VALUES (?, ?, ?)"
            );

            $insertar->execute([
                $nombre,
                $correo,
                $passwordHash
            ]);

            $mensaje = "¡Usuario registrado correctamente!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro de usuarios</title>

    <link rel="stylesheet" href="../css/usuarios.css">
    <script src="../js/validaciones.js" defer></script>
</head>

<body>

    <div class="contenedor">

        <h1>Crear una cuenta</h1>

        <?php if ($mensaje !== ""): ?>
            <p class="mensaje">
                <?= htmlspecialchars($mensaje) ?>
            </p>
        <?php endif; ?>

        <form method="POST" id="formRegistro">

            <label for="nombre">Nombre:</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                maxlength="100"
                required
            >

            <label for="correo">Correo electrónico:</label>
            <input
                type="email"
                id="correo"
                name="correo"
                maxlength="150"
                required
            >

            <label for="password">Contraseña:</label>
            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                required
            >

            <label for="confirmar">Confirmar contraseña:</label>
            <input
                type="password"
                id="confirmar"
                name="confirmar"
                minlength="8"
                required
            >

            <button type="submit">Registrarme</button>

        </form>

        <p>
            ¿Ya tienes cuenta?
            <a href="login.php">Iniciar sesión</a>
        </p>

        <p>
            <a href="../index.html">Volver a la página principal</a>
        </p>

    </div>

</body>
</html>

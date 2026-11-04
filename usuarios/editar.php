
<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION["usuario_rol"] ?? "") !== "admin") {
    http_response_code(403);
    die("Acceso denegado.");
}

require_once __DIR__ . '/../config/conexion.php';

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("ID de usuario no válido.");
}

$consulta = $conexion->prepare(
    "SELECT id, nombre, correo FROM usuarios WHERE id = ?"
);
$consulta->execute([$id]);

$usuario = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $correo = trim($_POST["correo"] ?? "");

    if ($nombre === "" || $correo === "") {
        $mensaje = "Todos los campos son obligatorios.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo no es válido.";
    } else {
        try {
            $actualizar = $conexion->prepare(
                "UPDATE usuarios
                SET nombre = ?, correo = ?
                WHERE id = ?"
            );

            $actualizar->execute([$nombre, $correo, $id]);

            header("Location: panel.php");
            exit;

        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $mensaje = "Ese correo ya está registrado.";
            } else {
                $mensaje = "No fue posible actualizar el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>
    <link rel="stylesheet" href="../css/usuarios.css">
</head>
<body>

<div class="contenedor">
    <h1>Editar usuario</h1>

    <?php if ($mensaje !== ""): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            value="<?= htmlspecialchars($usuario["nombre"]) ?>"
            maxlength="100"
            required
        >

        <label for="correo">Correo electrónico:</label>
        <input
            type="email"
            id="correo"
            name="correo"
            value="<?= htmlspecialchars($usuario["correo"]) ?>"
            maxlength="150"
            required
        >

        <button type="submit">Guardar cambios</button>
    </form>

    <p><a href="panel.php">Volver al panel</a></p>
</div>

</body>
</html>

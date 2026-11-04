
<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION["usuario_rol"] ?? "") !== "admin") {
    die("Acceso denegado. No tienes permisos de administrador.");
}

require_once __DIR__ . '/../config/conexion.php';

$consulta = $conexion->query(
    "SELECT id, nombre, correo, rol, fecha_registro
    FROM usuarios
    ORDER BY id DESC"
);

$usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de usuarios</title>
    <link rel="stylesheet" href="../css/usuarios.css">
</head>
<body>

<div class="contenedor">
    <h1>Panel de administración</h1>

    <p>
        Bienvenido,
        <?= htmlspecialchars($_SESSION["usuario_nombre"]) ?>
    </p>

    <p>Usuarios registrados: <?= count($usuarios) ?></p>

    <h2>Lista de usuarios</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars((string)$usuario["id"]) ?></td>
                    <td><?= htmlspecialchars($usuario["nombre"]) ?></td>
                    <td><?= htmlspecialchars($usuario["correo"]) ?></td>
                    <td><?= htmlspecialchars($usuario["rol"]) ?></td>
                    <td><?= htmlspecialchars($usuario["fecha_registro"]) ?></td>

                    <td>
                        <a href="editar.php?id=<?= (int)$usuario['id'] ?>">
                            Editar
                        </a>

                        <?php if ((int)$usuario["id"] !== (int)$_SESSION["usuario_id"]): ?>
                            <form action="eliminar.php" method="POST"
                                    onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int)$usuario['id'] ?>"
                                >

                                <button type="submit">Eliminar</button>
                            </form>
                        <?php else: ?>
                            <span>Tu cuenta</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <a href="logout.php">Cerrar sesión</a>
</div>

</body>
</html>




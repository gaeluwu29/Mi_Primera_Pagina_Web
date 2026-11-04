
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

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: panel.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("ID de usuario no válido.");
}

if ($id == $_SESSION["usuario_id"]) {
    die("No puedes eliminar tu propia cuenta mientras tienes la sesión activa.");
}

// Eliminar usuario
$eliminar = $conexion->prepare(
    "DELETE FROM usuarios WHERE id = ?"
);

$eliminar->execute([$id]);

header("Location: panel.php");
exit;
?>

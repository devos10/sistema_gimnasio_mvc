<?php
declare(strict_types=1);
/** @var string $mensaje */
/** @var string $appName */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>404 - <?= htmlspecialchars($appName) ?></title>
</head>
<body>
    <h1>404 - Página no encontrada</h1>
    <p><?= htmlspecialchars($mensaje) ?></p>

    <p><a href="index.php?controlador=home&accion=index">Ir al inicio</a></p>
</body>
</html>
<?php
?>
<!DOCTYPE html>
<html lang="es">

<?php include_once (APP_URL.'Views/partials/head.php');?>

<body>

  <div class="login-box">
    <h2><?= htmlspecialchars($titulo)?></h2>
    <form action="?controlador=login&accion=verificar" method="POST">
      <div class="mb-3">
        <input type="text" class="form-control" placeholder="Usuario" name="usuario"
        value="<?= htmlspecialchars($old['usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
      </div>
      <div class="mb-4">
        <input type="password" class="form-control" name="password" placeholder="Contraseña">
      </div>
      <button type="submit" class="btn btn-login text-white w-100">Entrar</button>
    </form>
  </div>

</body>

</html>
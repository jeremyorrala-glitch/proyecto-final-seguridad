<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['otp_codigo'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$exito = false;

if (isset($_GET['reenviar'])) {
    header('Location: enviar_otp.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_ingresado = trim($_POST['codigo']);

    if (time() > $_SESSION['otp_expira']) {
        $error = "El codigo ha expirado. Solicita uno nuevo.";
    } elseif ($_SESSION['otp_intentos'] >= 3) {
        $error = "Numero de intentos agotado. Vuelve a iniciar el proceso.";
        session_unset();
        session_destroy();
    } elseif ($codigo_ingresado === $_SESSION['otp_codigo']) {
        // Codigo correcto: acceso concedido
        $_SESSION['autenticado'] = true;
        $exito = true;
    } else {
        $_SESSION['otp_intentos']++;
        $error = "Codigo incorrecto. Intento {$_SESSION['otp_intentos']} de 3.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificacion en 2 pasos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="contenedor">
        <?php if ($exito): ?>
            <h2>Acceso concedido</h2>
            <p class="mensaje-info">Sesion iniciada correctamente en el sistema transaccional.</p>
        <?php else: ?>
            <h2>Verificacion en 2 pasos</h2>
            <p class="mensaje-info">Hemos enviado un codigo a tu celular registrado.</p>
            <form method="POST" action="verificar_otp.php">
                <input type="text" name="codigo" placeholder="Codigo de 6 digitos" maxlength="6" required>
                <button type="submit">Verificar</button>
            </form>
            <?php if ($error): ?>
                <p class="mensaje-error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <p class="mensaje-info"><a href="verificar_otp.php?reenviar=1">Reenviar codigo</a></p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verificar si la cuenta esta bloqueada temporalmente
        if ($user['bloqueado_hasta'] && strtotime($user['bloqueado_hasta']) > time()) {
            $error = "Cuenta bloqueada temporalmente. Intenta de nuevo mas tarde.";
        } elseif (password_verify($password, $user['password'])) {
            // Credenciales correctas: reiniciar contador de intentos
            $pdo->prepare("UPDATE usuarios SET intentos_fallidos = 0, bloqueado_hasta = NULL WHERE id = ?")
                ->execute([$user['id']]);

            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['celular'] = $user['celular'];

            header('Location: enviar_otp.php');
            exit;
        } else {
            // Credenciales incorrectas: incrementar contador
            $intentos = $user['intentos_fallidos'] + 1;
            if ($intentos >= 3) {
                $pdo->prepare("UPDATE usuarios SET intentos_fallidos = ?, bloqueado_hasta = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE id = ?")
                    ->execute([$intentos, $user['id']]);
                $error = "Has superado el numero de intentos permitidos. Cuenta bloqueada 15 minutos.";
            } else {
                $pdo->prepare("UPDATE usuarios SET intentos_fallidos = ? WHERE id = ?")
                    ->execute([$intentos, $user['id']]);
                $error = "Usuario o contraseña incorrectos. Intento $intentos de 3.";
            }
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema Transaccional</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="contenedor">
        <h2>Iniciar Sesion</h2>
        <form method="POST" action="login.php">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <?php if ($error): ?>
            <p class="mensaje-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <p class="mensaje-info">¿No tienes cuenta? <a href="registro.php">Registrate aqui</a></p>
    </div>
</body>
</html>

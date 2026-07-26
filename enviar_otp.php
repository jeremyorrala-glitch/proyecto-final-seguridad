<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

// Generar codigo OTP de 6 digitos
$codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

$_SESSION['otp_codigo'] = $codigo;
$_SESSION['otp_expira'] = time() + (3 * 60); // vigencia de 3 minutos
$_SESSION['otp_intentos'] = 0;

// --- SIMULACION DE ENVIO POR SMS ---
// En un entorno real aqui se integraria un proveedor de SMS (Twilio, AWS SNS, etc.)
// Para esta simulacion, el codigo se registra en el log del servidor.
error_log("[SIMULACION SMS] Codigo OTP para celular {$_SESSION['celular']}: $codigo");

header('Location: verificar_otp.php');
exit;

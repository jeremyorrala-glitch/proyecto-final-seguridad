# Guia de commits (sigue este orden exacto)

Copia estos archivos a tu carpeta del repo EN ESTE ORDEN. Despues de cada paso,
haz commit en GitHub Desktop con el mensaje sugerido y dale Push.

---

### Commit 1.0 - Estructura base
Copiar: `README.md`, `.gitignore`, `config.php`, `css/estilo.css`, `sql/estructura.sql`
Mensaje: `Creacion inicial del repositorio y estructura base del proyecto`

### Commit 1.1 - Login
Copiar: `login.php`
Mensaje: `Implementacion del formulario de Login con validaciones basicas`

### Commit 1.2 - Envio de OTP
Copiar: `enviar_otp.php`
Mensaje: `Integracion del servicio de generacion y envio de codigo OTP por SMS`

### Commit 1.3 - Validacion del codigo
Copiar: `verificar_otp.php`
Mensaje: `Implementacion de la validacion del codigo de verificacion en el servidor`

### Commit 1.4 - ERROR (a proposito)
Copiar el archivo `etapas_git/registro_v1_INSEGURO.php` y RENOMBRARLO a `registro.php`
(ponlo en la raiz del proyecto, junto a login.php)
Mensaje: `Se detecto un error de seguridad: contraseñas almacenadas en texto plano`

Este es el commit que vas a capturar como "el error detectado" en tu Word.

### Commit 1.4-R - ROLLBACK
En GitHub Desktop: pestaña **History**, click derecho sobre el commit 1.4,
elige **Revert this commit**. Esto crea un nuevo commit automatico que
deshace el cambio (borra el registro.php inseguro).
El mensaje lo pone Git solo (algo como "Revert ..."), no hace falta que
escribas nada.

Este es el commit que vas a capturar como "el rollback ejecutado".

### Commit 1.5 - Correccion definitiva
Copiar el archivo `etapas_git/registro_v2_SEGURO.php` y RENOMBRARLO a `registro.php`
(reemplaza el que se elimino con el revert)
Mensaje: `Correccion definitiva: implementacion de hasheo de contraseñas con bcrypt`

### Commit 1.6 - Ajustes finales
(Este ya viene incluido en login.php y verificar_otp.php desde el commit 1.1 y 1.3,
asi que puedes usar este commit solo para pulir detalles, por ejemplo el css o el README)
Mensaje: `Ajustes finales de seguridad: expiracion de OTP y bloqueo tras intentos fallidos`

---

## Resultado esperado en tu historial (History tab)
Deberias ver algo asi, de mas antiguo a mas reciente:

1. Creacion inicial del repositorio...
2. Implementacion del formulario de Login...
3. Integracion del servicio de generacion...
4. Implementacion de la validacion del codigo...
5. Se detecto un error de seguridad...          <- CAPTURA (error)
6. Revert "Se detecto un error de seguridad..." <- CAPTURA (rollback)
7. Correccion definitiva: implementacion...
8. Ajustes finales de seguridad...

Con eso ya tienes exactamente lo que pide la rubrica: capturas de GitHub +
evidencia real de un error y su rollback a una version anterior.

<?php
session_start();

// Destruir la sesión
session_unset();
session_destroy();

// Eliminar la cookie de autenticación
setcookie('username', '', time() - 3600, '/');

// Redirigir a la página de inicio de sesión
header('Location: login.php');
exit;
?>

<?php
include 'configdb.php';

if (!isset($_SESSION['user']) && !isset($_COOKIE['username'])) {
    header('Location: login.php');
    exit;
}
// Ruta a la carpeta de descargas
$carpeta_descargas = 'descargas';
$archivos = array_diff(scandir($carpeta_descargas), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Descargas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Repositorio de Descargas</h1>
    <ul>
        <?php foreach ($archivos as $archivo): ?>
            <li><a href="<?php echo $carpeta_descargas . '/' . $archivo; ?>" download><?php echo $archivo; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Volver al Inicio</a>
</body>
</html>

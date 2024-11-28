<?php
session_start();

// Verificar si la sesión está activa o la cookie de autenticación está presente
if (!isset($_SESSION['user']) && !isset($_COOKIE['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        nav {
            text-align: center;
            margin-top: 20px;
        }
        nav ul {
            list-style: none;
            padding: 0;
            display: inline-flex;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }
        nav ul li a:hover {
            color: #0056b3;
        }
        .logout {
            margin-top: 20px;
            text-align: center;
        }
        .logout a {
            text-decoration: none;
            color: red;
            font-weight: bold;
        }
        .logout a:hover {
            color: darkred;
        }
    </style>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['user']; ?></h1>
    <nav>
        <ul>
            <li><a href="alta.php">Registrar Mantenimiento</a></li>
            <li><a href="consulta.php">Consultar Historial de Equipos</a></li>
            <li><a href="descarga.php">Descargar Datos</a></li>
        </ul>
    </nav>
    
    <!-- Opción para cerrar sesión -->
    <div class="logout">
        <a href="logout.php">Cerrar sesión</a>
    </div>
</body>
</html>

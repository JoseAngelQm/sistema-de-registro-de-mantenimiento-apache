<?php
include 'configdb.php';

$historial = []; // Variable para almacenar los resultados de la consulta
$error = null; // Variable para manejar errores

if (!isset($_SESSION['user']) && !isset($_COOKIE['username'])) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo_equipo'];

    // Consultar el nombre del equipo asociado al código
    $stmt = $pdo->prepare("SELECT nombre_equipo FROM catalogo_equipos WHERE codigo_equipo = ?");
    $stmt->execute([$codigo]);
    $equipo = $stmt->fetch();

    if ($equipo) {
        $nombre_equipo = $equipo['nombre_equipo'];

        // Consultar el historial de mantenimiento
        $stmt = $pdo->prepare("SELECT descripcion, fecha_mantenimiento FROM equipos WHERE nombre_equipo = ?");
        $stmt->execute([$nombre_equipo]);
        $historial = $stmt->fetchAll();
    } else {
        $error = "No se encontró un equipo con el código ingresado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Consulta de Historial de Equipos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }
        form {
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input {
            width: calc(100% - 20px);
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
        }
        .link-button {
            display: block;
            text-align: center;
            text-decoration: none;
            background: #28a745;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .link-button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <h2>Consulta de Historial de Equipos</h2>
    <form method="POST">
        <input type="text" name="codigo_equipo" placeholder="Código del equipo" required>
        <button type="submit">Consultar</button>
        <a href="dashboard.php" class="link-button">Volver al Dashboard</a>
    </form>
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php elseif (!empty($historial)): ?>
        <h3>Historial de Mantenimiento, <?php echo $nombre_equipo; ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $registro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($registro['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($registro['fecha_mantenimiento']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No se encontraron registros para este equipo.</p>
    <?php endif; ?>
</body>
</html>

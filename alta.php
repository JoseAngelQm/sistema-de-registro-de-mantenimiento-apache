<?php
include 'configdb.php';

$success = null; // Inicializar la variable para controlar el estado del registro
if (!isset($_SESSION['user']) && !isset($_COOKIE['username'])) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = trim($_POST['codigo_equipo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha = $_POST['fecha_mantenimiento'];

    // Verificar que el código no esté vacío
    if (empty($codigo)) {
        $success = "El código del equipo no puede estar vacío.";
    } else{
        // Consultar el nombre del equipo basado en el código ingresado
        $stmt = $pdo->prepare("SELECT nombre_equipo FROM catalogo_equipos WHERE codigo_equipo = ?");
        $stmt->execute([$codigo]);
        $equipo = $stmt->fetch();

        if ($equipo) {
            $nombre_equipo = $equipo['nombre_equipo'];

            // Insertar el registro en la tabla equipos
            $stmt = $pdo->prepare("INSERT INTO equipos (codigo_equipo,nombre_equipo, descripcion, fecha_mantenimiento) VALUES (?,?, ?, ?)");
            if ($stmt->execute([$codigo,$nombre_equipo, $descripcion, $fecha])) {
                $success = "Actividad de mantenimiento registrada exitosamente.";
            } else {
                $success = "Hubo un error al registrar la actividad de mantenimiento";
            }
        } else {
            $success = "El código ingresado no corresponde a ningún equipo.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Alta de Equipos</title>
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
        h2 {
            text-align: center;
            color: #333;
        }
        input, textarea {
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
            margin-bottom: 10px;
        }
        button:hover {
            background: #0056b3;
        }
        .success {
            color: green;
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
    <script>
        function obtenerNombreEquipo() {
            const codigo = document.getElementById("codigo_equipo").value;

            if (codigo) {
                fetch(`obtener_nombre_equipo.php?codigo=${codigo}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.nombre) {
                            document.getElementById("nombre_equipo").value = data.nombre;
                        } else {
                            document.getElementById("nombre_equipo").value = "No encontrado";
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }
        }
    </script>
</head>
<body>
    <h2>Registro de actividad de mantenimiento</h2>
    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
        <a href="dashboard.php" class="link-button">Volver al Inicio</a>
    <?php else: ?>
        <form method="POST">
            <input type="text" id="codigo_equipo" name="codigo_equipo" placeholder="Código del equipo" oninput="obtenerNombreEquipo()" required>
            <input type="text" id="nombre_equipo" name="nombre_equipo" placeholder="Nombre del equipo" readonly>
            <textarea name="descripcion" placeholder="Descripción" required></textarea>
            <input type="date" name="fecha_mantenimiento" required>
            <button type="submit">Registrar</button>
        </form>
    <?php endif; ?>
</body>
</html>

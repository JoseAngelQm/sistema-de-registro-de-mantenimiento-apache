<?php
include 'configdb.php';

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $stmt = $pdo->prepare("SELECT nombre_equipo FROM catalogo_equipos WHERE codigo_equipo = ?");
    $stmt->execute([$codigo]);
    $equipo = $stmt->fetch();

    if ($equipo) {
        echo json_encode(['nombre' => $equipo['nombre_equipo']]);
    } else {
        echo json_encode(['nombre' => null]);
    }
}
?>

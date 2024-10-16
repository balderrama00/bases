<?php
$cx = new mysqli('localhost', 'root', '');
if ($cx->connect_error) {
    die('Error de conexión');
}

switch ($_GET['accion']) {
    case 'bases':
        obtenerBases($cx);
        break;
    case 'tablas':
        if (isset($_GET['base'])) {
            obtenerTablas($cx, $_GET['base']);
        }
        break;
}

$cx->close();

function obtenerBases($cx) {
    $consulta = $cx->query('SHOW DATABASES');
    $bases = [];
    while ($fila = $consulta->fetch_array()) {
        $bases[] = $fila[0];
    }
    echo json_encode($bases);
}

function obtenerTablas($cx, $base) {
    $cx->select_db($base);
    $consulta = $cx->query('SHOW TABLES');
    $tablas = [];
    while ($fila = $consulta->fetch_array()) {
        $tablas[] = $fila[0];
    }
    echo json_encode($tablas);
}
?>

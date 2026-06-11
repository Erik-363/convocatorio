<?php
include("../modelos/conexion.php");

if (!isset($_GET['aerolinea_id'])) {
    exit();
}

$aerolinea_id = intval($_GET['aerolinea_id']);

$stmt = $conexion->prepare("
    SELECT DISTINCT ciudades.id, ciudades.nombre 
    FROM ciudades
    JOIN aerolinea_ciudad ON ciudades.id = aerolinea_ciudad.ciudad_id
    WHERE aerolinea_ciudad.aerolinea_id = ?
    ORDER BY ciudades.nombre ASC
");

if (!$stmt) {
    exit();
}

$stmt->bind_param("i", $aerolinea_id);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
}

$stmt->close();
?>
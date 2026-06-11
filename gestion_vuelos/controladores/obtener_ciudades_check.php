<?php
include("../modelos/conexion.php");

if (!isset($_GET['aerolinea_id'])) {
    echo json_encode([]);
    exit();
}

$aerolinea_id = intval($_GET['aerolinea_id']);

$stmt = $conexion->prepare("
    SELECT ciudad_id 
    FROM aerolinea_ciudad
    WHERE aerolinea_id = ?
");

if (!$stmt) {
    echo json_encode([]);
    exit();
}

$stmt->bind_param("i", $aerolinea_id);
$stmt->execute();
$result = $stmt->get_result();

$ciudades = [];
while($row = $result->fetch_assoc()) {
    $ciudades[] = $row['ciudad_id'];
}

$stmt->close();

header('Content-Type: application/json');
echo json_encode($ciudades);
?>
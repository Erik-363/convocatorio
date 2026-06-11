<?php
session_start();
include("../modelos/conexion.php");

// Validar datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aerolinea_id = isset($_POST['aerolinea']) ? intval($_POST['aerolinea']) : 0;
    $origen_id = isset($_POST['origen']) ? intval($_POST['origen']) : 0;
    $destino_id = isset($_POST['destino']) ? intval($_POST['destino']) : 0;
    $fecha_ida = isset($_POST['fecha_ida']) ? $_POST['fecha_ida'] : '';
    $fecha_regreso = isset($_POST['fecha_regreso']) ? $_POST['fecha_regreso'] : null;
    $pasajeros = isset($_POST['pasajeros']) ? intval($_POST['pasajeros']) : 0;

    // Validaciones
    if ($aerolinea_id <= 0 || $origen_id <= 0 || $destino_id <= 0 || empty($fecha_ida) || $pasajeros <= 0) {
        $_SESSION['error'] = "Por favor completa todos los campos requeridos.";
        header("Location: ../index.php");
        exit();
    }

    if ($origen_id == $destino_id) {
        $_SESSION['error'] = "El origen y destino no pueden ser la misma ciudad.";
        header("Location: ../index.php");
        exit();
    }

    if (strtotime($fecha_ida) < strtotime(date('Y-m-d'))) {
        $_SESSION['error'] = "La fecha de ida no puede ser anterior a hoy.";
        header("Location: ../index.php");
        exit();
    }

    if (!empty($fecha_regreso) && strtotime($fecha_regreso) < strtotime($fecha_ida)) {
        $_SESSION['error'] = "La fecha de regreso no puede ser anterior a la fecha de ida.";
        header("Location: ../index.php");
        exit();
    }

    // Usar prepared statement para evitar SQL injection
    $stmt = $conexion->prepare("INSERT INTO vuelos (aerolinea_id, origen_id, destino_id, fecha_ida, fecha_regreso, pasajeros) VALUES (?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        $_SESSION['error'] = "Error en la consulta: " . $conexion->error;
        header("Location: ../index.php");
        exit();
    }

    $fecha_regreso_param = empty($fecha_regreso) ? NULL : $fecha_regreso;
    $stmt->bind_param("iiissi", $aerolinea_id, $origen_id, $destino_id, $fecha_ida, $fecha_regreso_param, $pasajeros);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "¡Reserva guardada exitosamente! ID: " . $stmt->insert_id;
    } else {
        $_SESSION['error'] = "Error al guardar la reserva: " . $stmt->error;
    }

    $stmt->close();
    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>
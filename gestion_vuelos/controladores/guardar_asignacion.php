<?php
session_start();
include("../modelos/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aerolinea_id = isset($_POST['aerolinea']) ? intval($_POST['aerolinea']) : 0;
    $ciudades = isset($_POST['ciudades']) ? array_map('intval', $_POST['ciudades']) : [];
    
    if ($aerolinea_id <= 0) {
        $_SESSION['error'] = "Aerolínea inválida.";
    } elseif (empty($ciudades)) {
        $_SESSION['error'] = "Debes seleccionar al menos una ciudad.";
    } else {
        // Usar transacción para seguridad
        $conexion->begin_transaction();
        
        try {
            // Eliminar asignaciones previas
            $delete_stmt = $conexion->prepare("DELETE FROM aerolinea_ciudad WHERE aerolinea_id = ?");
            $delete_stmt->bind_param("i", $aerolinea_id);
            $delete_stmt->execute();
            $delete_stmt->close();
            
            // Insertar nuevas asignaciones
            $insert_stmt = $conexion->prepare("INSERT INTO aerolinea_ciudad (aerolinea_id, ciudad_id) VALUES (?, ?)");
            
            foreach($ciudades as $ciudad_id) {
                $insert_stmt->bind_param("ii", $aerolinea_id, $ciudad_id);
                $insert_stmt->execute();
            }
            $insert_stmt->close();
            
            $conexion->commit();
            $_SESSION['mensaje'] = "Ciudades asignadas exitosamente.";
        } catch (Exception $e) {
            $conexion->rollback();
            $_SESSION['error'] = "Error al asignar ciudades: " . $e->getMessage();
        }
    }
} else {
    $_SESSION['error'] = "Método de solicitud no válido.";
}

header("Location: ../admin/indexAdmin.php");
exit();
?>
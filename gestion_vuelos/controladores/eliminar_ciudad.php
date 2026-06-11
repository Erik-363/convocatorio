<?php
session_start();
include("../modelos/conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Usar transacción para eliminar la ciudad y sus referencias
    $conexion->begin_transaction();
    
    try {
        // Eliminar asignaciones de esta ciudad
        $stmt1 = $conexion->prepare("DELETE FROM aerolinea_ciudad WHERE ciudad_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();
        
        // Eliminar vuelos que usen esta ciudad como origen o destino
        $stmt2 = $conexion->prepare("DELETE FROM vuelos WHERE origen_id = ? OR destino_id = ?");
        $stmt2->bind_param("ii", $id, $id);
        $stmt2->execute();
        $stmt2->close();
        
        // Eliminar la ciudad
        $stmt3 = $conexion->prepare("DELETE FROM ciudades WHERE id = ?");
        $stmt3->bind_param("i", $id);
        $stmt3->execute();
        $stmt3->close();
        
        $conexion->commit();
        $_SESSION['mensaje'] = "Ciudad eliminada exitosamente.";
    } catch (Exception $e) {
        $conexion->rollback();
        $_SESSION['error'] = "Error al eliminar la ciudad.";
    }
}

header("Location: ../admin/indexAdmin.php");
exit();
?>
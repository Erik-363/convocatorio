<?php
session_start();
include("../modelos/conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Usar transacción para eliminar la aerolínea y sus asignaciones
    $conexion->begin_transaction();
    
    try {
        // Eliminar asignaciones
        $stmt1 = $conexion->prepare("DELETE FROM aerolinea_ciudad WHERE aerolinea_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();
        
        // Eliminar vuelos de esta aerolínea
        $stmt2 = $conexion->prepare("DELETE FROM vuelos WHERE aerolinea_id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();
        
        // Eliminar la aerolínea
        $stmt3 = $conexion->prepare("DELETE FROM aerolineas WHERE id = ?");
        $stmt3->bind_param("i", $id);
        $stmt3->execute();
        $stmt3->close();
        
        $conexion->commit();
        $_SESSION['mensaje'] = "Aerolínea eliminada exitosamente.";
    } catch (Exception $e) {
        $conexion->rollback();
        $_SESSION['error'] = "Error al eliminar la aerolínea.";
    }
}

header("Location: ../admin/indexAdmin.php");
exit();
?>
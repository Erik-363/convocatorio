<?php
session_start();
include("../modelos/conexion.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $conexion->prepare("DELETE FROM vuelos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Reserva eliminada exitosamente.";
    } else {
        $_SESSION['error'] = "Error al eliminar la reserva.";
    }
    
    $stmt->close();
}

header("Location: ../index.php");
exit();
?>
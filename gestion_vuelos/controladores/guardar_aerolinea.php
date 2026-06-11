<?php
session_start();
include("../modelos/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    
    if (empty($nombre)) {
        $_SESSION['error'] = "El nombre de la aerolínea es requerido.";
    } elseif (strlen($nombre) < 2 || strlen($nombre) > 100) {
        $_SESSION['error'] = "El nombre debe tener entre 2 y 100 caracteres.";
    } else {
        // Verificar si ya existe
        $stmt = $conexion->prepare("SELECT id FROM aerolineas WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Esta aerolínea ya existe.";
        } else {
            // Insertar nueva aerolínea
            $insert_stmt = $conexion->prepare("INSERT INTO aerolineas (nombre) VALUES (?)");
            $insert_stmt->bind_param("s", $nombre);
            
            if ($insert_stmt->execute()) {
                $_SESSION['mensaje'] = "Aerolínea creada exitosamente.";
            } else {
                $_SESSION['error'] = "Error al crear la aerolínea.";
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
} else {
    $_SESSION['error'] = "Método de solicitud no válido.";
}

header("Location: ../admin/indexAdmin.php");
exit();
?>
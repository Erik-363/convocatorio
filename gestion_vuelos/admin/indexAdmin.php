<?php
session_start();
include("../modelos/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Gestión de Vuelos</title>
    <link rel="stylesheet" href="../estilos.css">
    <style>
        .admin-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .admin-tabs button {
            padding: 12px 25px;
            border: none;
            background: #e0e0e0;
            cursor: pointer;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .admin-tabs button.active {
            background: #667eea;
            color: white;
        }
        
        .admin-tabs button:hover {
            background: #667eea;
            color: white;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .btn-small {
            padding: 8px 12px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚙️ Panel Administrativo</h1>
            <p>Gestión de aerolíneas, ciudades y asignaciones</p>
            <div class="nav-links">
                <a href="../index.php">Volver a Inicio</a>
            </div>
        </div>

        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-error'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>

        <div class="admin-tabs">
            <button class="tab-btn active" onclick="mostrarTab('aerolineas')">✈️ Aerolíneas</button>
            <button class="tab-btn" onclick="mostrarTab('ciudades')">🏙️ Ciudades</button>
            <button class="tab-btn" onclick="mostrarTab('asignar')">🔗 Asignar Ciudades</button>
        </div>

        <!-- TAB: Aerolíneas -->
        <div id="aerolineas" class="tab-content active">
            <div class="main-content">
                <div class="card">
                    <h2>Crear Nueva Aerolínea</h2>
                    <form action="../controladores/guardar_aerolinea.php" method="POST">
                        <div class="form-group">
                            <label for="nombre_aerolinea">Nombre de la Aerolínea *</label>
                            <input type="text" id="nombre_aerolinea" name="nombre" placeholder="Ej: Latam, Avianca, etc." required>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success">Crear Aerolínea</button>
                            <button type="reset" class="btn btn-info">Limpiar</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <h2>Aerolíneas Registradas</h2>
                    <div class="table-container">
                        <?php
                        $result = mysqli_query($conexion, "SELECT id, nombre FROM aerolineas ORDER BY nombre ASC");
                        
                        if ($result && mysqli_num_rows($result) > 0) {
                            echo "<table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>";
                            
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>#{$row['id']}</td>
                                    <td>{$row['nombre']}</td>
                                    <td>
                                        <a href='../controladores/eliminar_aerolinea.php?id={$row['id']}' class='btn btn-danger btn-small' onclick='return confirm(\"¿Eliminar esta aerolínea?\")'>Eliminar</a>
                                    </td>
                                </tr>";
                            }
                            
                            echo "</tbody></table>";
                        } else {
                            echo "<p class='text-muted text-center'>No hay aerolíneas registradas</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB: Ciudades -->
        <div id="ciudades" class="tab-content">
            <div class="main-content">
                <div class="card">
                    <h2>Crear Nueva Ciudad</h2>
                    <form action="../controladores/guardar_ciudad.php" method="POST">
                        <div class="form-group">
                            <label for="nombre_ciudad">Nombre de la Ciudad *</label>
                            <input type="text" id="nombre_ciudad" name="nombre" placeholder="Ej: Madrid, Barcelona, etc." required>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success">Crear Ciudad</button>
                            <button type="reset" class="btn btn-info">Limpiar</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <h2>Ciudades Registradas</h2>
                    <div class="table-container">
                        <?php
                        $result = mysqli_query($conexion, "SELECT id, nombre FROM ciudades ORDER BY nombre ASC");
                        
                        if ($result && mysqli_num_rows($result) > 0) {
                            echo "<table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>";
                            
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>#{$row['id']}</td>
                                    <td>{$row['nombre']}</td>
                                    <td>
                                        <a href='../controladores/eliminar_ciudad.php?id={$row['id']}' class='btn btn-danger btn-small' onclick='return confirm(\"¿Eliminar esta ciudad?\")'>Eliminar</a>
                                    </td>
                                </tr>";
                            }
                            
                            echo "</tbody></table>";
                        } else {
                            echo "<p class='text-muted text-center'>No hay ciudades registradas</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB: Asignar Ciudades -->
        <div id="asignar" class="tab-content">
            <div class="main-content">
                <div class="card">
                    <h2>Asignar Ciudades a Aerolínea</h2>
                    <form action="../controladores/guardar_asignacion.php" method="POST">
                        <div class="form-group">
                            <label for="aerolinea_select">Seleccione Aerolínea *</label>
                            <select id="aerolinea_select" name="aerolinea" required onchange="cargarCiudadesAsignadas()">
                                <option value="">-- Seleccione una aerolínea --</option>
                                <?php
                                $result = mysqli_query($conexion, "SELECT id, nombre FROM aerolineas ORDER BY nombre ASC");
                                if ($result) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Seleccione Ciudades *</label>
                            <div id="ciudades_lista" style="border: 2px solid #e0e0e0; padding: 15px; border-radius: 5px; max-height: 300px; overflow-y: auto;">
                                <?php
                                $result = mysqli_query($conexion, "SELECT id, nombre FROM ciudades ORDER BY nombre ASC");
                                if ($result) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<div style='margin-bottom: 10px;'>
                                            <input type='checkbox' id='ciudad_{$row['id']}' name='ciudades[]' value='{$row['id']}'>
                                            <label for='ciudad_{$row['id']}' style='display: inline; margin: 0; font-weight: normal; cursor: pointer;'>{$row['nombre']}</label>
                                        </div>";
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-success">Asignar Ciudades</button>
                            <button type="reset" class="btn btn-info">Limpiar</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <h2>Asignaciones Actuales</h2>
                    <div class="table-container">
                        <?php
                        $result = mysqli_query($conexion, "
                            SELECT 
                                a.id as aerolinea_id,
                                a.nombre as aerolinea,
                                GROUP_CONCAT(c.nombre SEPARATOR ', ') as ciudades,
                                COUNT(c.id) as total_ciudades
                            FROM aerolineas a
                            LEFT JOIN aerolinea_ciudad ac ON a.id = ac.aerolinea_id
                            LEFT JOIN ciudades c ON ac.ciudad_id = c.id
                            GROUP BY a.id, a.nombre
                            ORDER BY a.nombre ASC
                        ");
                        
                        if ($result && mysqli_num_rows($result) > 0) {
                            echo "<table>
                                <thead>
                                    <tr>
                                        <th>Aerolínea</th>
                                        <th>Ciudades Asignadas</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>";
                            
                            while($row = mysqli_fetch_assoc($result)) {
                                $ciudades_text = $row['ciudades'] ?? 'Sin ciudades asignadas';
                                echo "<tr>
                                    <td><strong>{$row['aerolinea']}</strong></td>
                                    <td>{$ciudades_text}</td>
                                    <td><span style='background: #667eea; color: white; padding: 5px 10px; border-radius: 3px;'>{$row['total_ciudades']}</span></td>
                                </tr>";
                            }
                            
                            echo "</tbody></table>";
                        } else {
                            echo "<p class='text-muted text-center'>No hay asignaciones registradas</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarTab(tabName) {
            // Ocultar todos los tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Desactivar todos los botones
            const botones = document.querySelectorAll('.tab-btn');
            botones.forEach(btn => btn.classList.remove('active'));
            
            // Mostrar tab seleccionado
            document.getElementById(tabName).classList.add('active');
            
            // Activar botón seleccionado
            event.target.classList.add('active');
        }

        function cargarCiudadesAsignadas() {
            let aerolinea_id = document.getElementById('aerolinea_select').value;
            
            if (!aerolinea_id) {
                // Desmarcar todos los checkboxes
                document.querySelectorAll('input[name="ciudades[]"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
                return;
            }

            fetch('../controladores/obtener_ciudades_check.php?aerolinea_id=' + aerolinea_id)
                .then(res => res.json())
                .then(data => {
                    // Desmarcar todos primero
                    document.querySelectorAll('input[name="ciudades[]"]').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    
                    // Marcar las ciudades de esta aerolínea
                    data.forEach(ciudad_id => {
                        const checkbox = document.getElementById('ciudad_' + ciudad_id);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
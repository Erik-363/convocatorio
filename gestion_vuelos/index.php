<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Vuelos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <?php session_start(); ?>
    <div class="container">
        <div class="header">
            <h1>✈️ Sistema de Gestión de Vuelos</h1>
            <p>Reserva y gestión de vuelos de forma fácil y segura</p>
            <div class="nav-links">
                <a href="index.php">Inicio</a>
                <a href="admin/indexAdmin.php">Panel Administrativo</a>
            </div>
        </div>

        <div class="main-content">
            <div class="card">
                <h2>Reservar Vuelo</h2>
                
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

                <form action="controladores/insertar.php" method="POST">
                    <div class="form-group">
                        <label for="aerolinea">Seleccione Aerolínea *</label>
                        <select name="aerolinea" id="aerolinea" required>
                            <option value="">-- Seleccione una aerolínea --</option>
                            <?php
                            include("modelos/conexion.php");
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
                        <label for="origen">Ciudad de Origen *</label>
                        <select id="origen" name="origen" required>
                            <option value="">-- Seleccione origen --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="destino">Ciudad de Destino *</label>
                        <select id="destino" name="destino" required>
                            <option value="">-- Seleccione destino --</option>
                        </select>
                    </div>

                    <div class="form-inline">
                        <div class="form-group">
                            <label for="fecha_ida">Fecha de Ida *</label>
                            <input type="date" name="fecha_ida" id="fecha_ida" required>
                        </div>

                        <div class="form-group">
                            <label for="fecha_regreso">Fecha de Regreso</label>
                            <input type="date" name="fecha_regreso" id="fecha_regreso">
                        </div>

                        <div class="form-group">
                            <label for="pasajeros">Número de Pasajeros *</label>
                            <input type="number" name="pasajeros" id="pasajeros" min="1" max="10" required>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-success">Guardar Reserva</button>
                        <button type="reset" class="btn btn-info">Limpiar</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <h2>Mis Reservas</h2>
                <div class="table-container" id="reservas-container">
                    <p class="text-muted text-center">Cargando reservas...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cargar ciudades al seleccionar aerolínea
        document.getElementById("aerolinea").addEventListener("change", function() {
            let id = this.value;
            
            if (!id) {
                document.getElementById("origen").innerHTML = '<option value="">-- Seleccione origen --</option>';
                document.getElementById("destino").innerHTML = '<option value="">-- Seleccione destino --</option>';
                return;
            }

            fetch("controladores/obtener_ciudades.php?aerolinea_id=" + id)
                .then(res => res.text())
                .then(data => {
                    document.getElementById("origen").innerHTML = '<option value="">-- Seleccione origen --</option>' + data;
                    document.getElementById("destino").innerHTML = '<option value="">-- Seleccione destino --</option>' + data;
                })
                .catch(error => console.error('Error:', error));
        });

        // Cargar reservas
        function cargarReservas() {
            fetch("controladores/obtener_reservas.php")
                .then(res => res.text())
                .then(data => {
                    document.getElementById("reservas-container").innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }

        // Cargar reservas al abrir la página
        cargarReservas();
        // Recargar reservas cada 10 segundos
        setInterval(cargarReservas, 10000);
    </script>
</body>
</html>
<?php
include("../modelos/conexion.php");

$query = "
SELECT 
    v.id,
    a.nombre as aerolinea,
    c1.nombre as origen,
    c2.nombre as destino,
    v.fecha_ida,
    v.fecha_regreso,
    v.pasajeros
FROM vuelos v
JOIN aerolineas a ON v.aerolinea_id = a.id
JOIN ciudades c1 ON v.origen_id = c1.id
JOIN ciudades c2 ON v.destino_id = c2.id
ORDER BY v.fecha_ida DESC
";

$result = mysqli_query($conexion, $query);

if (!$result) {
    echo "<p class='text-muted text-center'>Error al cargar las reservas</p>";
    exit();
}

if (mysqli_num_rows($result) == 0) {
    echo "<p class='text-muted text-center'>No hay reservas registradas</p>";
    exit();
}

echo "<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Aerolínea</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Fecha Ida</th>
            <th>Fecha Regreso</th>
            <th>Pasajeros</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>";

while($row = mysqli_fetch_assoc($result)) {
    $fecha_regreso = !empty($row['fecha_regreso']) ? $row['fecha_regreso'] : 'N/A';
    echo "<tr>
        <td>#{$row['id']}</td>
        <td>{$row['aerolinea']}</td>
        <td>{$row['origen']}</td>
        <td>{$row['destino']}</td>
        <td>" . date('d/m/Y', strtotime($row['fecha_ida'])) . "</td>
        <td>" . ($fecha_regreso !== 'N/A' ? date('d/m/Y', strtotime($fecha_regreso)) : 'N/A') . "</td>
        <td>{$row['pasajeros']}</td>
        <td>
            <a href='eliminar_vuelo.php?id={$row['id']}' class='btn btn-danger btn-small' onclick='return confirm(\"¿Estás seguro?\")''>Eliminar</a>
        </td>
    </tr>";
}

echo "</tbody></table>";
?>
Manual de Usuario

Acceso al sistema
- Abrir un navegador y navegar a: `http://localhost/gestion_vuelos/`.
- Para acceder al panel administrativo: `http://localhost/gestion_vuelos/admin/indexAdmin.php` (no hay autenticación por defecto en esta versión).

Uso de módulos

1. Pantalla principal (Reservar Vuelo)
- Seleccionar aerolínea.
- Seleccionar ciudad de origen y destino (las ciudades disponibles se cargan según la aerolínea seleccionada).
- Ingresar fechas y número de pasajeros.
- Hacer clic en "Guardar Reserva" para crear la reserva.
- "Mis Reservas" mostrará las reservas cargadas (se actualiza cada 10 segundos).

2. Panel Administrativo
- `Crear Aerolínea`: crear nueva aerolínea con nombre único.
- `Crear Ciudad`: crear nueva ciudad.
- `Asignar Ciudades`: asociar ciudades a una aerolínea (tabla `aerolinea_ciudad`).
- `Eliminar`: desde el administrador se pueden eliminar aerolíneas, ciudades o vuelos (las relaciones aplican ON DELETE CASCADE).

Funcionalidades principales
- Registrar aerolíneas y ciudades.
- Asignar rutas (ciudades) a aerolíneas.
- Crear reservas de vuelo con origen/destino/fechas/pasajeros.
- Visualizar y gestionar reservas desde el panel administrativo.

Consejos de uso
- Asegurarse de crear aerolíneas y ciudades antes de intentar crear vuelos.
- Evitar nombres duplicados para aerolíneas y ciudades.

Soporte
- Para reportar errores o pedir mejoras, indicar el archivo afectado y una descripción clara del comportamiento esperado vs. observado.

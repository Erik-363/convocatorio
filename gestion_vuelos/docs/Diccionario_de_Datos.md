Diccionario de Datos

Fuente: `vistas/database.sql`

Tabla: `aerolineas`
- `id` INT AUTO_INCREMENT PRIMARY KEY
- `nombre` VARCHAR(100) NOT NULL UNIQUE
- `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP

Tabla: `ciudades`
- `id` INT AUTO_INCREMENT PRIMARY KEY
- `nombre` VARCHAR(100) NOT NULL UNIQUE
- `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP

Tabla: `aerolinea_ciudad`
- `id` INT AUTO_INCREMENT PRIMARY KEY
- `aerolinea_id` INT NOT NULL — FK -> `aerolineas(id)` (ON DELETE CASCADE)
- `ciudad_id` INT NOT NULL — FK -> `ciudades(id)` (ON DELETE CASCADE)
- `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
- Restricción única: `(aerolinea_id, ciudad_id)` — evita duplicados
- Índices: `idx_aerolinea_ciudad`, `idx_ciudad_aerolinea`

Tabla: `vuelos`
- `id` INT AUTO_INCREMENT PRIMARY KEY
- `aerolinea_id` INT NOT NULL — FK -> `aerolineas(id)` (ON DELETE CASCADE)
- `origen_id` INT NOT NULL — FK -> `ciudades(id)`
- `destino_id` INT NOT NULL — FK -> `ciudades(id)`
- `fecha_ida` DATE NOT NULL
- `fecha_regreso` DATE NULL
- `pasajeros` INT NOT NULL DEFAULT 1
- `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
- Índices: `idx_vuelos_aerolinea`, `idx_vuelos_origen`, `idx_vuelos_destino`, `idx_vuelos_fecha`

Notas de integridad
- Las claves foráneas definen eliminación en cascada para mantener consistencia cuando se borra una aerolínea o ciudad.
- Los campos `nombre` en `aerolineas` y `ciudades` son únicos para evitar duplicados.

Manual Técnico

Requisitos previos
- XAMPP (Apache + MySQL) instalado en Windows.
- Navegador web.

Instalación del sistema
1. Copiar la carpeta del proyecto a la ruta pública de Apache. En XAMPP, la ruta típica es `C:/xampp/htdocs/`.
   - Ejemplo: colocar la carpeta `gestion_vuelos` en `C:/xampp/htdocs/gestion_vuelos`.
2. Iniciar Apache y MySQL desde el panel de XAMPP.
3. Importar la base de datos:
   - Usando phpMyAdmin: abrir http://localhost/phpmyadmin, crear la base de datos (opcional) e importar el archivo `vistas/database.sql`.
   - Usando MySQL CLI:

```bash
mysql -u root -p < vistas/database.sql
```

Configuración del entorno
- Revisar y actualizar las credenciales en `modelos/conexion.php` si es necesario (host, user, password, database).
- El archivo por defecto usa:
  - host: `localhost`
  - user: `root`
  - password: `` (vacío)
  - database: `vuelos_db`

Dependencias
- No hay dependencias externas gestionadas por Composer o npm; solo requiere PHP y MySQL.

Ejecución del proyecto
- Abrir en el navegador: `http://localhost/gestion_vuelos/`.
- El `index.php` en la raíz incluye la vista principal en `vistas/index.php`.

Consejos de despliegue
- Para producción, configurar un usuario MySQL con contraseña y actualizar `modelos/conexion.php`.
- Habilitar HTTPS y configurar permisos adecuados en el servidor.

Resolución de problemas comunes
- Error de conexión: verificar que MySQL esté en ejecución y credenciales en `modelos/conexion.php`.
- Problemas con rutas: si al mover archivos las rutas relativas fallan, revisar los `include` y `fetch` en JavaScript para usar rutas absolutas si se prefiere.

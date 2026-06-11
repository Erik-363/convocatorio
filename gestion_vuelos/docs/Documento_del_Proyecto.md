Portada

Sistema de Gestión de Vuelos
Autor: (nombre del autor)
Fecha: 2026-06-10
Versión: 1.0

Introducción

Este documento describe el Sistema de Gestión de Vuelos, una aplicación web para administrar aerolíneas, ciudades y reservas de vuelos de forma sencilla.

Planteamiento del problema

Las agencias y usuarios requieren una interfaz centralizada para crear aerolíneas, registrar ciudades, asignar rutas y reservar vuelos con control básico de datos.

Objetivos

- Objetivo general: Desarrollar una aplicación web que permita gestionar aerolíneas, ciudades y reservas de vuelos.
- Objetivos específicos:
  - Registrar y mantener aerolíneas y ciudades.
  - Asignar ciudades a aerolíneas (rutas disponibles).
  - Permitir al usuario crear reservas y consultar sus reservas.

Requerimientos funcionales

- RF1: Registrar aerolíneas.
- RF2: Registrar ciudades.
- RF3: Asignar ciudades a aerolíneas.
- RF4: Crear reservas de vuelos (origen, destino, fechas, pasajeros).
- RF5: Listar reservas.
- RF6: Eliminar aerolíneas, ciudades y reservas desde el panel administrativo.

Requerimientos no funcionales

- RNF1: La aplicación debe ser accesible vía navegador (HTTP) sobre servidor local (XAMPP).
- RNF2: Responder en menos de 2s para operaciones habituales en datos pequeños.
- RNF3: Compatible con UTF-8 para soportar caracteres en español.

Diagrama de base de datos

Ver: [Diagrama Entidad-Relación](ER_Diagrama.md)

Explicación de la arquitectura MVC

- Modelo: archivos en `modelos/` (p.ej. `conexion.php`) gestionan la conexión y acceso a datos.
- Vista: archivos en la raíz y `vistas/` entregan la interfaz HTML al usuario.
- Controlador: scripts en `controladores/` procesan peticiones, validan datos y realizan redirects.

Tecnologías utilizadas

- PHP 7+ / 8+
- MySQL / MariaDB
- HTML5, CSS
- XAMPP (Apache + MySQL)

Capturas del sistema

- Se incluyen espacios para capturas en la carpeta `docs/capturas/`. Añadir imágenes reales y sustituir los placeholders.

Conclusiones

El sistema ofrece funcionalidades básicas para gestionar aerolíneas, ciudades y reservas. Se recomienda añadir autenticación, validaciones del lado servidor y pruebas automáticas en futuras iteraciones.

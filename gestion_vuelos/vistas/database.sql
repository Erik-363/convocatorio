-- ==========================================
-- BASE DE DATOS: SISTEMA DE GESTIÓN DE VUELOS
-- ==========================================
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS vuelos_db;
USE vuelos_db;

-- ==========================================
-- TABLA: AEROLINEAS
-- ==========================================
CREATE TABLE IF NOT EXISTS aerolineas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- TABLA: CIUDADES
-- ==========================================
CREATE TABLE IF NOT EXISTS ciudades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- TABLA: AEROLINEA_CIUDAD (Relación Muchos a Muchos)
-- ==========================================
CREATE TABLE IF NOT EXISTS aerolinea_ciudad (
  id INT AUTO_INCREMENT PRIMARY KEY,
  aerolinea_id INT NOT NULL,
  ciudad_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (aerolinea_id) REFERENCES aerolineas(id) ON DELETE CASCADE,
  FOREIGN KEY (ciudad_id) REFERENCES ciudades(id) ON DELETE CASCADE,
  UNIQUE KEY unique_aerolinea_ciudad (aerolinea_id, ciudad_id)
);

-- ==========================================
-- TABLA: VUELOS
-- ==========================================
CREATE TABLE IF NOT EXISTS vuelos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  aerolinea_id INT NOT NULL,
  origen_id INT NOT NULL,
  destino_id INT NOT NULL,
  fecha_ida DATE NOT NULL,
  fecha_regreso DATE,
  pasajeros INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (aerolinea_id) REFERENCES aerolineas(id) ON DELETE CASCADE,
  FOREIGN KEY (origen_id) REFERENCES ciudades(id) ON DELETE CASCADE,
  FOREIGN KEY (destino_id) REFERENCES ciudades(id) ON DELETE CASCADE
);

-- ==========================================
-- INDICES PARA MEJOR RENDIMIENTO
-- ==========================================
CREATE INDEX idx_aerolinea_ciudad ON aerolinea_ciudad(aerolinea_id);
CREATE INDEX idx_ciudad_aerolinea ON aerolinea_ciudad(ciudad_id);
CREATE INDEX idx_vuelos_aerolinea ON vuelos(aerolinea_id);
CREATE INDEX idx_vuelos_origen ON vuelos(origen_id);
CREATE INDEX idx_vuelos_destino ON vuelos(destino_id);
CREATE INDEX idx_vuelos_fecha ON vuelos(fecha_ida);

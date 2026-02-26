CREATE DATABASE IF NOT EXISTS gestion_casilleros;
USE gestion_casilleros;

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE casilleros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_casillero INT NOT NULL UNIQUE,
    estado ENUM('libre', 'ocupado') DEFAULT 'libre',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE paquetes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(100) NOT NULL,
    objeto VARCHAR(100) NOT NULL,
    casillero_id INT NOT NULL,
    fecha_ingreso DATETIME NOT NULL,
    fecha_salida DATETIME NULL,
    admin_ingreso_id INT NOT NULL,
    admin_salida_id INT NULL,
    FOREIGN KEY (casillero_id) REFERENCES casilleros(id),
    FOREIGN KEY (admin_ingreso_id) REFERENCES administradores(id),
    FOREIGN KEY (admin_salida_id) REFERENCES administradores(id)
);

-- Insertar administrador de prueba (Usuario: admin | Contraseña: admin123)
INSERT INTO administradores (usuario, password) 
VALUES ('admin', '12345');

SELECT * FROM administradores;
SELECT * FROM paquetes;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE administradores;
TRUNCATE TABLE paquetes; -- Es recomendable limpiar también paquetes para evitar datos huérfanos
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO administradores (usuario, password) 
VALUES ('admin', '$2y$10$89E6p2K8pYf5Z6p7p8p9OuG8pYf5Z6p7p8p9OuG8pYf5Z6p7p8p9O');

-- Insertar 10 casilleros iniciales
INSERT INTO casilleros (numero_casillero, estado) VALUES 
(1, 'libre'), (2, 'libre'), (3, 'libre'), (4, 'libre'), (5, 'libre'),
(6, 'libre'), (7, 'libre'), (8, 'libre'), (9, 'libre'), (10, 'libre');
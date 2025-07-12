-- Permisos
INSERT INTO PERMISSIONS (ID, PERMISSION) VALUES
(1, 'Administrador'),
(2, 'Usuario básico');

-- Departamentos
INSERT INTO DEPARTMENTS (ID, DEPARTMENT_CODE, TYPE) VALUES
(1, 'DPTO-001', 'Eléctrico'),
(2, 'DPTO-002', 'Mecánico');

-- Usuarios
INSERT INTO USERS (ID, USERNAME, PASSWORD, ID_PERMISSION, ID_DEPARTMENT) VALUES
(1, 'admin', '1234', 1, 1),
(2, 'user1', 'abcd', 2, 2);

-- Breakers (usando tus IDs conocidos)
INSERT INTO BREAKERS (ID, DEVICE_NAME, ID_USER, DEVICE_TYPE) VALUES
('6520fc0a00a365c22als9f', 'Breaker Principal', 1, 'Medidor'),
('65e6a732254c5669aceikp', 'Breaker Secundario', 2, 'Sensor');
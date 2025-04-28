-- DDL
CREATE TABLE Usuario (
email VARCHAR(100) NOT NULL PRIMARY KEY,
nombre VARCHAR(100) NOT NULL,
passwd VARCHAR(32) NOT NULL,
celular VARCHAR(20) NOT NULL,
tipoU ENUM('Admin','Tecnico','Cliente'),
baja BOOLEAN NOT NULL,
email_a VARCHAR(100),
CONSTRAINT FOREIGN KEY (email_a)
REFERENCES Usuario (email) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Servicio(
servicio_id INT PRIMARY KEY AUTO_INCREMENT,
servicio_tipo ENUM ('REPARACION PC','TELEVISORES','OTROS'),
servicio_costo DOUBLE
);

CREATE TABLE Pedido(
id_p INT AUTO_INCREMENT,
email_c VARCHAR(100),
servicio_id INT,
f_reg DATETIME,
comentarios VARCHAR(255),
estado ENUM ('Pendiente', 'En Proceso', 'Finalizado'),
PRIMARY KEY (id_p,email_c,servicio_id),
CONSTRAINT FOREIGN KEY (email_c)
REFERENCES Usuario (email) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (servicio_id)
REFERENCES Servicio (servicio_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Asigna(
id_p INT,
email_c VARCHAR(100),
email_t VARCHAR(100),
servicio_id INT,
PRIMARY KEY (id_p,email_c,servicio_id),
CONSTRAINT FOREIGN KEY (email_c)
REFERENCES Pedido (email_c) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (id_p)
REFERENCES Pedido (id_p) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (email_t)
REFERENCES Usuario (email) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (servicio_id)
REFERENCES Pedido (servicio_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Horario(
id_h INT AUTO_INCREMENT PRIMARY KEY,
h_ini CHAR(5),
h_fin CHAR(5)
);

CREATE TABLE Visita(
id_v INT PRIMARY KEY AUTO_INCREMENT,
id_p INT,
id_h INT,
dia DATE,
baja BOOLEAN,
CONSTRAINT FOREIGN KEY (id_p)
REFERENCES Asigna (id_p) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT FOREIGN KEY (id_h)
REFERENCES Horario (id_h) ON DELETE CASCADE ON UPDATE CASCADE
);

-- DML

INSERT INTO Usuario (email,nombre,passwd,celular,tipoU,baja) VALUES ('admin@gmail.com','Leticia',MD5('12345678'),'091234567','Admin',0);

INSERT INTO Servicio (servicio_tipo, servicio_costo) VALUES ('REPARACION PC', 2000),('TELEVISORES', 1000),('OTROS', 500);

INSERT INTO Horario (h_ini, h_fin)
VALUES
('09:00', '10:00'),
('10:00', '11:00'),
('11:00', '12:00'),
('12:00', '13:00'),
('13:00', '14:00'),
('14:00', '15:00'),
('15:00', '16:00'),
('16:00', '17:00'),
('17:00', '18:00');

INSERT INTO Asigna VALUES (1, 'cliente@gmail.com','matelopez2436@gmail.com',2);

INSERT INTO Visita (id_p, id_h, dia, baja) VALUES (1,1,NOW(),0);

SELECT * FROM Usuario;

SELECT P.id_p, S.servicio_tipo, P.f_reg, P.comentarios, P.estado
FROM Pedido P
JOIN Servicio S ON P.servicio_id = S.servicio_id
WHERE P.email_c = 'a@example.com';

SELECT * FROM Usuario;

SELECT * FROM Pedido;

SELECT * FROM Asigna;

SELECT * FROM Horario;

SELECT * FROM Visita;

SELECT id_v, id_p, h_ini, h_fin, dia FROM Visita, Horario WHERE Visita.id_h = Horario.id_h;

SELECT DISTINCT V.id_p, A.email_t, CONCAT(H.h_ini, '-', H.h_fin) AS Hora_Estimada, V.dia 
FROM Visita V
JOIN Asigna A ON V.id_p = A.id_p
JOIN Horario H ON V.id_h = H.id_h
WHERE A.email_c = 'cliente@gmail.com';

-- SCRIPT 3000 Tuplas tabala Usuario (Tipo cliente)

DELIMITER //

CREATE PROCEDURE insertar_clientes(num_registros INT)
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE email_cliente VARCHAR(100);
    DECLARE nombre_cliente VARCHAR(100);
    DECLARE passwd_cliente VARCHAR(32);
    DECLARE celular_cliente VARCHAR(20);
    DECLARE random_passwd VARCHAR(20);

    -- Generar registros en la tabla Usuario solo para tipoU = 'Cliente'
    WHILE i <= num_registros DO
        -- Generar datos para el cliente
        SET email_cliente = CONCAT('cliente', i, '@ejemplo.com');
        SET nombre_cliente = CONCAT('Cliente ', i);
        
        -- Generar una contraseña aleatoria y luego hashearla con MD5
        SET random_passwd = LPAD(FLOOR(RAND() * 1000000), 8, '0');  -- Contraseña de 8 dígitos aleatoria
        SET passwd_cliente = MD5(random_passwd);  -- Hashear la contraseña con MD5
        
        -- Generar un número de teléfono que inicie con '09' seguido de un número entre 1 y 9, y 6 dígitos aleatorios
        SET celular_cliente = CONCAT('09', FLOOR(1 + RAND() * 9), LPAD(FLOOR(RAND() * 1000000), 6, '0'));
        
        -- Insertar solo si tipoU es 'Cliente' y email_a está vacío
        INSERT INTO Usuario (email, nombre, passwd, celular, tipoU, baja, email_a)
        VALUES (email_cliente, nombre_cliente, passwd_cliente, celular_cliente, 'Cliente', FALSE, NULL);
        
        SET i = i + 1;
    END WHILE;
END //

DELIMITER ;

-- Llamar al procedimiento para insertar clientes
CALL insertar_clientes(3000);

-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    
/* Vistas */
/* cantidad total de pedidos para cada técnico */
SELECT * FROM cantidadpedidosportecnico;

CREATE VIEW cantidadpedidosportecnico AS
SELECT 
    email_t AS Tecnico,
    COUNT(*) AS CantidadPedidos
FROM 
    Asigna
GROUP BY 
    email_t;


/* Pedidos Por Tecnico */
SELECT * FROM pedidosportecnico;

SELECT * FROM pedidosportecnico WHERE Tecnico = 'ngalego@mail.com';
CREATE VIEW pedidosportecnico AS
SELECT 
    asigna.email_t AS Tecnico,
    asigna.id_p AS Pedido_ID,
    asigna.email_c AS Cliente,
    asigna.servicio_id AS Servicio_ID
FROM 
    Asigna
ORDER BY 
    asigna.email_t;


/* Consultar el estado de los pedidos */

SELECT * FROM cantidadpedidosporestado;

CREATE VIEW cantidadpedidosporestado AS
SELECT 
    estado AS Estado,
    COUNT(*) AS CantidadPedidos
FROM 
    Pedido
GROUP BY 
    estado;
    
/* Consultar el estado de los pedidos de un cliente */

SELECT * FROM estadopedidosporcliente WHERE Cliente = 'cliente@gmail.com';

CREATE VIEW estadopedidosporcliente AS
SELECT
	 pedido.email_c AS Cliente, 
    pedido.id_p AS PedidoID,
    pedido.servicio_id AS ServicioID,
    pedido.f_reg AS FechaRegistro,
    pedido.estado AS Estado
FROM 
    Pedido;
    
/* Consulta los pedidos asignados a un técnico, su estado y el cliente que lo solisito */

SELECT * FROM pedidostecnicosestado
WHERE Tecnico = 'ngalego@mail.com';

CREATE VIEW pedidostecnicosestado AS
SELECT 
	 asigna.email_t AS Tecnico,
    pedido.id_p AS Pedido_id,
    usuario.nombre AS Cliente_nombre,
    asigna.email_c AS Cliente_email,
    servicio.servicio_tipo AS Servicio,
    pedido.estado AS Pedido_estado,
    pedido.f_reg
FROM Pedido
JOIN Asigna ON pedido.id_p = asigna.id_p
JOIN Usuario ON pedido.email_c = usuario.email
JOIN Servicio ON pedido.servicio_id = servicio.servicio_id
WHERE asigna.email_t = 'ngalego@mail.com';

-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------
/* Permisos */
/* Clientes */
CREATE USER 'pepe'@'LOCALHOST' IDENTIFIED BY '12345678'; /* cliente sin previlegios */

CREATE USER 'pedro'@'LOCALHOST' IDENTIFIED BY '12345678';
GRANT UPDATE (email, nombre, passwd, celular) ON proyectophpmysql.usuario TO 'pedro'@'LOCALHOST'; /* cliente con previlegios restringidos */
GRANT SELECT (email_c, estado) ON proyectophpmysql.pedido TO 'pedro'@'LOCALHOST';
GRANT SELECT ON proyectophpmysql.pedidostecnicosestado TO 'pedro'@'localhost';

/* Administradores */
CREATE USER 'nahuel'@'LOCALHOST' IDENTIFIED BY '12345678';
GRANT ALL PRIVILEGES ON *.* TO 'nahuel'@'LOCALHOST';

CREATE USER 'leticia'@'LOCALHOST' IDENTIFIED BY '12345678';
GRANT ALL PRIVILEGES ON *.* TO 'leticia'@'LOCALHOST';

/* Tecnicos */
CREATE USER 'gilberto'@'LOCALHOST' IDENTIFIED BY '12345678';
GRANT SELECT ON proyectophpmysql.pedidosportecnico TO 'gilberto'@'localhost';
GRANT SELECT ON proyectophpmysql.visita TO 'gilberto'@'localhost';

CREATE USER 'paolo'@'LOCALHOST' IDENTIFIED BY '12345678';
GRANT SELECT ON proyectophpmysql.pedidosportecnico TO 'paolo'@'localhost';
GRANT SELECT ON proyectophpmysql.visita TO 'paolo'@'localhost';
GRANT UPDATE (comentarios, estado) ON proyectophpmysql.pedido TO 'paolo'@'localhost';

-- SELECT USER FROM mysql.user;
-- DROP USER ''@'localhost';

-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------

/* Inices */
-- BTREE
-- Este índice mejora el rendimiento de consultas que buscan pedidos en un rango de fechas
CREATE INDEX idx_pedido_fecha_btree ON Pedido (f_reg) USING BTREE;
SELECT * FROM Pedido WHERE f_reg BETWEEN '2024-11-01' AND '2024-11-30';

/* Esto será útil si necesitas realizar consultas que filtran por un tipo de servicio
 o buscar todos los pedidos asignados de un servicio específico */
CREATE INDEX idx_asigna_servicio_btree ON Asigna (servicio_id) USING BTREE;
SELECT * FROM Asigna WHERE servicio_id = 2;


-- HASH 
-- Este índice es útil para consultas que buscan datos específicos
CREATE INDEX idx_usuario_email_hash ON Usuario (email) USING HASH;
SELECT * FROM Usuario WHERE email = 'cliente@gmail.com';

-- Esto es útil para consultar los pedidos por estado de forma exacta.
CREATE INDEX idx_pedido_estado_hash ON Pedido (estado) USING HASH;
SELECT * FROM Pedido WHERE estado = 'Pendiente';

-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    

--  VISTAS ENVÍADAS POR OTROS GRUPOS

--  SEBASTIÁN SANTIAGO BERRUTI 

/* 1) Crear una vista que muestre el nombre del cliente, el nombre del técnico asignado y el estado del pedido.
   2) Crear una vista con el nombre del técnico y la fecha/hora de cada visita programada.
   3) Crear una vista que muestre el total de pedidos en cada estado. */

-- 1)
CREATE VIEW DetallesPedidoClienteTecnico AS
SELECT 
    Usuario.nombre AS NombreCliente,
    (SELECT nombre FROM Usuario WHERE Usuario.email = Asigna.email_t) AS Tecnico,
    Pedido.estado AS EstadoPedido
FROM Pedido
JOIN Asigna ON Pedido.id_p = Asigna.id_p 
    AND Pedido.email_c = Asigna.email_c 
    AND Pedido.servicio_id = Asigna.servicio_id
JOIN Usuario ON Pedido.email_c = Usuario.email;

SELECT * FROM DetallesPedidoClienteTecnico WHERE tecnico = 'gilberto';
SELECT * FROM DetallesPedidoClienteTecnico;


-- 2)
CREATE VIEW VisitasProgramadasTecnico AS
SELECT 
    Usuario.nombre AS NombreTecnico,
    Visita.dia AS FechaVisita,
    CONCAT(Horario.h_ini, ' - ', Horario.h_fin) AS HoraVisita
FROM 
    Visita
JOIN Asigna ON Visita.id_p = Asigna.id_p
JOIN Usuario ON Asigna.email_t = Usuario.email
JOIN Horario ON Visita.id_h = Horario.id_h;

SELECT * FROM VisitasProgramadasTecnico;
-- 3)
CREATE VIEW TotalPedidosPorEstado AS
SELECT 
    estado AS Estado,
    COUNT(*) AS TotalPedidos
FROM 
    Pedido
GROUP BY 
    estado;
    
SELECT * FROM TotalPedidosPorEstado;
-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    
-- MATIAS LAUTARO BERRUETA VAZQUEZ

/* 1) Mostrar datos de los 30 pedidos mas recientes.
   2) Mostrar todos los pedidos pendientes de un servicio especifico.
   3) Mostrar todos los pedidos que se realizaron en un mes especifico. */

-- 1)
CREATE VIEW PedidosMasRecientes AS
SELECT 
    id_p AS PedidoID,
    email_c AS Cliente,
    servicio_id AS ServicioID,
    f_reg AS FechaRegistro,
    estado AS Estado
FROM 
    Pedido
ORDER BY f_reg DESC
LIMIT 30;

SELECT * FROM PedidosMasRecientes;

-- 2)
CREATE VIEW PedidosPendientesPorServicio AS
SELECT 
    Pedido.id_p AS PedidoID,
    Pedido.email_c AS Cliente,
    Servicio.servicio_tipo AS TipoServicio,
    Pedido.f_reg AS FechaRegistro,
    Pedido.estado AS Estado
FROM 
    Pedido
JOIN Servicio ON Pedido.servicio_id = Servicio.servicio_id
WHERE Pedido.estado = 'Pendiente' AND servicio.servicio_tipo = 'TELEVISORES';

SELECT * FROM PedidosPendientesPorServicio;

-- 3)
CREATE VIEW PedidosPorMes AS
SELECT 
    id_p AS PedidoID,
    email_c AS Cliente,
    servicio_id AS ServicioID,
    f_reg AS FechaRegistro,
    estado AS Estado
FROM 
    Pedido
WHERE 
    MONTH(f_reg) = MONTH(CURDATE()) AND YEAR(f_reg) = YEAR(CURDATE());

SELECT * FROM PedidosPorMes WHERE MONTH(FechaRegistro) = 11 AND YEAR(FechaRegistro) = 2024;


-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    

-- Equipo MEA de MARTÍN AGUSTÍN LANDACO MENDIETTA

/* 1) Listar la cantidad total de pedidos completados y ordenar descendentemente por precio.
	2) Hacer un ranking de lo servicios decendentemente por precio
	3) Listar la agenda para el dia Viernes */
	
-- 1)
CREATE VIEW PedidosCompletadosPorPrecio AS
SELECT 
    Pedido.id_p AS PedidoID,
    Pedido.email_c AS Cliente,
    Usuario.nombre AS NombreTecnico,
    Servicio.servicio_tipo AS TipoServicio,
    Servicio.servicio_costo AS Precio,
    Pedido.estado AS Estado
FROM Pedido
JOIN Servicio ON Pedido.servicio_id = Servicio.servicio_id
JOIN Asigna ON Pedido.id_p = Asigna.id_p
JOIN Usuario ON Asigna.email_t = Usuario.email
WHERE Pedido.estado = 'Finalizado'
ORDER BY Servicio.servicio_costo DESC;

SELECT * FROM PedidosCompletadosPorPrecio;

-- 2)
CREATE VIEW RankingServiciosPorPrecio AS
SELECT 
    servicio_id AS ServicioID,
    servicio_tipo AS TipoServicio,
    servicio_costo AS Precio
FROM 
    Servicio
ORDER BY 
    servicio_costo DESC;

SELECT * FROM RankingServiciosPorPrecio;

-- 3)
CREATE VIEW Agenda_dia_Viernes AS
SELECT 
    Visita.id_v AS VisitaID,
    Visita.id_p AS PedidoID,
    Horario.h_ini AS HoraInicio,
    Horario.h_fin AS HoraFin,
    Visita.dia AS Fecha,
    Usuario.nombre AS Tecnico
FROM 
    Visita
JOIN 
    Horario ON Visita.id_h = Horario.id_h
JOIN 
    Asigna ON Visita.id_p = Asigna.id_p
JOIN 
    Usuario ON Asigna.email_t = Usuario.email
WHERE 
    DAYOFWEEK(Visita.dia) = 6;  -- 6 representa el día Viernes en DAYOFWEEK, no aplica a nuestra DB


-- 3.2)
CREATE VIEW AgendaViernes AS
SELECT 
    Visita.id_v AS VisitaID,
    Visita.id_p AS PedidoID,
    Horario.h_ini AS HoraInicio,
    Horario.h_fin AS HoraFin,
    Visita.dia AS Fecha,
    Usuario.nombre AS Tecnico
FROM 
    Visita
JOIN 
    Horario ON Visita.id_h = Horario.id_h
JOIN 
    Asigna ON Visita.id_p = Asigna.id_p
JOIN 
    Usuario ON Asigna.email_t = Usuario.email
WHERE 
    Visita.dia IN ('2024-11-08', '2024-11-15', '2024-11-07')  -- Fechas de viernes específicas, se debe especificar los dias viernes manualmente
ORDER BY 
    Visita.dia, Horario.h_ini;

SELECT * FROM AgendaViernes;

-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    

-- S.H.I.E.L.D. de MATHYAS KAYAN PEDROZO SILVA

/* 1) Cuantos técnicos hay disponibles?
	2) Segundo servicio más solicitado por los clientes?
	3) Tiempo de demora de un servicio? */
	
-- 1)
CREATE VIEW TecnicosDisponibles AS
SELECT Usuario.email, usuario.nombre
FROM usuario
LEFT JOIN Asigna ON Usuario.email = Asigna.email_t
LEFT JOIN Visita ON Asigna.id_p = Visita.id_p
WHERE Usuario.tipoU = 'Tecnico' 
  AND Usuario.baja = 0
  AND Asigna.email_t IS NULL
  AND Visita.id_v IS NULL;

SELECT * FROM TecnicosDisponibles;

-- 1.1)
CREATE VIEW TecnicosDisponiblesv2 AS
SELECT Usuario.email, Usuario.nombre
FROM Usuario
WHERE Usuario.tipoU = 'Tecnico'
  AND Usuario.baja = 0
  AND Usuario.email NOT IN (SELECT email_t FROM Asigna)
  AND Usuario.email NOT IN (SELECT Asigna.email_t FROM asigna JOIN Visita ON Asigna.id_p = Visita.id_p);
  
 SELECT * FROM TecnicosDisponiblesv2;
 

-- 1.2)
-- CREATE VIEW TecnicosDisponibles AS
SELECT Usuario.email AS tecnicos_disponibles, usuario.nombre AS NombreTecnico
FROM Usuario
WHERE Usuario.tipoU = 'Tecnico'
  AND Usuario.baja = 0
  AND Usuario.email NOT IN (SELECT email_t FROM Asigna)
  AND Usuario.email NOT IN (SELECT Asigna.email_t FROM Asigna INNER JOIN Visita ON Asigna.id_p = Visita.id_p);

-- 2)
CREATE VIEW SegundoServicioMasSolicitado AS
SELECT Servicio.servicio_tipo, COUNT(Pedido.servicio_id) AS cantidad_solicitudes
FROM Pedido
JOIN Servicio ON Pedido.servicio_id = Servicio.servicio_id
GROUP BY Servicio.servicio_id
ORDER BY cantidad_solicitudes DESC
LIMIT 1 OFFSET 1;

 SELECT * FROM SegundoServicioMasSolicitado;

-- 3)
CREATE VIEW Vista_Demora_Servicio AS
SELECT 
    Pedido.id_p AS PedidoID,
    Pedido.email_c AS Cliente,
    Pedido.servicio_id AS ServicioID,
    Servicio.servicio_tipo AS TipoServicio,
    Pedido.f_reg AS FechaRegistro,
    MAX(Visita.dia) AS FechaUltimaVisita,
    TIMESTAMPDIFF(DAY, Pedido.f_reg, MAX(Visita.dia)) AS DiasDemora /* Calcula la diferencia en días entre la fecha de registro del pedido y la última visita (la fecha de finalización del servicio). */
FROM 
    Pedido
JOIN 
    Servicio ON Pedido.servicio_id = Servicio.servicio_id
LEFT JOIN 
    Asigna ON Pedido.id_p = Asigna.id_p
LEFT JOIN 
    Visita ON Asigna.id_p = Visita.id_p
WHERE 
    Pedido.estado = 'Pendiente'
GROUP BY 
    Pedido.id_p, Pedido.email_c, Pedido.servicio_id, Servicio.servicio_tipo, Pedido.f_reg;
    
     SELECT * FROM Vista_Demora_Servicio;
    
-- 3.1)
CREATE VIEW Vista_Demora_Serviciov2 AS
SELECT 
    Pedido.id_p AS PedidoID,
    Pedido.email_c AS Cliente,
    Pedido.servicio_id AS ServicioID,
    Servicio.servicio_tipo AS TipoServicio,
    Pedido.f_reg AS FechaRegistro,
    MAX(Visita.dia) AS FechaUltimaVisita,
    TIMESTAMPDIFF(DAY, Pedido.f_reg, MAX(Visita.dia)) AS DiasDemora /* Calcula la diferencia en días entre la fecha de registro del pedido y la última visita (la fecha de finalización del servicio). */
FROM 
    Pedido
JOIN 
    Servicio ON Pedido.servicio_id = Servicio.servicio_id
JOIN 
    Asigna ON Pedido.id_p = Asigna.id_p
JOIN 
    Visita ON Asigna.id_p = Visita.id_p
WHERE 
    Pedido.estado = 'Pendiente'
GROUP BY 
    Pedido.id_p, Pedido.email_c, Pedido.servicio_id, Servicio.servicio_tipo, Pedido.f_reg;

SELECT *  FROM Vista_Demora_Serviciov2;

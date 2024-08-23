USE testeo;


-- Create database Practico;
/**********************CREATE TABLE********************************
-- ******************** ENVIOS*************************************/
create table Envios ( e_id int not null auto_increment, s_id int, p_id int, id_j
int, cantidad int,
primary key (e_id),
FOREIGN KEY (s_id) REFERENCES Proveedores (s_id),
FOREIGN KEY (p_id) REFERENCES Partes (p_id),
FOREIGN KEY (id_j) REFERENCES Proyectos (id_j));
-- ************************** PARTES************************************/
create table Partes(
p_id int , pnombre varchar (20) not null,
pcolor varchar (20) not null,
peso int ,
ciudad varchar (50),
primary key (p_id));
-- ****************************** PROYECTOS******************************/
create table Proyectos ( id_j int ,
Jnombres varchar (20),
JCiudad varchar (50),
Primary key (id_J) );
-- ***************************** PROVEEDORES*****************************/
create table Proveedores(
Snombres varchar (20),
Situaciones int ,
sciudades varchar (50), s_id int,
Primary key (s_id) );

/*-- ************************* INSERT PROVEEDORES************************/
insert into Proveedores values ( 'salazar', 20,'Londres',1);
insert into Proveedores values ( 'jaimes', 10,'paris',2);
insert into Proveedores values ( 'Bernal', 20,'paris',3);
insert into Proveedores values ( 'jose', 20,'Londres',4);
insert into Proveedores values ( 'aldana',30,'ateneas',5);
/*-- ************************** INSERT PARTES*****************************/
insert into Partes values ( 1, 'Tuerca', 'Rojo', 12, 'Londres' );
insert into Partes values ( 2, 'perno', 'verde',17, 'paris' );
insert into Partes values ( 3, 'birlo', 'azul',17, 'roma' );
insert into Partes values ( 4, 'birlo', 'rojo',14, 'Londres' );
insert into Partes values ( 5, 'leva', 'azul', 12, 'paris' );
insert into Partes values ( 6, 'engrane', 'rojo',19, 'londres' );

/*-- ***************** INSERT PROYECTOS***********************************/
insert into Proyectos values ( 1, 'otro', 'londres' );
insert into Proyectos values ( 2, 'perforadora', 'roma' );
insert into Proyectos values ( 3, 'lectora', 'ateneas' );
insert into Proyectos values ( 4, 'consola', 'ateneas' );
insert into Proyectos values ( 5, 'compaginador', 'londres' );
insert into Proyectos values ( 6, 'terminal', 'oslo');
insert into Proyectos values ( 7, 'cinta', 'londres' );
/* -- ************** INSERTE ENVIOS*************************************/
insert into Envios (s_id, p_id, id_j, cantidad) values ( 1, 1, 1, 200 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 1, 1, 4, 700 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 2, 3, 1, 400 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 2, 3, 2, 200 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 2, 3, 3, 200 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 2, 3, 4, 500 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 2, 3, 5, 600 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 2, 5, 6, 400 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 2, 3, 7, 800 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 2, 5, 2, 100 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 3, 3, 1, 200 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 3, 4, 2, 500 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 4, 6, 3, 300 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 4, 6, 7, 300 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 5, 2, 2, 200 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 5, 2, 4, 100 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 5, 5, 5, 500 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 5, 5, 7, 100 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 5, 5, 6, 100 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 5, 1, 4, 100 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 5, 3, 4, 100 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 5, 4, 4, 200 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 5, 6, 4, 800 );
insert into Envios (s_id, p_id, id_j, cantidad) values ( 1, 6, 4, 800 );
/* -- ************************ CONSULTAS SQL*************************/

ALTER TABLE Envios AUTO_INCREMENT = 1;
SELECT * FROM Proveedores;
SELECT * FROM Envios;

UPDATE Envios SET cantidad = cantidad + 100;
UPDATE Envios SET cantidad = cantidad - 50;
DELETE FROM Envios WHERE cantidad < 100 AND s_id IN (SELECT s_id FROM Proveedores WHERE sciudades = 'Londres');
DELETE FROM Envios WHERE s_id IN (SELECT sciudades FROM Proveedores) AND p_id IN (SELECT ciudad FROM Partes);
#----------------------------------------------------------------------------------------------#
#1
SELECT s_id, Situaciones FROM Proveedores WHERE sciudades = 'paris';
#2
SELECT p_id FROM Partes;
#3
SELECT * FROM Proveedores;
#3
SELECT s_id FROM Proveedores WHERE sciudades = 'paris' AND Situaciones > 20;
#4
SELECT s_id, Situaciones FROM Proveedores WHERE sciudades = 'paris' ORDER BY Situaciones DESC;
#5
SELECT * FROM (Proveedores P JOIN Envios E JOIN Partes ON P.s_id = E.s_id AND Partes.p_id = E.p_id) WHERE P.sciudades = Partes.ciudad;
#6
SELECT * FROM (Proveedores P JOIN Envios E JOIN Partes ON P.s_id = E.s_id AND Partes.p_id = E.p_id) WHERE P.sciudades = Partes.ciudad ORDER BY  P.sciudades , Partes.ciudad;
#7
SELECT * FROM (Proveedores P JOIN Envios E JOIN Partes ON P.s_id = E.s_id AND Partes.p_id = E.p_id) WHERE P.sciudades = Partes.ciudad AND P.Situaciones != 20;
#8
SELECT P.s_id, Partes.p_id FROM (Proveedores P JOIN Envios E JOIN Partes ON P.s_id = E.s_id AND Partes.p_id = E.p_id) WHERE P.sciudades = Partes.ciudad;
#9
SELECT P1.s_id, P2.s_id FROM Proveedores P1, Proveedores P2 WHERE P1.sciudades = P2.sciudades;
#10
SELECT P.ciudad , COUNT(*) AS p_id FROM Partes P;





# APUNTES #

SELECT * FROM (Envios JOIN Proveedores ON Proveedores.s_id = Envios.s_id);


SELECT Snombres Nombre, sciudades Ciudad FROM (Proveedores P JOIN Envios E ON P.s_id = E.s_id) WHERE Snombres = 'salazar';


SELECT P.Snombres Nombre , Proyectos.Jnombres FROM (Proveedores P JOIN Envios E JOIN Proyectos ON P.s_id = E.s_id AND Proyectos.id_j = E.id_j) WHERE P.Snombres = 'salazar';


SELECT  P.Snombres Nombre, Proyectos.Jnombres
FROM (Proveedores P , Envios E , Proyectos)
WHERE P.Snombres = 'salazar' AND P.s_id = E.s_id AND Proyectos.id_j = E.id_j;



/* -- ************************ VISTAS *************************/
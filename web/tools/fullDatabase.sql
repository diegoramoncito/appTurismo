--Execute:
-- psql -d appturismo -a -f fullDatabase.sql


--create database
--CREATE DATABASE appturismo;
--enable postgis
--CREATE EXTENSION postgis;

--Drop all tables before creating again
DROP TABLE IF EXISTS ReporteHistorico CASCADE;
DROP TABLE IF EXISTS DestinoLista CASCADE;
DROP TABLE IF EXISTS Reporte CASCADE;
DROP TABLE IF EXISTS Destino CASCADE;
DROP TABLE IF EXISTS Busqueda CASCADE;

--***********Unrelated tables:

--Busqueda
CREATE TABLE Busqueda
(
  id serial,
  texto text UNIQUE NOT NULL,
  ubicaciondesde Geography,
  ubicaciondestino Geography,
  radius int,
  tags VARCHAR (50),
  resultados json,
  PRIMARY KEY (id)
);

--Reporte
CREATE TABLE Reporte
(
  id serial,
  nombre VARCHAR (50) UNIQUE NOT NULL,
  tabla VARCHAR (50) NOT NULL,
  campos VARCHAR (150),
  PRIMARY KEY (id)
);

--Destino
CREATE TABLE Destino
(
  id serial,
  usuarioUID VARCHAR (250),
  titulo VARCHAR (50),
  ubicacion Geography,
  tipo varchar(120),
  tags VARCHAR (350),
  presupuesto decimal(9,3),
  calificacion int,
  info json,
  activo int,
  PRIMARY KEY (id)
);

--***********Related tables:

-- DestinoLista
CREATE TABLE DestinoLista
(
  id serial,
  destinoMaster INT not null,
  destinoOrden int,
  destinoId INT not null,
  PRIMARY KEY (id),
  FOREIGN KEY (destinoMaster) REFERENCES Destino (id),
  FOREIGN KEY (destinoId) REFERENCES Destino (id)
);

-- ReporteHistorico
CREATE TABLE ReporteHistorico
(
  id serial,
  idReporte int not null,
  resultados json,
  fechaGeneracion timestamp,
  PRIMARY KEY (id),
  FOREIGN KEY (idReporte) REFERENCES Reporte (id)
);


-- transacciones demo
--insert into transaccion(usuarioRuc,UsuarioServicioId,ubicacion,activo)values('9999999999',1,ST_GeomFromText('POINT(-78.485014 -0.1734763)', 4326),true);
--insert into transaccion(usuarioRuc,UsuarioServicioId,ubicacion,activo)values('9999999999',2,ST_GeomFromText('POINT(-78.485014 -0.1734763)', 4326),true);
--insert into transaccion(usuarioRuc,UsuarioServicioId,ubicacion,fechaHora,horaDesde,horaHasta,unidadesFacturadas,montoFacturado,activo)values('9999999999',3,ST_GeomFromText('POINT(-78.485014 -0.1734763)', 4326),'2019-05-24 16:00','16:02','18:10',3,90,true);

create database if not exists factum;
use factum;

create table clientes (
    nif varchar(9) primary key,
    nombre varchar(100),
    direccion varchar(100),
    cp int(5),
    localidad varchar(100),
    telefono varchar(20),
    email varchar(50)
);

create table empresa (
    nif varchar(9) primary key,
    nombrecomercial varchar(10),
    nombrelegal varchar(10),
    dirección varchar(100),
    cp int(5),
    localidad varchar(50),
    telefono varchar(20),
    email varchar(50)
);

create table seriefactura (
    nombreserie varchar(20) primary key,
    tieneiva int(1)
);

create table controlfactura (
    nombreserie varchar(20) primary key references seriefactura,
    anoultimafactura int(4),
    numeroultimafactura int(5)
);

create table facturas (
    numero int(5) primary key,
    nif varchar(9) references clientes,
    nombreserie varchar(20) references seriefactura,
    tieneiva int(1),
    fecha date,
    formapago varchar(20),
    conceptos longtext,
    observaciones text,
    archivada int(1)
);

create table presupuestos (
    numero int(5) primary key,
    nif varchar(9) references clientes,
    serie varchar(20),
    fecha date,
    conceptos longtext,
    observaciones text,
    tieneiva int(1)
);
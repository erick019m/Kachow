drop database if exists kachow;
create database kachow character set utf8mb4;
use kachow;

create table usuarios (
    id int auto_increment primary key,
    usuario varchar(30) not null unique,
    nombre varchar(100) not null,
    clave varchar(255) not null,
    rol varchar(20) not null default 'vendedor',
    activo int not null default 1
);

create table clientes (
    id int auto_increment primary key,
    nombre varchar(100) not null,
    documento varchar(20) not null,
    telefono varchar(20),
    correo varchar(100),
    direccion varchar(150)
);

create table proveedores (
    id int auto_increment primary key,
    nombre varchar(120) not null,
    nit varchar(20) not null,
    rubro varchar(40) not null,
    contacto varchar(100),
    telefono varchar(20),
    correo varchar(100),
    direccion varchar(150)
);

create table productos (
    id int auto_increment primary key,
    codigo varchar(20) not null,
    nombre varchar(120) not null,
    categoria varchar(50) not null,
    marca varchar(50),
    stock int not null default 0,
    stock_minimo int not null default 5,
    precio decimal(10,2) not null default 0
);

create table citas (
    id int auto_increment primary key,
    cliente_id int not null,
    vehiculo varchar(100) not null,
    fecha date not null,
    hora time not null,
    asesor_id int not null,
    motivo varchar(255),
    foreign key (cliente_id) references clientes(id),
    foreign key (asesor_id) references usuarios(id)
);

create table ventas (
    id int auto_increment primary key,
    cliente_id int not null,
    fecha date not null,
    metodo_pago varchar(20) not null,
    total decimal(10,2) not null default 0,
    foreign key (cliente_id) references clientes(id)
);

create table venta_detalle (
    id int auto_increment primary key,
    venta_id int not null,
    producto_id int not null,
    cantidad int not null,
    precio decimal(10,2) not null,
    subtotal decimal(10,2) not null,
    foreign key (venta_id) references ventas(id),
    foreign key (producto_id) references productos(id)
);

insert into usuarios (usuario, nombre, clave, rol) values
('admin',   'Administrador',        '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'administrador'),
('diego',   'Diego Valdivia',       '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'administrador'),
('dennis',  'Dennis Altamirano',    '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'administrador'),
('marcelo', 'Marcelo Butron',       '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'administrador'),
('erick',   'Erick Mendoza',        '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'administrador'),
('mostrador','Rodrigo Mamani',       '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'vendedor'),
('carla',   'Carla Rojas',          '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'vendedor'),
('luis',    'Luis Fernandez',       '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'vendedor');

insert into clientes (nombre, documento, telefono, correo, direccion) values
('Juan Perez Rojas', '6543210', '70000012', 'juan.perez@correo.com', 'Av. America'),
('Talleres Rocha SRL', '1023456027', '44000021', 'contacto@rocha.bo', 'Av. Blanco Galindo'),
('Maria Quispe', '7891234', '70000034', 'maria.quispe@correo.com', 'Calle Jordan');

insert into proveedores (nombre, nit, rubro, contacto, telefono, correo, direccion) values
('Importadora Andina SRL', '1098765021', 'Lubricantes', 'Rosa Claros', '44112233', 'ventas@andina.bo', 'Av. Petrolera km 4'),
('Repuestos del Sur Ltda', '2056789033', 'Frenos', 'Hugo Vargas', '44556677', 'contacto@delsur.bo', 'Av. Blanco Galindo km 2'),
('Llantas del Valle', '3012456018', 'Llantas', 'Pedro Arce', '44223344', 'pedidos@llantasvalle.bo', 'Av. Republica 1520'),
('Motores Cochabamba SRL', '3125987014', 'Motores', 'Juan Torrico', '44667788', 'ventas@motorescbba.bo', 'Av. Villazon km 3'),
('Plasticos Automotrices', '3240561019', 'Plasticos', 'Dennis Rocha', '44889900', 'info@plasticosauto.bo', 'Calle Tumusla 455');

insert into productos (codigo, nombre, categoria, marca, stock, stock_minimo, precio) values
('FA-001', 'Filtro de aire', 'Filtros', 'Bosch', 25, 5, 85.00),
('FA-002', 'Filtro de aceite', 'Filtros', 'Mann', 30, 5, 65.50),
('PF-010', 'Pastillas de freno delanteras', 'Frenos', 'Brembo', 12, 4, 320.00),
('AM-020', 'Amortiguador delantero', 'Suspension', 'Monroe', 8, 3, 540.00),
('BU-030', 'Bujia de encendido', 'Motor', 'NGK', 50, 10, 28.00),
('BA-040', 'Bateria 12V 75Ah', 'Electrico', 'Toyo', 6, 2, 780.00);

insert into citas (cliente_id, vehiculo, fecha, hora, asesor_id, motivo) values
(1, 'Toyota Corolla 2015', '2026-11-20', '09:00:00', 6, 'Cambio de filtros'),
(3, 'Suzuki Vitara 2018', '2026-11-21', '10:30:00', 7, 'Revision de frenos');

insert into ventas (cliente_id, fecha, metodo_pago, total) values
(1, '2026-11-10', 'Efectivo', 235.50),
(2, '2026-11-12', 'Transferencia', 640.00);

insert into venta_detalle (venta_id, producto_id, cantidad, precio, subtotal) values
(1, 1, 2, 85.00, 170.00),
(1, 2, 1, 65.50, 65.50),
(2, 3, 2, 320.00, 640.00);

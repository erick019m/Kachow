use kachow;

insert ignore into usuarios (usuario, nombre, clave, rol) values
('carla', 'Carla Rojas',    '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'vendedor'),
('luis',  'Luis Fernandez', '$2y$10$IDd7Afas3KyGp/nzk42t4.8y01U75U6sVpJdqLWq68qLco7TSQdam', 'vendedor');

alter table proveedores add rubro varchar(40) not null default 'Accesorios' after nit;

alter table citas add asesor_id int null after hora;

update citas set asesor_id = (select id from usuarios
                              where usuarios.nombre = citas.asesor and rol = 'vendedor' limit 1);

update citas set asesor_id = (select min(id) from usuarios where rol = 'vendedor')
where asesor_id is null;

alter table citas modify asesor_id int not null;

alter table citas add foreign key (asesor_id) references usuarios(id);

alter table citas drop column asesor;

select citas.id, citas.fecha, citas.hora, usuarios.nombre as asesor
from citas inner join usuarios on citas.asesor_id = usuarios.id;

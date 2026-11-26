use kachow;

alter table usuarios modify rol varchar(20) not null default 'vendedor';

update usuarios set rol = 'vendedor' where rol <> 'administrador';

select usuario, nombre, rol from usuarios;

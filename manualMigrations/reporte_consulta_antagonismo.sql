/* reporte_consulta_antagonismo */
drop table if exists reporte_consulta_antagonismo;
create table reporte_consulta_antagonismo (
	id bigint(20) unsigned primary key auto_increment,
    id_consulta bigint(20) unsigned not null,
    id_usuario int(10) unsigned not null comment "id del usuario que toma la responsabilidad del reporte",
    fecha date not null,
    hora time not null,
    mensaje text not null,
    foreign key(id_consulta) references conceptos(id_to) on update cascade on delete cascade
);
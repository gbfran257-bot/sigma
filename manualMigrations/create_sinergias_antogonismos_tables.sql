/* SINERGIAS */
drop table if exists sinergia;
create table sinergia (
	id bigint(20) unsigned primary key not null auto_increment,
    id_medicamento bigint(20) unsigned not null comment "medicamento que es seleccionado como sinergico de otro",
    foreign key(id_medicamento) references conceptos(id_to) on update cascade on delete cascade
);

drop table if exists medicamento_sinergia;
create table medicamento_sinergia (
	id bigint(20) unsigned primary key not null auto_increment,
    id_medicamento bigint(20) unsigned not null comment "medicamento del cual se quieren conocer sus sinergias",
    id_sinergia bigint(20) unsigned not null,
    foreign key(id_medicamento) references conceptos(id_to) on update cascade on delete cascade,
    foreign key(id_sinergia) references sinergia(id) on update cascade on delete cascade
);

/* ANTAGONISMOS */
drop table if exists antagonismo;
create table antagonismo (
	id bigint(20) unsigned primary key not null auto_increment,
    id_medicamento bigint(20) unsigned not null comment "medicamento que es seleccionado como antagonista de otro",
    foreign key(id_medicamento) references conceptos(id_to) on update cascade on delete cascade
);

drop table if exists medicamento_antagonismo;
create table medicamento_antagonismo (
	id bigint(20) unsigned primary key not null auto_increment,
    id_medicamento bigint(20) unsigned not null comment "medicamento del cual se quieren conocer sus antagonismos",
    id_antagonismo bigint(20) unsigned not null,
    foreign key(id_medicamento) references conceptos(id_to) on update cascade on delete cascade,
    foreign key(id_antagonismo) references antagonismo(id) on update cascade on delete cascade
);
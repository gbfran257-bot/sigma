drop table if exists pacientes_facturables;
create table pacientes_facturables(
    id int(4) primary key auto_increment,
    id_paciente bigint(20) unsigned not null,
    id_paciente_facturable bigint(20) unsigned not null,
    foreign key(id_paciente) references pacientes(id_p) on update cascade on delete restrict,
    foreign key(id_paciente_facturable) references pacientes(id_p) on update cascade on delete restrict
);
ALTER TABLE pacientes ADD titular TINYINT(1) NOT NULL;
ALTER TABLE pacientes ADD paciente_titular BIGINT(20) UNSIGNED AFTER titular;
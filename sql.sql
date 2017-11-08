create table partida(
	id int auto_increment,
	fecha datetime default now(),
	status int,
	primary key (id)
);

create table movimiento(
	id int auto_increment,
	id_partida int,
	posicion int,
	turno	int,
	probabilidad int,
	primary key (id)
);

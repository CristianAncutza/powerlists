use PowerLists;

create table Usuario (
	id_usuario bigint primary key,
	nombre_usuario varchar(30),
	clave varchar(30),
	email varchar(30),
	nombre varchar(20),
	apellido varchar(20),
	rol varchar(15)
);

create table Genero (
	id_genero int primary key,
	nombre varchar(20)
);

create table Playlist (
	id_playlist bigint primary key,
	nombre varchar(20),
	id_genero int,
	categoria varchar(20),
	tipo varchar(10),
	fecha_creacion datetime,
	fecha_ult_mod datetime,
	id_usuario_creador bigint,
	foreign key (id_usuario_creador) references Usuario(id_usuario),
	foreign key (id_genero) references Genero(id_genero)
);

insert into Genero values
(1, 'Rock'),(2, 'Dance'),(3, 'Pop'),(4, 'Salsa'),(5, 'Cumbia');

create table Solicitud (
	id_usuario_solicitado bigint,
	id_usuario_solicitante bigint,
	estado int,
	fecha datetime,
	primary key (id_usuario_solicitado, id_usuario_solicitante),
	foreign key (id_usuario_solicitado) references Usuario(id_usuario),
	foreign key (id_usuario_solicitante) references Usuario(id_usuario)
);

create table PlaylistUsuario (
	id_playlist bigint,
	id_usuario bigint,
	primary key (id_playlist, id_usuario),
	foreign key (id_playlist) references Playlist(id_playlist),
	foreign key (id_usuario) references Usuario(id_usuario)
);

create table Notificacion (
	id_notificacion bigint primary key,
	id_usuario bigint,
	descripcion varchar(70),
	foreign key (id_usuario) references Usuario(id_usuario)
);

create table Voto (
	id_playlist bigint,
	id_usuario bigint,
	voto int,
	primary key (id_playlist, id_usuario),
	foreign key (id_playlist) references Playlist(id_playlist),
	foreign key (id_usuario) references Usuario(id_usuario)
);

create table Track (
	id_track bigint primary key,
	titulo varchar(60)
);

create table PlaylistTrack (
	id_playlist bigint,
	id_track bigint,
	primary key (id_playlist, id_track),
	foreign key (id_playlist) references Playlist(id_playlist),
	foreign key (id_track) references Track(id_track)
);
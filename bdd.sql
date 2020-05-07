


CREATE TABLE IF NOT EXISTS serie
(
    nom_serie varchar (32) not null,
    description varchar (1024),
    primary key (nom_serie)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS episodes
(
    n_saison int not null,
    n_episode int not null,
    duree int,
    synopsys varchar (1024),
    nom_serie varchar (32) not null, 
    primary key (n_saison, n_episode, nom_serie),
    foreign key (nom_serie) references serie (nom_serie)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS plateforme_streaming
(
    nom_platf varchar (32) not null,
    societe varchar (32),
    primary key (nom_platf)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pays
(
    nom_platf varchar(32) not null,
    ordre int not null,
    pays varchar (64),
    primary key (nom_platf, ordre),
    foreign key (nom_platf) references plateforme_streaming (nom_platf)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS personne
(
    numero int not null,
    nom varchar(64),
    prenom varchar (64),
    date_naissance date,
    primary key (numero)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS utilisateur
(
    numero int not null,
    adress_email varchar(256),
    primary key (numero),
    foreign key (numero) references personne (numero)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS acteur
(
    numero int not null,
    golden_globes int,
    emmy_awards int,
    primary key (numero),
    foreign key (numero) references personne (numero)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS disponible_sur
(
    nom_serie varchar (32) not null,
    nom_platf varchar (32) not null,
    primary key (nom_serie, nom_platf),
    foreign key (nom_serie) references serie (nom_serie),
    foreign key (nom_platf) references plateforme_streaming (nom_platf)    
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS joue_dans
(
    numero int not null,
    n_saison int not null,
    n_episode int not null, 
    nom_serie varchar (32) not null,
    primary key (numero, n_saison, n_episode, nom_serie),
    foreign key (numero) references personne (numero),
    foreign key (n_saison, n_episode, nom_serie) references episodes (n_saison, n_episode, nom_serie)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS est_abonne
(
    date_debut date not null,
    date_fin date,
    numero int not null,
    nom_platf varchar (32) not null,
    primary key (date_debut, numero, nom_platf),
    foreign key (numero) references personne (numero),
    foreign key (nom_platf) references plateforme_streaming (nom_platf)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS regarde
(
    numero int not null,
    nom_platf varchar (32) not null,
    n_episode int not null,
    n_saison int not null,
    nom_serie varchar(32) not null,
    date_debut date,
    primary key (numero, nom_platf, n_saison, n_episode, nom_serie),
    foreign key (numero) references utilisateur (numero),
    foreign key (nom_platf) references plateforme_streaming (nom_platf),
    foreign key (n_saison, n_episode, nom_serie) references episodes (n_saison, n_episode, nom_serie)
) ENGINE=InnoDB;
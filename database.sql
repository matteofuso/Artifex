create database artifex;
use artifex;

create table siti_interesse(
sid int primary key auto_increment,
nome varchar(100) not null unique,
luogo varchar(100) not null
);

create table visite(
vid int primary key auto_increment,
titolo varchar(100) not null unique,
descrizione text,
durata_media int -- minuti
);

create table visite_siti(
vsid int primary key auto_increment,
id_sito int not null,
id_visita int not null,
unique(id_sito, id_visita),
foreign key (id_sito) references siti_interesse(sid),
foreign key (id_visita) references visite(vid)
);

create table eventi(
eid int primary key auto_increment,
inizio datetime not null,
minimo_partecipanti int not null,
massimo_partecipanti int not null,
prezzo decimal(10,2) not null,
id_visita int not null,
unique (inizio, id_visita),
foreign key(id_visita) references visite(vid)
);

create table titoli_studio(
tsid int primary key auto_increment,
titolo varchar(100) not null unique
);

create table guide(
gid int primary key auto_increment,
nome varchar(100) not null,
cognome varchar(100) not null,
luogo_nascita varchar(100) not null,
data_nascita date not null,
id_titolo_studio int not null,
foreign key(id_titolo_studio) references titoli_studio(tsid)
);

create table lingue(
lid int primary key auto_increment,
lingua varchar(100) not null unique
);

create table livelli_linguistici(
llid int primary key auto_increment,
EQF varchar(10) not null unique,
descrizione varchar(100)
);

create table illustrazioni(
iid int primary key auto_increment,
id_guida int not null,
id_evento int not null,
id_lingua int not null,
unique(id_evento, id_guida),
foreign key (id_guida) references guide(gid),
foreign key (id_evento) references eventi(eid),
foreign key (id_lingua) references lingue(lid)
);

create table conoscenze_linguistiche(
cid int primary key auto_increment,
id_guida int not null,
id_livello int not null,
id_lingua int not null,
unique(id_lingua, id_guida),
foreign key (id_guida) references guide(gid),
foreign key (id_livello) references livelli_linguistici(llid),
foreign key (id_lingua) references lingue(lid)
);

create table tipologia_account(
tid int primary key auto_increment,
tipologia varchar(100) not null unique
);

create table account(
aid int primary key auto_increment,
email varchar(100) unique not null,
nome varchar(100) not null,
cognome varchar(100) not null,
password varchar(100) not null,
telefono varchar(100),
id_tipologia int not null default 1,
id_lingua int,
foreign key (id_lingua) references lingue(lid),
foreign key (id_tipologia) references tipologia_account(tid)
);

create table carrello(
cid int primary key auto_increment,
id_evento int not null,
id_turista int not null,
quantita int not null,
unique(id_evento, id_turista),
foreign key (id_evento) references eventi(eid),
foreign key (id_turista) references account(aid)
);

create table ordini(
oid int primary key auto_increment,
id_evento int not null,
id_turista int not null,
data datetime not null,
quantita int not null,
unique(id_evento, id_turista),
foreign key (id_evento) references eventi(eid),
foreign key (id_turista) references account(aid)
);

-- Populate siti_interesse
INSERT INTO siti_interesse (nome, luogo) VALUES
('Colosseo', 'Roma'),
('Torre di Pisa', 'Pisa'),
('Duomo di Milano', 'Milano'),
('Palazzo Vecchio', 'Firenze'),
('Castel dell''Ovo', 'Napoli'),
('Basilica di San Marco', 'Venezia'),
('Valle dei Templi', 'Agrigento'),
('Trulli di Alberobello', 'Alberobello'),
('Reggia di Caserta', 'Caserta'),
('Acquario di Genova', 'Genova'),
('Foro Romano', 'Roma'),
('Palatino', 'Roma'),
('Galleria degli Uffizi', 'Firenze'),
('Ponte Vecchio', 'Firenze'),
('Piazza San Marco', 'Venezia');

-- Populate titoli_studio
INSERT INTO titoli_studio (titolo) VALUES
('Laurea in Storia dell''Arte'),
('Laurea in Architettura'),
('Laurea in Archeologia'),
('Laurea in Scienze Turistiche'),
('Laurea in Storia'),
('Laurea in Beni Culturali'),
('Laurea in Lingue'),
('Diploma Accademia Belle Arti'),
('Master in Management dei Beni Culturali'),
('Dottorato in Storia Antica');

-- Populate lingue
INSERT INTO lingue (lingua) VALUES
('Italiano'),
('Inglese'),
('Francese'),
('Tedesco'),
('Spagnolo'),
('Russo'),
('Cinese'),
('Giapponese'),
('Arabo'),
('Portoghese');

-- Populate livelli_linguistici
INSERT INTO livelli_linguistici (EQF, descrizione) VALUES
('A1', 'Livello base'),
('A2', 'Livello elementare'),
('B1', 'Livello intermedio'),
('B2', 'Livello intermedio superiore'),
('C1', 'Livello avanzato'),
('C2', 'Livello di padronanza');

-- Populate guide
INSERT INTO guide (nome, cognome, luogo_nascita, data_nascita, id_titolo_studio) VALUES
('Marco', 'Rossi', 'Roma', '1980-05-15', 1),
('Laura', 'Bianchi', 'Milano', '1985-07-22', 2),
('Giovanni', 'Verdi', 'Firenze', '1975-03-10', 3),
('Sofia', 'Ferrari', 'Venezia', '1990-09-30', 4),
('Alessandro', 'Russo', 'Napoli', '1982-11-25', 5),
('Francesca', 'Esposito', 'Torino', '1988-02-18', 6),
('Luca', 'Romano', 'Palermo', '1979-06-12', 7),
('Martina', 'Ricci', 'Bologna', '1992-04-05', 8),
('Davide', 'Marini', 'Genova', '1981-10-20', 9),
('Elena', 'Conti', 'Bari', '1987-01-13', 10);

-- Populate conoscenze_linguistiche
INSERT INTO conoscenze_linguistiche (id_guida, id_livello, id_lingua) VALUES
(1, 6, 1), -- Marco: Italiano C2
(1, 5, 2), -- Marco: Inglese C1
(1, 4, 3), -- Marco: Francese B2
(2, 6, 1), -- Laura: Italiano C2
(2, 5, 2), -- Laura: Inglese C1
(2, 5, 5), -- Laura: Spagnolo C1
(3, 6, 1), -- Giovanni: Italiano C2
(3, 4, 2), -- Giovanni: Inglese B2
(3, 6, 4), -- Giovanni: Tedesco C2
(4, 6, 1), -- Sofia: Italiano C2
(4, 5, 2), -- Sofia: Inglese C1
(4, 4, 10), -- Sofia: Portoghese B2
(5, 6, 1), -- Alessandro: Italiano C2
(5, 4, 2), -- Alessandro: Inglese B2
(5, 3, 5), -- Alessandro: Spagnolo B1
(6, 6, 1), -- Francesca: Italiano C2
(6, 5, 2), -- Francesca: Inglese C1
(6, 5, 6), -- Francesca: Russo C1
(7, 6, 1), -- Luca: Italiano C2
(7, 5, 2), -- Luca: Inglese C1
(7, 3, 9), -- Luca: Arabo B1
(8, 6, 1), -- Martina: Italiano C2
(8, 6, 2), -- Martina: Inglese C2
(8, 4, 7), -- Martina: Cinese B2
(9, 6, 1), -- Davide: Italiano C2
(9, 5, 2), -- Davide: Inglese C1
(9, 4, 5), -- Davide: Spagnolo B2
(10, 6, 1), -- Elena: Italiano C2
(10, 5, 2), -- Elena: Inglese C1
(10, 4, 8); -- Elena: Giapponese B2

-- Populate tipologia_account
INSERT INTO tipologia_account (tipologia) VALUES
('Turista'),
('Amministratore');

-- Populate visite
INSERT INTO visite (titolo, descrizione, durata_media) VALUES
('Tour Classico del Colosseo', 'Visita guidata standard con accesso all''arena e ai sotterranei', 120),
('Torre Pendente e Piazza dei Miracoli', 'Visita completa della piazza e salita sulla torre', 90),
('Percorso sulla Terrazza del Duomo', 'Visita guidata con salita alle terrazze panoramiche', 150),
('Storia di Firenze e dei Medici', 'Tour culturale attraverso la storia di Palazzo Vecchio', 180),
('Leggende del Castello sul Mare', 'Tour panoramico e storico del Castel dell''Ovo', 60),
('Splendori della Serenissima', 'Tour completo della Basilica e del Palazzo Ducale', 120),
('Civiltà Greca in Sicilia', 'Percorso archeologico nella Valle dei Templi', 180),
('Architettura e Vita nei Trulli', 'Visita delle abitazioni tradizionali pugliesi', 60),
('Fasto dei Borbone', 'Tour completo della Reggia e dei giardini', 200),
('Vita Sottomarina', 'Percorso guidato tra le vasche dell''acquario', 120),
('Tour Completo Roma Antica', 'Visita guidata al Colosseo, Foro Romano e Palatino', 240),
('Firenze Rinascimentale', 'Tour dei principali monumenti rinascimentali di Firenze', 300),
('Venezia e le sue Isole', 'Tour completo di Venezia incluse Murano e Burano', 360);

-- Populate visite_siti (con visite che includono più siti)
INSERT INTO visite_siti (id_sito, id_visita) VALUES
(1, 1), -- Colosseo - Tour Classico
(2, 2), -- Torre di Pisa - Torre Pendente
(3, 3), -- Duomo di Milano - Percorso Terrazza
(4, 4), -- Palazzo Vecchio - Storia di Firenze
(5, 5), -- Castel dell'Ovo - Leggende
(6, 6), -- Basilica di San Marco - Splendori
(7, 7), -- Valle dei Templi - Civiltà Greca
(8, 8), -- Trulli - Architettura
(9, 9), -- Reggia di Caserta - Fasto
(10, 10), -- Acquario - Vita Sottomarina
(1, 11), -- Colosseo - Tour Roma Antica
(11, 11), -- Foro Romano - Tour Roma Antica
(12, 11), -- Palatino - Tour Roma Antica
(4, 12), -- Palazzo Vecchio - Firenze Rinascimentale
(13, 12), -- Galleria Uffizi - Firenze Rinascimentale
(14, 12), -- Ponte Vecchio - Firenze Rinascimentale
(6, 13), -- Basilica San Marco - Venezia e Isole
(15, 13); -- Piazza San Marco - Venezia e Isole

-- Populate eventi (date future rispetto alla data attuale 2025-04-23)
INSERT INTO eventi (inizio, minimo_partecipanti, massimo_partecipanti, prezzo, id_visita) VALUES
('2025-05-15 10:00:00', 5, 25, 25.00, 1),
('2025-05-16 14:30:00', 5, 25, 25.00, 1),
('2025-05-15 09:30:00', 3, 15, 18.50, 2),
('2025-05-17 11:00:00', 3, 15, 18.50, 2),
('2025-05-18 10:00:00', 5, 20, 22.00, 3),
('2025-05-20 15:00:00', 5, 20, 22.00, 3),
('2025-05-15 09:00:00', 4, 15, 30.00, 4),
('2025-05-19 14:00:00', 4, 15, 30.00, 4),
('2025-05-22 10:30:00', 2, 10, 15.00, 5),
('2025-05-24 16:00:00', 2, 10, 15.00, 5),
('2025-05-16 09:30:00', 5, 25, 35.00, 6),
('2025-05-23 11:30:00', 5, 25, 35.00, 6),
('2025-05-25 08:30:00', 3, 20, 28.00, 7),
('2025-05-27 16:30:00', 3, 20, 28.00, 7),
('2025-05-28 10:00:00', 2, 12, 12.50, 8),
('2025-05-30 15:00:00', 2, 12, 12.50, 8),
('2025-06-01 09:00:00', 5, 30, 32.00, 9),
('2025-06-03 14:00:00', 5, 30, 32.00, 9),
('2025-06-05 10:00:00', 4, 25, 24.50, 10),
('2025-06-07 15:30:00', 4, 25, 24.50, 10),
('2025-05-15 08:00:00', 8, 30, 45.00, 11),
('2025-05-22 08:00:00', 8, 30, 45.00, 11),
('2025-05-18 09:00:00', 6, 20, 50.00, 12),
('2025-05-25 09:00:00', 6, 20, 50.00, 12),
('2025-05-20 08:30:00', 8, 25, 60.00, 13),
('2025-05-27 08:30:00', 8, 25, 60.00, 13);

-- Populate illustrazioni (abbinamenti guide-eventi con lingue specifiche)
INSERT INTO illustrazioni (id_guida, id_evento, id_lingua) VALUES
(1, 1, 1), -- Marco guida evento 1 in Italiano
(1, 2, 2), -- Marco guida evento 2 in Inglese
(2, 3, 1), -- Laura guida evento 3 in Italiano
(2, 4, 5), -- Laura guida evento 4 in Spagnolo
(3, 5, 1), -- Giovanni guida evento 5 in Italiano
(3, 6, 4), -- Giovanni guida evento 6 in Tedesco
(4, 7, 1), -- Sofia guida evento 7 in Italiano
(4, 8, 2), -- Sofia guida evento 8 in Inglese
(5, 9, 1), -- Alessandro guida evento 9 in Italiano
(5, 10, 2), -- Alessandro guida evento 10 in Inglese
(6, 11, 1), -- Francesca guida evento 11 in Italiano
(6, 12, 6), -- Francesca guida evento 12 in Russo
(7, 13, 1), -- Luca guida evento 13 in Italiano
(7, 14, 2), -- Luca guida evento 14 in Inglese
(8, 15, 1), -- Martina guida evento 15 in Italiano
(8, 16, 2), -- Martina guida evento 16 in Inglese
(9, 17, 1), -- Davide guida evento 17 in Italiano
(9, 18, 2), -- Davide guida evento 18 in Inglese
(10, 19, 1), -- Elena guida evento 19 in Italiano
(10, 20, 2), -- Elena guida evento 20 in Inglese
(1, 21, 1), -- Marco guida evento 21 (Tour Roma Antica) in Italiano
(1, 22, 2), -- Marco guida evento 22 (Tour Roma Antica) in Inglese
(3, 23, 1), -- Giovanni guida evento 23 (Firenze Rinascimentale) in Italiano
(3, 24, 4), -- Giovanni guida evento 24 (Firenze Rinascimentale) in Tedesco
(4, 25, 1), -- Sofia guida evento 25 (Venezia e Isole) in Italiano
(4, 26, 2); -- Sofia guida evento 26 (Venezia e Isole) in Inglese
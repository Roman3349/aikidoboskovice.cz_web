CREATE TABLE IF NOT EXISTS clanky (
  id int(11) AUTO_INCREMENT,
  titulek varchar(255),
  obsah text,
  url varchar(255),
  popisek varchar(255),
  klicova_slova varchar(255),
  PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS stranky (
  id int(11) AUTO_INCREMENT,
  titulek varchar(255),
  obsah text,
  url varchar(255),
  popisek varchar(255),
  klicova_slova varchar(255),
  PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS komentare (
  id int(11) AUTO_INCREMENT,
  autor varchar(255),
  titulek varchar(255),
  obsah text,
  PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS admini (
  jmeno varchar(255)
);
INSERT INTO  clanky (id, titulek, obsah, url, popisek, klicova_slova) VALUES ( NULL ,  'Úvod',  '<p>Vítejte na našem webu!</p><br><p>Tento web je postaven na <strong>jednoduchém MVC frameworku v PHP</strong>. Toto je úvodní článek, načtený z databáze.</p>', 'uvod',  'Úvodní článek na webu v MVC v PHP',  'úvod, mvc, web');
INSERT INTO admini (jmeno) VALUES ('Roman3349');
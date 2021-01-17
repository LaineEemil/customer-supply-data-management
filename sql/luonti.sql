CREATE TABLE asiakas(
atunnus VARCHAR(50),
nimi VARCHAR(50) NOT NULL,
osoite VARCHAR(50) NOT NULL,
postiosoite VARCHAR(5) NOT NULL,
puhnro VARCHAR(50) NOT NULL,
sposti VARCHAR(50),
PRIMARY KEY (atunnus));

CREATE TABLE tyokohde(
kohdetunnus VARCHAR(50),
atunnus VARCHAR(50) NOT NULL,
kuvaus VARCHAR(300),
osoite VARCHAR(50) NOT NULL,
postiosoite VARCHAR(5) NOT NULL,
suunnittelualennus INT,
tyoalennus INT,
aputyoalennus INT,
PRIMARY KEY (kohdetunnus),
FOREIGN KEY (atunnus) REFERENCES asiakas(atunnus));

CREATE TABLE tyotunnit(
tuntitunnus VARCHAR(50),
kohdetunnus VARCHAR(50) NOT NULL,
paivamaara DATE NOT NULL,
tyonmaara INT NOT NULL,
tyotapa VARCHAR(50) NOT NULL,
PRIMARY KEY (tuntitunnus),
FOREIGN KEY (kohdetunnus) REFERENCES tyokohde(kohdetunnus));

CREATE TABLE tarvikkeet(
tarviketunnus VARCHAR(50),
tuotetunnus VARCHAR(50),
nimi VARCHAR(50) NOT NULL,
kuvaus VARCHAR(50),
yksikko VARCHAR (10) NOT NULL,
varastotilanne INT NOT NULL,
ostohinta decimal(10,2) NOT NULL,
myyntihinta decimal(10,2) NOT NULL,
alv INT NOT NULL,
UNIQUE (tuotetunnus),
PRIMARY KEY (tarviketunnus));

CREATE TABLE tarvikehistoria(
tarviketunnus VARCHAR(50),
tuotetunnus VARCHAR(50),
nimi VARCHAR(50) NOT NULL,
kuvaus VARCHAR(50),
yksikko VARCHAR (10) NOT NULL,
varastotilanne INT NOT NULL,
ostohinta decimal(10,2) NOT NULL,
myyntihinta decimal(10,2) NOT NULL,
alv INT NOT NULL,
UNIQUE (tuotetunnus),
PRIMARY KEY (tarviketunnus));

CREATE TABLE ktarvikkeet(
ktarviketunnus VARCHAR(50),
kohdetunnus VARCHAR(50) NOT NULL,
tarviketunnus VARCHAR(50) NOT NULL,
nimi VARCHAR(50),
maara INT NOT NULL,
paivamaara DATE NOT NULL,
PRIMARY KEY (ktarviketunnus),
FOREIGN KEY (kohdetunnus) REFERENCES tyokohde(kohdetunnus),
FOREIGN KEY (tarviketunnus) REFERENCES tarvikkeet(tarviketunnus));

CREATE TABLE lasku(
laskutunnus VARCHAR(50),
kohdetunnus VARCHAR(50) NOT NULL,
edellisenlaskuntunnus VARCHAR(50),
viitenumero VARCHAR(50),
paivamaara DATE NOT NULL,
erapaiva DATE NOT NULL,
summa decimal(10,2) NOT NULL,
korotettusumma decimal(10,2),
maksettu BOOLEAN,
lahetettypaivamaara DATE,
maksettupaivamaara DATE,
PRIMARY KEY (laskutunnus),
UNIQUE (viitenumero),
FOREIGN KEY (kohdetunnus) REFERENCES tyokohde(kohdetunnus));

CREATE TABLE login(
id int,
sposti VARCHAR(50) NOT NULL,
salasana VARCHAR(50) NOT NULL,
PRIMARY KEY (id));

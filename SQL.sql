﻿alter table th_hotels drop column prozent;
alter table th_hotels drop column prozent_text;
alter table th_hotels drop column prozent_von;
alter table th_hotels drop column prozent_bis;
alter table th_hotels drop column prozent_name;

drop table if exists th_hotel_passwords;
drop table if exists th_hotel_prozente;

create table th_hotel_passwords (hotel_id int not null, password binary(16), primary key(hotel_id));
create table th_hotel_prozente (prozente_id int not null auto_increment,hotel_id int not null, aktion_id int not null, prozent decimal(3,2) not null, prozent_name varchar(100), prozent_von int unsigned, prozent_bis int unsigned, primary key(prozente_id));

create table th_hotel_rabatt_aktion (aktion_id int not null auto_increment primary key, hotel_id int not null, aktion_name varchar(100) not null); 

INSERT into th_hotel_passwords (hotel_id) VALUES (1292);
update th_hotel_passwords set `password`=UNHEX(MD5("123456")) where hotel_id=1292;

INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name) VALUES (1292, 'Auf die erste Übernachtung');
INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name) VALUES (1292, 'Auf alle Übernachtungen');
INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name) VALUES (1292, 'Auf alle Speisen');
INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name) VALUES (1292, 'Auf alle Getränke');
INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name) VALUES (1292, 'Auf die gesamte Rechnung');

insert into th_hotel_prozente (hotel_id, aktion_id

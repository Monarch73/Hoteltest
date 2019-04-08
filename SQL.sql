alter table th_hotels drop column prozent;
alter table th_hotels drop column prozent_text;
alter table th_hotels drop column prozent_von;
alter table th_hotels drop column prozent_bis;
alter table th_hotels drop column prozent_name;

drop table if exists th_hotel_passwords;
drop table if exists th_hotel_prozente;
drop table if exists th_hotel_rabatt_aktion;

create table th_hotel_passwords (hotel_id int not null, password binary(16), chpwd_code varchar(100), chpwd_code_expires int unsigned,  primary key(hotel_id));
create table th_hotel_prozente (prozente_id int not null auto_increment,hotel_id int not null, prozent decimal(8,3) not null, prozent_name varchar(100), prozent_von int unsigned, prozent_bis int unsigned, selected tinyint not null, primary key(prozente_id));

create table th_hotel_rabatt_aktion (aktion_id int not null auto_increment primary key, hotel_id int not null, aktion_name varchar(100) not null, selected tinyint not null); 

INSERT into th_hotel_passwords (hotel_id) VALUES (1292);
update th_hotel_passwords set `password`=UNHEX(MD5("123456")) where hotel_id=1292;

INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name, selected) VALUES (1292, 'Auf die erste Übernachtung',0);
INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name, selected) VALUES (1292, 'Auf alle Übernachtungen',0);
INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name, selected) VALUES (1292, 'Auf alle Speisen',0);
INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name, selected) VALUES (1292, 'Auf alle Getränke',0);
INSERT INTO th_hotel_rabatt_aktion (hotel_id, aktion_name,selected) VALUES (1292, 'Auf die gesamte Rechnung',0);

insert into th_hotel_prozente (hotel_id, prozent_name, prozent, selected) VALUEs (1292, '0%',0,0);
insert into th_hotel_prozente (hotel_id, prozent_name, prozent, selected) VALUEs (1292, '5%',5,0);
insert into th_hotel_prozente (hotel_id, prozent_name, prozent, selected) VALUEs (1292, '10%',10,0);
insert into th_hotel_prozente (hotel_id, prozent_name, prozent, selected) VALUEs (1292, '15%',15,0);
insert into th_hotel_prozente (hotel_id, prozent_name, prozent, selected) VALUEs (1292, '20%',20,0);
insert into th_hotel_prozente (hotel_id, prozent_name, prozent, selected) VALUEs (1292, '25%',25,0);
insert into th_hotel_prozente (hotel_id, prozent_name, prozent, selected) VALUEs (1292, '50%',50,0);

update th_hotels set hotel_email ='monarch@hotmail.de' where hotel_id=1292;


CREATE UNIQUE INDEX idx_hotel_email ON th_hotels(hotel_email);

select * from th_hotels where hotel_email = 'kaarst@redaktion-i-media.de';

select hotel_email, count(*) as cnt from th_hotels GROUP by hotel_email order by cnt desc;

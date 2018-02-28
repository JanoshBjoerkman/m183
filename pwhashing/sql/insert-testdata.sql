set autocommit = 0;
start transaction;


insert into role (code) values ('ADM');
insert into role (code) values ('STD');


insert into user
    (firstname, lastname, mail, role_id)
  values
    ('Grady', 'Booch', 'gbo@oonet.com', (select id from role where code = 'ADM'));
insert into proprietary_auth
    (id, pwd)
  values
    ((select LAST_INSERT_ID()), '123');

insert into user
    (firstname, lastname, mail, role_id)
  values
    ('Niklaus', 'Wirth', 'nw@inf.ethz.ch', (select id from role where code = 'STD'));
insert into proprietary_auth
    (id, pwd)
  values
    ((select LAST_INSERT_ID()), '123');

insert into user
    (firstname, lastname, mail, role_id)
  values
    ('Dennis', 'Ritchie', 'dr@bell.org', (select id from role where code = 'STD'));
insert into proprietary_auth
    (id, pwd)
  values
    ((select LAST_INSERT_ID()), '123');

insert into user
    (firstname, lastname, mail, role_id)
  values
    ('Edgar', 'Codd', 'ec@oxf.edu', (select id from role where code = 'STD'));
insert into proprietary_auth
    (id, pwd)
  values
    ((select LAST_INSERT_ID()), '123');

    commit;
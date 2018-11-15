drop user IF EXISTS 'labor-user'@'localhost';

create user 'labor-user'@'localhost' identified by 'kn4YkSg8pm';

grant all privileges on dblabor.* to 'labor-user'@'localhost'
with grant option;

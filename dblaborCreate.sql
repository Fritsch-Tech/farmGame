CREATE DATABASE dblabor;

CREATE TABLE user(
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  surname varchar(50) NOT NULL,
  username varchar(50) NOT NULL,
  hash varchar(64) NOT NULL,
  eMail varchar(256) NOT NULL,
  PRIMARY KEY(id)
);

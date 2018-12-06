DROP DATABASE IF EXISTS farmsim;
CREATE DATABASE farmsim;

drop user IF EXISTS 'laborUser'@'localhost';

create user 'laborUser'@'localhost' identified by 'kn4YkSg8pm';

grant all privileges on farmsim.* to 'laborUser'@'localhost'
with grant option;

USE farmsim;

CREATE TABLE user(
      id INT NOT NULL AUTO_INCREMENT,
      name varchar(50) NOT NULL,
      surname varchar(50) NOT NULL,
      username varchar(50) NOT NULL,
      hash varchar(64) NOT NULL,
      eMail varchar(256) NOT NULL,
      UNIQUE(username),
      PRIMARY KEY(id)
);

CREATE TABLE farm(
      id INT NOT NULL AUTO_INCREMENT,
      userId INT NOT NULL,
      name varchar(50) NOT NULL,
      money INT NOT NULL,
      sizeX INT NOT NULL,
      sizeY INT NOT NULL,
      PRIMARY KEY(id),
      FOREIGN KEY (userId) REFERENCES user(id)
);

CREATE TABLE item(
      id INT NOT NULL AUTO_INCREMENT,
      name varchar(50) NOT NULL,
      image varchar(50) NOT NULL,
      value INT NOT NULL,
      PRIMARY KEY(id)
);

CREATE TABLE crop(
      id INT NOT NULL AUTO_INCREMENT,
      name varchar(50) NOT NULL,
      image varchar(50) NOT NULL,
      price INT NOT NULL,
      growTime INT NOT NULL,
      dropId INT NOT NULL,
      PRIMARY KEY(id),
      FOREIGN KEY (dropId) REFERENCES item(id)
);

CREATE TABLE field(
      id INT NOT NULL AUTO_INCREMENT,
      farmId INT NOT NULL,
      posX INT NOT NULL,
      posY INT NOT NULL,
      cropId INT,
      sowTime TIMESTAMP,
      PRIMARY KEY(id),
      UNIQUE(posX,posY,farmId),
      FOREIGN KEY (farmId) REFERENCES farm(id),
      FOREIGN KEY (cropId) REFERENCES crop(id)
);

CREATE TABLE inventory(
      farmId INT NOT NULL,
      itemId INT NOT NULL,
      quantity INT NOT NULL,
      PRIMARY KEY(farmId,itemId),
      FOREIGN KEY (farmId) REFERENCES farm(id),
      FOREIGN KEY (itemId) REFERENCES item(id)
);

INSERT INTO user (name,surname,username,hash,email)
VALUES ('root','root','root','$2y$10$S5Pq.0fIMmP6uA5IuC1ydOt7NiMgl6ORGqkbqse8PFsGKtqloXsxW','root@root.root');

INSERT INTO farm (userId,name,sizeX,sizeY,money)
VALUES (1,'SuperFarm',5,5,100);

INSERT INTO item (name,image,value)
VALUES ('Corn','C',50);

INSERT INTO item (name,image,value)
VALUES ('Wheat','W',10);

INSERT INTO crop (name,image,price,growTime,dropId)
VALUES ('Corn','c',8,240,1);

INSERT INTO crop (name,image,price,growTime,dropId)
VALUES ('Wheat','w',3,60,2);

INSERT INTO field (farmId,posX,posY)
VALUES (1,1,1);

INSERT INTO field (farmId,posX,posY)
VALUES (1,1,2);

INSERT INTO field (farmId,posX,posY)
VALUES (1,2,1);

INSERT INTO field (farmId,posX,posY)
VALUES (1,2,2);

INSERT INTO inventory (farmId,itemId,quantity)
VALUES (1,1,10);

INSERT INTO inventory (farmId,itemId,quantity)
VALUES (1,2,10);

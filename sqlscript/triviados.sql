CREATE DATABASE triviados;
USE triviados;
CREATE TABLE usuarios (
  id_incremental int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL
) ;



INSERT INTO usuarios (email, password) VALUES
( 'admin@admin.com', 'admin123');



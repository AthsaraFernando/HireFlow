CREATE DATABASE my_db;
USE my_db;

CREATE TABLE IF NOT EXISTS user (
    id int(11) NOT NULL AUTO_INCREMENT,
    email varchar(30) NOT NULL,
    password varchar(255) NOT NULL,
    date_added timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (id)
);

-- SELECT * FROM user;

-- SHOW TABLES;
-- DROP TABLE user;
-- DROP DATABASE my_db;






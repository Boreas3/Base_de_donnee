DROP TABLE IF EXISTS php_users_login;

CREATE TABLE IF NOT EXISTS php_users_login (
  id int NOT NULL,
  username varchar(255) DEFAULT NULL,
  password varchar(255) DEFAULT NULL,
  last_login datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

INSERT INTO php_users_login (id,username,password) VALUES
(1,'group12','KS/7yNYP8l');
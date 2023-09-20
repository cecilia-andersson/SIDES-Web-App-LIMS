CREATE TABLE user(
    personnummer VARCHAR(12) PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(30) NOT NULL,
);

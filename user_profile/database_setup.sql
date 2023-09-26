CREATE TABLE users (
    userid INT PRIMARY KEY AUTO_INCREMENT,
    birthdate VARCHAR(8),
    uniquefour VARCHAR(60) NOT NULL, -- UNIQUE??
    username VARCHAR(30) NOT NULL UNIQUE,
    pwd VARCHAR(60) NOT NULL,
    email VARCHAR(100) NOT NULL -- How big? Need to be encrypted?
);

CREATE TABLE review (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    userid INT,
    drug_id INT,
    rating INT NOT NULL,
    text_review VARCHAR(100),
    review_date Timestamp,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (drug_id) REFERENCES drugs(drug_id)
);

CREATE TABLE report (
    report_id INT PRIMARY KEY AUTO_INCREMENT,
    userid INT,
    side_effect INT,
    intensity BOOLEAN NOT NULL,
    review_date Timestamp,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (side_effect) REFERENCES side_effects(se_id)
);

CREATE TABLE password_reset_temp (
  email varchar(250) NOT NULL,
  pkey varchar(250) NOT NULL,
  expDate datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
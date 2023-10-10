-- Creating database

CREATE DATABASE sides;

-- Creating the tables

CREATE TABLE drugs (
    drug_id INT PRIMARY KEY AUTO_INCREMENT,
    drug_brand VARCHAR(50) NOT NULL,
    drug_class VARCHAR(30) NOT NULL,
    drug_format VARCHAR(30) NOT NULL,
    drug_active_ingredient VARCHAR(70) NOT NULL,
    drug_inactive_ingredient VARCHAR(255) NOT NULL, 
    CONSTRAINT drug_name UNIQUE (drug_brand, drug_active_ingredient, drug_inactive_ingredient)

);

CREATE TABLE users (
    userid INT PRIMARY KEY AUTO_INCREMENT,
    birthdate VARCHAR(8),
    uniquefour VARCHAR(60) NOT NULL,
    username VARCHAR(30) NOT NULL UNIQUE,
    chosensides VARCHAR(60),
    pwd VARCHAR(60) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE -- How big? Need to be encrypted?
);

CREATE TABLE password_reset_temp (
  email varchar(250) NOT NULL UNIQUE,
  token varchar(32) NOT NULL,
  expiry datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE block_ip (
    ip varchar(15),
    expiry datetime NOT NULL
);

CREATE TABLE side_effects (
    se_id INT PRIMARY KEY AUTO_INCREMENT, 
    se_name VARCHAR(50) NOT NULL
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

CREATE TABLE user_drug (
    user_drug_id INT PRIMARY KEY AUTO_INCREMENT,
    userid INT NOT NULL,
    drug_id INT,
    reg_date Timestamp,
    startdate DATE NOT NULL,
    enddate DATE,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (drug_id) REFERENCES drugs(drug_id)
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




CREATE TABLE forum_posts (
    post_id INT PRIMARY KEY AUTO_INCREMENT,
    userid INT,
    user_drug_id INT, -- Reference to the user_drug table
    post_text VARCHAR(255) NOT NULL,
    post_date TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (user_drug_id) REFERENCES user_drug(user_drug_id)
);

-- R as in Report
CREATE TABLE drug_association_report (
    R_association_id INT PRIMARY KEY AUTO_INCREMENT,
    R_drug_fk_id INT,
    R_se_fk_id INT,
    R_user_fk_id INT,
    intensity INT CHECK (intensity >= 1 AND intensity <= 5), -- This did not work last time, but idk how to otherwise
    report_date Timestamp, -- fk from when user makes a report. How do we trigger this? 
    FOREIGN KEY (R_user_fk_id) REFERENCES users(userid),
    FOREIGN KEY (R_drug_fk_id) REFERENCES drugs(drug_id),
    FOREIGN KEY (R_se_fk_id) REFERENCES side_effects(se_id)  
);


-- F as in FASS
CREATE TABLE drug_association_fass (
    F_association_id INT PRIMARY KEY AUTO_INCREMENT,
    F_drug_fk_id INT,
    F_se_fk_id INT,
    -- in_fass BOOLEAN, -- but only save if yes? do we need this then
    FOREIGN KEY (F_drug_fk_id) REFERENCES drugs(drug_id),
    FOREIGN KEY (F_se_fk_id) REFERENCES side_effects(se_id)  
);



-- Populating the tables
-- First create the db and tables. Then manually add at least two users. Then pupulate the rest (since we dont know what hashfunction is being used).
-- These are the sample users I am creating: 
-- User1, 199901011234, pwd: Abc123, user1@uu.se
-- User2, 199912314321, pwd: 123Abc, user2@uu.se
-- only 1999 seems to work 


INSERT INTO side_effects (se_name)
VALUES
    ('Headache'), ('Nausea'),('Dizziness'),('Fatigue'),('Insomnia'),('Dry mouth'),('Constipation'),('Diarrhea'),('Vomiting'),
    ('Blurred vision'),('Rash'),('Swelling'),('Heart palpitations'),('Anxiety'),('Depression'),('Irritability'),('Weight gain'),
    ('Weight loss'),('Loss of appetite'),('Muscle pain'),('Joint pain'),('Back pain'),('Fever'),('Chills'),('Cough'),
    ('Shortness of breath'),('Chest pain'),('Abdominal pain'),('Indigestion'),('Gas'),('Bloating'),('Frequent urination'),
    ('Difficulty urinating'),('Blood in urine'),('Increased thirst'),('Frequent infections'),('Hair loss'),('Nosebleeds'),
    ('Tinnitus'),('Tremors'),('Difficulty sleeping'),('Night sweats'),('Swollen lymph nodes'),('Sore throat'),('Cold sores'),
    ('Canker sores'),('Numbness'),('Tingling sensation'),('Memory problems'),('Confusion'),('Hallucinations'),('Mood swings'),
    ('Loss of libido'),('Impotence'),('Hot flashes'),('Menstrual irregularities'),('Swollen ankles'),('Paleness'),('Bruising'),
    ('Chest tightness'),('Nasal congestion'),('Runny nose'),('Sneezing'),('Itchy eyes'),('Watery eyes'),('Dry skin'),('Itchy skin'),
    ('Excessive sweating'),('Muscle spasms'),('Difficulty concentrating'),('Dry throat'),('Heartburn'),('Jaw pain'),('Toothache'),
    ('Chest congestion'),('Short-term memory loss'),('Increased appetite'),('Loss of coordination'),('Blurry vision'),
    ('Sensitivity to light'),('Swollen face'),('Swollen tongue'),('Metallic taste in mouth'),('Unexplained bleeding'),
    ('Dark urine'),('Yellowing of skin'),('Fainting'),('Loss of balance'),('Nail discoloration'),('Swollen fingers'),
    ('Swollen toes'),('Frequent hiccups'),('Stomach cramps'),('Dry eyes'),('Loss of smell'),('Loss of taste'),('Shortness of temper'),
    ('Difficulty swallowing'),('Nervousness'),('Loss of energy'),('Loss of strength'),('Hair thinning'),('Joint swelling'),
    ('Muscle weakness'),('Sensitivity to cold'),('Sensitivity to heat'),('Stomach ulcers'),('Kidney pain'),('Throat tightness'),
    ('Weight fluctuations'),('Bleeding gums'),('Nasal bleeding'),('Frequent burping'),('Facial flushing'),('Difficulty speaking');


INSERT INTO drugs (drug_brand, drug_class, drug_format, drug_active_ingredient, drug_inactive_ingredient)
VALUES
    ('Ortho Tri-Cyclen', 'Combination', 'Tablet', 'Norgestimate, Ethinyl Estradiol', 'Lactose, Magnesium Stearate, Microcrystalline Cellulose, Other Inactive Ingredients'),
    ('Yasmin', 'Combination', 'Tablet', 'Drospirenone, Ethinyl Estradiol', 'Lactose, Magnesium Stearate, Corn Starch, Other Inactive Ingredients'),
    ('Lo Loestrin Fe', 'Combination', 'Soft Gel', 'Norethindrone, Ethinyl Estradiol', 'Glycerin, Gelatin, Iron Oxide, Titanium Dioxide, Other Inactive Ingredients'),
    ('Alesse', 'Combination', 'Capsule', 'Levonorgestrel, Ethinyl Estradiol', 'Starch, Povidone, Talc, Other Inactive Ingredients'),
    ('Seasonique', 'Combination', 'Chewable Tablet', 'Levonorgestrel, Ethinyl Estradiol', 'Mannitol, Xylitol, Aspartame, Natural and Artificial Flavors, Other Inactive Ingredients'),
    ('Micronor', 'Progestin-Only', 'Extended-Release Capsule', 'Norethindrone', 'Ethylcellulose, Povidone, Polysorbate 80, Other Inactive Ingredients'),
    ('Norethindrone', 'Progestin-Only', 'Dissolvable Film', 'Norethindrone', 'Polyvinyl Alcohol, Hydroxypropyl Methylcellulose, Lecithin, Other Inactive Ingredients'),
    ('Seasonale', 'Extended-Cycle', 'Pill', 'Levonorgestrel, Ethinyl Estradiol', 'Sodium Starch Glycolate, Polyethylene Glycol, Hydroxypropyl Cellulose, Other Inactive Ingredients'),
    ('Lybrel', 'Extended-Cycle', 'Injectable Suspension', 'Levonorgestrel, Ethinyl Estradiol', 'Polyethylene Glycol, Benzyl Alcohol, Sodium Chloride, Other Inactive Ingredients'),
    ('Plan B One-Step', 'Emergency Contraceptive', 'Tablet', 'Levonorgestrel', 'Croscarmellose Sodium, Colloidal Silicon Dioxide, Magnesium Stearate, Other Inactive Ingredients'),
    ('Ella', 'Emergency Contraceptive', 'Tablet', 'Ulipristal Acetate', 'Croscarmellose Sodium, Lactose Monohydrate, Magnesium Stearate, Other Inactive Ingredients');


INSERT INTO drug_association_fass (F_drug_fk_id, F_se_fk_id)
VALUES
    (1, 1),  -- Drug 1, Side Effect 1 is in FASS
    (2, 1),
    (2, 2);

INSERT INTO drug_association_report (R_drug_fk_id, R_se_fk_id, R_user_fk_id ,intensity, report_date)
VALUES
    (1, 1, 1, 5, '2023-09-19 10:00:00'),  -- Drug 1, Side Effect 1, User 1, Intensity 5, reported on 2023-09-19
    (1, 2, 1, 3, '2023-09-19 11:30:00'),
    (2, 1, 2, 1, '2023-09-20 09:45:00');

INSERT INTO review (userid, drug_id, rating, text_review, review_date)
VALUES
    (1, 1, 4, 'Works well for me!', '2023-09-18 15:30:00'),
    (2, 3, 3, 'Experienced some side effects.', '2023-09-19 14:45:00');

INSERT INTO user_drug (userid, drug_id, reg_date, startdate, enddate)
VALUES
    (1, 1, '2023-09-18 10:00:00', '2023-09-18', '2023-09-25'),
    (1, 2, '2023-09-18 10:00:00', '2023-09-18', NULL),
    (2, 3, '2023-09-18 10:30:00', '2023-09-18', NULL);

INSERT INTO forum_posts (userid, user_drug_id, post_text, post_date)
VALUES
    (1, 1, 'Has anyone experienced dizziness?', '2023-09-19 10:15:00'),
    (1, 2, 'No side effects for me. I am happy with the medication.', '2023-09-21 14:30:00'),
    (2, 3, 'This drug is not working for me. Anyone else having issues?', '2023-09-22 13:45:00');
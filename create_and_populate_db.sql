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

-- new attribute for descriptions 
ALTER TABLE drugs
ADD COLUMN drug_description VARCHAR(500);


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
    post_likes INT,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (user_drug_id) REFERENCES user_drug(user_drug_id)
);

CREATE TABLE comments (
	commentid INT PRIMARY KEY AUTO_INCREMENT,
	user_id INT,
	post_id INT,
	comment_text VARCHAR(255) NOT NULL,
	comment_likes INT,
	comment_date TIMESTAMP,
	FOREIGN KEY (user_id) REFERENCES users(userid),
	FOREIGN KEY (post_id) REFERENCES forum_posts(post_id)
);

CREATE TABLE post_likes(
    like_id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT,
    user_id INT,
    UNIQUE(post_id, user_id),
    FOREIGN KEY (user_id) REFERENCES users(userid),
    FOREIGN KEY (post_id) REFERENCES forum_posts(post_id)
);

CREATE TABLE likes_comments(
    like_id INT PRIMARY KEY AUTO_INCREMENT,
    comment_id INT,
    user_id INT,
    UNIQUE(comment_id, user_id),
    FOREIGN KEY (user_id) REFERENCES users(userid),
    FOREIGN KEY (comment_id) REFERENCES comments(commentid)
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


--   ¤¤¤¤ Populate userid = 1 & 2 ¤¤¤¤ 
-- Populating the tables
-- First create the db and tables. Then manually add at least two users. Then pupulate the rest (since we dont know what hashfunction is being used).
-- These are the sample users I am creating: 
-- User1, 199901011234, pwd: Abc123, user1@uu.se
-- User2, 199912314321, pwd: 123Abc, user2@uu.se
-- only 1999 seems to work 


--   ¤¤¤¤ Populate userid = 10 to 40 ¤¤¤¤ 
-- Also first run this block of code to populate the database with 30 users (from userid 10 to 40)
INSERT INTO users (userid, birthdate, uniquefour, username, pwd, email)
VALUES
    (10, '20070320', SUBSTRING('$2y$10$ABCDEFGHI1234567890ABCDEFGHI1234567890ABCDEFGHI12345', 1, 60), 'female1', SUBSTRING('$2y$10$ABCDEFGHI1234567890ABCDEFGHI1234567890', 1, 60), 'female1@email.com'),
    (11, '20040815', SUBSTRING('$2y$10$JKLMNOPQRST1234567890JKLMNOPQRST1234567890JKLMNOPQRST', 1, 60), 'female2', SUBSTRING('$2y$10$JKLMNOPQRST1234567890JKLMNOPQRST1234567890', 1, 60), 'female2@email.com'),
    (12, '20031128', SUBSTRING('$2y$10$UVWXYZ01234567890UVWXYZ01234567890UVWXYZ01234567890', 1, 60), 'female3', SUBSTRING('$2y$10$UVWXYZ01234567890UVWXYZ01234567890', 1, 60), 'female3@email.com'),
    (13, '20000403', SUBSTRING('$2y$10$12345abcdeABCDEfghij12345abcdeABCDEfghij12345', 1, 60), 'female4', SUBSTRING('$2y$10$12345abcdeABCDEfghij12345abcdeABCDEfghij12345abcde', 1, 60), 'female4@email.com'),
    (14, '19980514', SUBSTRING('$2y$10$fghijABCDE67890klmno12345fghijABCDE67890klmno12345', 1, 60), 'female5', SUBSTRING('$2y$10$fghijABCDE67890klmno12345fghijABCDE67890klmno12345', 1, 60), 'female5@email.com'),
    (15, '19970702', SUBSTRING('$2y$10$klmnopqrstuABCDEFGHIJKLMNOPQRSTUVWklmnopqrstuABCDEFGHIJKLMNOPQRSTUVWklmnopqrstu', 1, 60), 'female6', SUBSTRING('$2y$10$klmnopqrstuABCDEFGHIJKLMNOPQRSTUVWklmnopqrstuABCDEFGHIJKLMNOPQRSTUVWklmnopqrstu', 1, 60), 'female6@email.com'),
    (16, '19960830', SUBSTRING('$2y$10$XYZ1234567890abcdefghijklmnopqrstuvwxyzXYZ1234567890abcdefghijklmnopqrstuvwxyz', 1, 60), 'female7', SUBSTRING('$2y$10$XYZ1234567890abcdefghijklmnopqrstuvwxyzXYZ1234567890abcdefghijklmnopqrstuvwxyz', 1, 60), 'female7@email.com'),
    (17, '19950315', SUBSTRING('$2y$10$1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ', 1, 60), 'female8', SUBSTRING('$2y$10$1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ', 1, 60), 'female8@email.com'),
    (18, '19941224', SUBSTRING('$2y$10$mnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 1, 60), 'female9', SUBSTRING('$2y$10$mnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 1, 60), 'female9@email.com'),
    (19, '19931011', SUBSTRING('$2y$10$testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', 1, 60), 'female10', SUBSTRING('$2y$10$testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest', 1, 60), 'female10@email.com'),
    (20, '19921010', SUBSTRING('$2y$10$testing123testing123testing123testing123testing123testing123testing123', 1, 60), 'female11', SUBSTRING('$2y$10$testing123testing123testing123testing123testing123testing123testing123', 1, 60), 'female11@email.com'),
    (21, '19910922', SUBSTRING('$2y$10$password123password123password123password123password123password123password123', 1, 60), 'female12', SUBSTRING('$2y$10$password123password123password123password123password123password123password123', 1, 60), 'female12@email.com'),
    (22, '19900105', SUBSTRING('$2y$10$security123security123security123security123security123security123security123', 1, 60), 'female13', SUBSTRING('$2y$10$security123security123security123security123security123security123security123', 1, 60), 'female13@email.com'),
    (23, '19890508', SUBSTRING('$2y$10$database123database123database123database123database123database123database123', 1, 60), 'female14', SUBSTRING('$2y$10$database123database123database123database123database123database123database123', 1, 60), 'female14@email.com'),
    (24, '19880301', SUBSTRING('$2y$10$engineer123engineer123engineer123engineer123engineer123engineer123engineer123', 1, 60), 'female15', SUBSTRING('$2y$10$engineer123engineer123engineer123engineer123engineer123engineer123engineer123', 1, 60), 'female15@email.com'),
    (25, '19870314', SUBSTRING('$2y$10$developer123developer123developer123developer123developer123developer123developer123', 1, 60), 'female16', SUBSTRING('$2y$10$developer123developer123developer123developer123developer123developer123developer123', 1, 60), 'female16@email.com'),
    (26, '19860227', SUBSTRING('$2y$10$designer123designer123designer123designer123designer123designer123designer123', 1, 60), 'female17', SUBSTRING('$2y$10$designer123designer123designer123designer123designer123designer123designer123', 1, 60), 'female17@email.com'),
    (27, '19850210', SUBSTRING('$2y$10$artist123artist123artist123artist123artist123artist123artist123', 1, 60), 'female18', SUBSTRING('$2y$10$artist123artist123artist123artist123artist123artist123artist123', 1, 60), 'female18@email.com'),
    (28, '19840123', SUBSTRING('$2y$10$musician123musician123musician123musician123musician123musician123', 1, 60), 'female19', SUBSTRING('$2y$10$musician123musician123musician123musician123musician123musician123', 1, 60), 'female19@email.com'),
    (29, '19830207', SUBSTRING('$2y$10$athlete123athlete123athlete123athlete123athlete123athlete123', 1, 60), 'female20', SUBSTRING('$2y$10$athlete123athlete123athlete123athlete123athlete123athlete123', 1, 60), 'female20@email.com'),
    (30, '19820120', SUBSTRING('$2y$10$gamer123gamer123gamer123gamer123gamer123gamer123', 1, 60), 'female21', SUBSTRING('$2y$10$gamer123gamer123gamer123gamer123gamer123gamer123', 1, 60), 'female21@email.com'),
    (31, '19910613', SUBSTRING('$2y$10$writer123writer123writer123', 1, 60), 'female22', '$2y$10$writer123writer123writer123', 'female22@email.com'),
    (32, '19900726', SUBSTRING('$2y$10$photographer123photographer123photographer', 1, 60), 'female23', '$2y$10$photographer123photographer123photographer', 'female23@email.com'),
    (33, '19890509', SUBSTRING('$2y$10$filmmaker123filmmaker123filmmaker', 1, 60), 'female24', '$2y$10$filmmaker123filmmaker123filmmaker', 'female24@email.com'),
    (34, '19880221', SUBSTRING('$2y$10$scientist123scientist123scientist', 1, 60), 'female25', '$2y$10$scientist123scientist123scientist', 'female25@email.com'),
    (35, '19870204', SUBSTRING('$2y$10$teacher123teacher123teacher', 1, 60), 'female26', '$2y$10$teacher123teacher123teacher', 'female26@email.com'),
    (36, '19860117', SUBSTRING('$2y$10$lawyer123lawyer123lawyer', 1, 60), 'female27', '$2y$10$lawyer123lawyer123lawyer', 'female27@email.com'),
    (37, '19850130', SUBSTRING('$2y$10$engineer123engineer123engineer', 1, 60), 'female28', '$2y$10$engineer123engineer123engineer', 'female28@email.com'),
    (38, '19840112', SUBSTRING('$2y$10$developer123developer123developer', 1, 60), 'female29', '$2y$10$developer123developer123developer', 'female29@email.com'),
    (39, '19830025', SUBSTRING('$2y$10$designer123designer123designer', 1, 60), 'female30', '$2y$10$designer123designer123designer', 'female30@email.com'),
    (40, '19820208', SUBSTRING('$2y$10$artist123artist123artist', 1, 60), 'female31', '$2y$10$artist123artist123artist', 'female31@email.com');



-- ¤¤¤¤¤¤¤¤¤¤¤¤¤¤ 
-- Populating the rest of the database 
-- ¤¤¤¤¤¤¤¤¤¤¤¤¤¤




INSERT INTO side_effects (se_name)
VALUES
    ('No side effects today'), ("Experiencing side effects, but too tired to document/don't want to"), ('Headache'), ('Nausea'),('Dizziness'),('Fatigue'),('Insomnia'),('Dry mouth'),('Constipation'),('Diarrhea'),('Vomiting'),
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

-- NEW data for drug descriptions 
UPDATE drugs 
SET drug_description = 
CASE 
    WHEN drug_brand = 'Ortho Tri-Cyclen' THEN 'Ortho Tri-Cyclen is a combination oral contraceptive containing norgestimate and ethinyl estradiol. It works by preventing ovulation and changing the cervical mucus and uterine lining, making it harder for sperm to reach the uterus and for a fertilized egg to attach to the uterus.'
    WHEN drug_brand = 'Yasmin' THEN 'Yasmin is a combination birth control pill containing drospirenone and ethinyl estradiol. It works by preventing ovulation, making it harder for sperm to reach the uterus and for a fertilized egg to attach to the uterus. Yasmin is also used to treat premenstrual dysphoric disorder (PMDD) and moderate acne in women seeking oral contraception.'
    WHEN drug_brand = 'Lo Loestrin Fe' THEN 'Lo Loestrin Fe is a combination birth control pill containing norethindrone and ethinyl estradiol. It works by preventing ovulation, making it harder for sperm to reach the uterus and for a fertilized egg to attach to the uterus. Lo Loestrin Fe also contains iron supplements to help prevent iron deficiency anemia during menstruation.'
    WHEN drug_brand = 'Alesse' THEN 'Alesse is a combination birth control pill containing levonorgestrel and ethinyl estradiol. It works by preventing ovulation, making it harder for sperm to reach the uterus and for a fertilized egg to attach to the uterus.'
    WHEN drug_brand = 'Seasonique' THEN 'Seasonique is a combination birth control pill designed for extended-cycle use. It contains levonorgestrel and ethinyl estradiol, allowing women to have fewer periods throughout the year. It works by preventing ovulation and altering the uterine lining, making it harder for sperm to reach the uterus and for a fertilized egg to attach to the uterus.'
    WHEN drug_brand = 'Micronor' THEN 'Micronor, also known as the mini-pill, is a progestin-only birth control pill containing norethindrone. It works primarily by thickening cervical mucus, making it harder for sperm to reach the uterus. Micronor also alters the uterine lining, making it less receptive to implantation in case fertilization occurs.'
    WHEN drug_brand = 'Norethindrone' THEN 'Norethindrone is a progestin-only contraceptive pill that works by thickening cervical mucus, making it difficult for sperm to reach the uterus. It also alters the uterine lining, making it less receptive to implantation. Norethindrone is a reliable option for women who cannot take estrogen-containing contraceptives.'
    WHEN drug_brand = 'Seasonale' THEN 'Seasonale is an extended-cycle birth control pill containing levonorgestrel and ethinyl estradiol. It is designed to reduce the number of menstrual periods to four per year. Seasonale works by preventing ovulation and altering the uterine lining, making it harder for sperm to reach the uterus and for a fertilized egg to attach to the uterus.'
    WHEN drug_brand = 'Lybrel' THEN 'Lybrel is a continuous-cycle birth control pill containing levonorgestrel and ethinyl estradiol. Unlike traditional birth control pills, Lybrel is taken without any breaks, eliminating monthly periods. It works by preventing ovulation and altering the cervical mucus, making it harder for sperm to reach the uterus and for a fertilized egg to attach to the uterus.'
    WHEN drug_brand = 'Plan B One-Step' THEN 'Plan B One-Step, also known as the morning-after pill, is an emergency contraceptive tablet containing levonorgestrel. It is used to prevent pregnancy after unprotected sex or contraceptive failure (e.g., condom breakage). Plan B One-Step works primarily by preventing ovulation and altering the cervical mucus, making it harder for sperm to reach the uterus.'
    WHEN drug_brand = 'Ella' THEN 'Ella is an emergency contraceptive tablet containing ulipristal acetate. It is used to prevent pregnancy after unprotected sex or contraceptive failure (e.g., condom breakage). Ella works primarily by delaying or inhibiting ovulation, making it harder for sperm to reach the uterus and for a fertilized egg to attach to the uterus.'
END;

INSERT INTO drug_association_fass (F_drug_fk_id, F_se_fk_id)
VALUES
    -- Drug 1: Ortho Tri-Cyclen
    (1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8), (1, 9), (1, 10),
    -- Drug 2: Yasmin
    (2, 1), (2, 2), (2, 3), (2, 4), (2, 5), (2, 6), (2, 7), (2, 8), (2, 9), (2, 10),
    -- Drug 3: Lo Loestrin Fe
    (3, 1), (3, 2), (3, 3), (3, 4), (3, 5), (3, 6), (3, 7), (3, 8), (3, 9), (3, 10),
    -- Drug 4: Alesse
    (4, 1), (4, 2), (4, 3), (4, 4), (4, 5), (4, 6), (4, 7), (4, 8), (4, 9), (4, 10),
    -- Drug 5: Seasonique
    (5, 1), (5, 2), (5, 3), (5, 4), (5, 5), (5, 6), (5, 7), (5, 8), (5, 9), (5, 10),
    -- Drug 6: Micronor
    (6, 1), (6, 2), (6, 3), (6, 4), (6, 5), (6, 6), (6, 7), (6, 8), (6, 9), (6, 10),
    -- Drug 7: Norethindrone
    (7, 1), (7, 2), (7, 3), (7, 4), (7, 5), (7, 6), (7, 7), (7, 8), (7, 9), (7, 10),
    -- Drug 8: Seasonale
    (8, 1), (8, 2), (8, 3), (8, 4), (8, 5), (8, 6), (8, 7), (8, 8), (8, 9), (8, 10),
    -- Drug 9: Lybrel
    (9, 1), (9, 2), (9, 3), (9, 4), (9, 5), (9, 6), (9, 7), (9, 8), (9, 9), (9, 10),
    -- Drug 10: Plan B One-Step
    (10, 1), (10, 2), (10, 3), (10, 4), (10, 5), (10, 6), (10, 7), (10, 8), (10, 9), (10, 10),
    -- Drug 11: Ella
    (11, 1), (11, 2), (11, 3), (11, 4), (11, 5), (11, 6), (11, 7), (11, 8), (11, 9), (11, 10);

-- 
INSERT INTO drug_association_report (R_drug_fk_id, R_se_fk_id, R_user_fk_id ,intensity, report_date)
VALUES
    (1, 1, 1, 5, '2023-09-19 10:00:00'),  -- Drug 1, Side Effect 1, User 1, Intensity 5, reported on 2023-09-19
    (1, 2, 1, 3, '2023-09-19 11:30:00'),
    (2, 1, 2, 1, '2023-09-20 09:45:00');

INSERT INTO review (userid, drug_id, rating, text_review, review_date)
VALUES
    (1, 1, 4, 'Works well for me!', '2023-09-18 15:30:00'),
    (1, 2, 1, 'Experienced massive side effects.', '2023-09-19 14:45:00'),
    (1, 3, 1, 'Experienced massive side effects.', '2023-09-19 14:45:00'),
    (2, 3, 3, 'Experienced some side effects.', '2023-09-19 14:45:00');

INSERT INTO user_drug (userid, drug_id, reg_date, startdate, enddate)
VALUES
    (1, 1, '2023-09-18 10:00:00', '2023-09-18', '2023-09-25'),
    (1, 2, '2023-09-18 10:00:00', '2023-09-18', NULL),
    (2, 3, '2023-09-18 10:30:00', '2023-09-18', NULL);

-- Create 74 new reviews by users 10 to 40

INSERT INTO review (userid, drug_id, rating, text_review, review_date)
VALUES
(10, 1, 4, 'This drug worked well for me. Mild side effects.', '2023-10-09 14:16:32'),
(10, 4, 1, 'Not satisfied with the results. Experienced severe side effects.', '2023-10-09 14:16:32'),
(10, 3, 5, 'This is the best drug I have ever taken.', '2023-10-09 14:16:32'),
-- User 11
(11, 2, 5, 'Amazing results! No side effects at all.', '2023-10-09 14:16:32'),
-- User 12
(12, 1, 2, 'Experienced side effects. Not satisfied with the results.', '2023-10-09 14:16:32'),
(12, 6, 3, 'Effective treatment with minor side effects.', '2023-10-09 14:16:32'),
-- User 13
(13, 2, 4, 'Effective treatment with minimal side effects.', '2023-10-09 14:16:32'),
(13, 8, 1, 'Seasonale caused severe side effects. Do not recommend.', '2023-10-09 14:16:32'),
(13, 5, 5, 'Great results with no side effects.', '2023-10-09 14:16:32'),
-- User 14
(14, 3, 2, 'Not recommended. Terrible side effects.', '2023-10-09 14:16:32'),
(14, 7, 4, 'It helped relieve my symptoms.', '2023-10-09 14:16:32'),
(14, 10, 3, 'Average results.', '2023-10-09 14:16:32'),
-- User 15
(15, 1, 5, 'This drug worked well for me.', '2023-10-09 14:16:32'),
-- User 16
(16, 4, 3, 'Satisfied with the results. Mild side effects.', '2023-10-09 14:16:32'),
(16, 5, 4, 'Effective treatment with minimal side effects.', '2023-10-09 14:16:32'),
(16, 6, 2, 'Experienced side effects. Could be better.', '2023-10-09 14:16:32'),
-- User 17
(17, 6, 4, 'OMG, this is the best drug I have ever had!!', '2023-10-09 14:16:32'),
(17, 1, 3, 'Effective treatment with minor side effects.', '2023-10-09 14:16:32'),
(17, 7, 1, 'Not recommended. Terrible side effects.', '2023-10-09 14:16:32'),
-- User 18
(18, 8, 2, 'Seasonale caused severe side effects. Do not recommend.', '2023-10-09 14:16:32'),
(18, 3, 5, 'Great results with no side effects.', '2023-10-09 14:16:32'),
-- User 19
(19, 10, 3, 'Average results.', '2023-10-09 14:16:32'),
(19, 1, 5, 'This drug worked well for me.', '2023-10-09 14:16:32'),
(19, 2, 4, 'Effective treatment with minimal side effects.', '2023-10-09 14:16:32'),
-- User 20
(20, 3, 1, 'Did not work as I hoped. Terrible side effects.', '2023-10-09 14:16:32'),
(20, 4, 3, 'Effective treatment with minor side effects.', '2023-10-09 14:16:32'),
(20, 5, 4, 'It helped relieve my symptoms.', '2023-10-09 14:16:32'),
(20, 2, 2, 'Experienced side effects. Could be better.', '2023-10-09 14:16:32'),
-- User 21
(21, 1, 4, 'This drug worked well for me.', '2023-10-09 14:16:32'),
(21, 2, 2, 'Experienced side effects. Could be better.', '2023-10-09 14:16:32'),
(21, 3, 3, 'Effective treatment with minor side effects.', '2023-10-09 14:16:32'),
(21, 4, 5, 'Loved this drug! No side effects.', '2023-10-09 14:16:32'),
-- User 22
(22, 3, 1, 'Not recommended. Terrible side effects.', '2023-10-09 14:16:32'),
(22, 5, 3, 'It helped relieve my symptoms.', '2023-10-09 14:16:32'),
(22, 6, 4, 'Effective treatment with minimal side effects.', '2023-10-09 14:16:32'),
-- User 23
(23, 6, 4, 'Great results with no side effects.', '2023-10-09 14:16:32'),
(23, 7, 2, 'Seasonale caused severe side effects. Do not recommend.', '2023-10-09 14:16:32'),
-- User 24
(24, 8, 3, 'Satisfied with the results. Mild side effects.', '2023-10-09 14:16:32'),
(24, 10, 4, 'Effective treatment with no side effects.', '2023-10-09 14:16:32'),
(24, 11, 1, 'Did not work as I hoped. Terrible side effects.', '2023-10-09 14:16:32'),
-- User 25
(25, 10, 2, 'Experienced side effects. Could be better.', '2023-10-09 14:16:32'),
(25, 9, 1, 'Not satisfied with the results. Terrible side effects.', '2023-10-09 14:16:32'),
-- User 26
(26, 1, 4, 'Very effective drug. Minimal side effects.', '2023-10-09 14:16:32'),
(26, 2, 3, 'Good results with minor side effects.', '2023-10-09 14:16:32'),
(26, 3, 2, 'Experienced side effects. Could be better.', '2023-10-09 14:16:32'),
-- User 27
(27, 4, 2, 'Not satisfied with the results.', '2023-10-09 14:16:32'),
(27, 5, 5, 'This drug is a miracle! No side effects at all.', '2023-10-09 14:16:32'),
-- User 28
(28, 7, 3, 'Effective treatment with minor side effects.', '2023-10-09 14:16:32'),
(28, 8, 5, 'Seasonale is amazing! No side effects, great results.', '2023-10-09 14:16:32'),
-- User 29
(29, 10, 4, 'Great results with minimal side effects.', '2023-10-09 14:16:32'),
(29, 11, 1, 'Not recommended.', '2023-10-09 14:16:32'),
-- User 30
(30, 7, 4, 'Satisfactory results with minor side effects.', '2023-10-09 14:16:32'),
(30, 9, 3, 'Average results.', '2023-10-09 14:16:32'),
-- User 31
(31, 1, 4, 'Very effective drug. Minimal side effects.', '2023-10-09 14:16:32'),
(31, 2, 3, 'Good results with minor side effects.', '2023-10-09 14:16:32'),
(31, 3, 2, 'Experienced side effects. Could be better.', '2023-10-09 14:16:32'),
-- User 32
(32, 4, 2, 'Not satisfied with the results.', '2023-10-09 14:16:32'),
(32, 5, 5, 'This drug is a miracle! No side effects at all.', '2023-10-09 14:16:32'),
-- User 33
(33, 7, 3, 'Effective treatment with minor side effects.', '2023-10-09 14:16:32'),
(33, 8, 5, 'Seasonale is amazing! No side effects, great results.', '2023-10-09 14:16:32'),
-- User 34
(34, 10, 4, 'Great results with minimal side effects.', '2023-10-09 14:16:32'),
(34, 11, 1, 'Not recommended.', '2023-10-09 14:16:32'),
-- User 35
(35, 7, 4, 'Satisfactory results with minor side effects.', '2023-10-09 14:16:32'),
(35, 9, 3, 'Average results.', '2023-10-09 14:16:32'),
-- User 36
(36, 1, 3, 'Average results with minor side effects.', '2023-10-09 14:16:32'),
(36, 2, 5, 'Yasmin is fantastic! No side effects and great results.', '2023-10-09 14:16:32'),
-- User 37
(37, 3, 2, 'Disappointed with the results.', '2023-10-09 14:16:32'),
(37, 4, 5, 'Alesse is a life-saver! No side effects and excellent results.', '2023-10-09 14:16:32'),
-- User 38
(38, 5, 4, 'Satisfied with the results and no significant side effects.', '2023-10-09 14:16:32'),
(38, 6, 1, 'Micronor did not work well for me.', '2023-10-09 14:16:32'),
-- User 39
(39, 7, 3, 'Effective treatment with minimal side effects.', '2023-10-09 14:16:32'),
(39, 8, 5, 'Seasonale is amazing! No side effects, great results.', '2023-10-09 14:16:32'),
-- User 40
(40, 10, 4, 'Great results with minimal side effects.', '2023-10-09 14:16:32'),
(40, 11, 3, 'Could be better.', '2023-10-09 14:16:32');



-- Additional 50 entries for forum_posts table
INSERT INTO forum_posts (userid, user_drug_id, post_text, post_date)
VALUES
    (1, 1, 'Experiencing mild dizziness occasionally. Anyone else?', '2023-09-19 10:45:00'),
    (2, 3, 'Is it normal to have stomach cramps with this medication?', '2023-09-20 11:30:00'),
    (1, 2, 'Feeling a bit lightheaded. Should I be concerned?', '2023-09-21 14:20:00'),
    (2, 3, 'Having trouble sleeping since I started this drug. Any advice?', '2023-09-22 15:15:00'),
    (1, 1, 'No side effects for me. This medication is a lifesaver!', '2023-09-23 16:00:00'),
    (2, 2, 'Excessive sweating has become an issue. Anyone else?', '2023-09-24 17:45:00'),
    (1, 2, 'Feeling more anxious than usual. Is this a common side effect?', '2023-09-25 18:30:00'),
    (2, 3, 'Nausea is unbearable. Thinking about stopping the medication.', '2023-09-26 19:15:00'),
    (1, 1, 'Having vivid dreams. Is this related to the medication?', '2023-09-27 20:00:00'),
    (2, 2, 'Has anyone experienced weight gain with this drug?', '2023-09-28 20:45:00'),
    (1, 2, 'Feeling extremely tired. Not sure if it\'s the medication or something else.', '2023-09-29 21:30:00'),
    (2, 3, 'Feeling nauseous all the time. Considering talking to my doctor about it.', '2023-09-30 22:15:00'),
    (1, 1, 'Experiencing joint pain. Is this a common side effect?', '2023-10-01 23:00:00'),
    (2, 2, 'Feeling more irritable since I started the medication. Frustrating!', '2023-10-02 23:45:00'),
    (1, 2, 'Is it safe to drink alcohol while on this medication?', '2023-10-03 00:30:00'),
    (2, 3, 'Experiencing mood swings. Not sure if it\'s related to the drug.', '2023-10-04 01:15:00'),
    (1, 1, 'Having trouble concentrating. Anyone else facing this issue?', '2023-10-05 02:00:00'),
    (2, 2, 'Feeling extremely fatigued. It\'s affecting my daily activities.', '2023-10-06 02:45:00'),
    (1, 2, 'Experiencing chest tightness. Should I seek medical advice?', '2023-10-07 03:30:00'),
    (2, 3, 'Having trouble swallowing. Concerned about my throat.', '2023-10-08 04:15:00'),
    (1, 1, 'Has anyone experienced hair thinning? It\'s worrying me.', '2023-10-09 05:00:00'),
    (2, 2, 'Feeling more sensitive to cold. Is this a side effect?', '2023-10-10 05:45:00'),
    (1, 2, 'Experiencing frequent hiccups. Strange side effect!', '2023-10-11 06:30:00'),
    (2, 3, 'Feeling frequent stomach cramps. Not sure if it\'s related to the medication.', '2023-10-12 07:15:00'),
    (1, 1, 'Has anyone experienced dry eyes? It\'s uncomfortable.', '2023-10-13 08:00:00'),
    (2, 2, 'Feeling more nervous than usual. Can\'t seem to calm down.', '2023-10-14 08:45:00'),
    (1, 2, 'Experiencing loss of energy. Finding it hard to stay active.', '2023-10-15 09:30:00'),
    (2, 3, 'Feeling weakness in muscles. Anyone else facing this issue?', '2023-10-16 10:15:00'),
    (1, 1, 'Has anyone experienced sensitivity to heat? It\'s unusual.', '2023-10-17 11:00:00'),
    (2, 2, 'Feeling stomach ulcers. Should I stop the medication?', '2023-10-18 11:45:00'),
    (1, 2, 'Experiencing kidney pain. This can\'t be normal, right?', '2023-10-19 12:30:00'),
    (2, 3, 'Feeling throat tightness. It\'s making it hard to swallow.', '2023-10-20 13:15:00'),
    (1, 1, 'Has anyone experienced weight fluctuations? It\'s concerning.', '2023-10-21 14:00:00'),
    (2, 2, 'Feeling bleeding gums. Should I be worried about my dental health?', '2023-10-22 14:45:00'),
    (1, 2, 'Experiencing nasal bleeding. Is this related to the medication?', '2023-10-23 15:30:00'),
    (2, 3, 'Feeling frequent burping. It\'s uncomfortable and embarrassing.', '2023-10-24 16:15:00'),
    (1, 1, 'Has anyone experienced facial flushing? It happens randomly.', '2023-10-25 17:00:00'),
    (2, 2, 'Feeling difficulty speaking clearly. Is this a side effect?', '2023-10-26 17:45:00'),
    (1, 2, 'Experiencing occasional difficulty swallowing. Should I be concerned?', '2023-10-27 18:30:00'),
    (2, 3, 'Feeling increased nervousness. It\'s affecting my daily life.', '2023-10-28 19:15:00'),
    (1, 1, 'Has anyone experienced loss of energy? It\'s making me lethargic.', '2023-10-29 20:00:00'),
    (2, 2, 'Feeling loss of strength in muscles. Worried about my physical abilities.', '2023-10-30 20:45:00'),
    (1, 2, 'Experiencing hair thinning. It\'s affecting my self-confidence.', '2023-10-31 21:30:00'),
    (2, 3, 'Feeling joint swelling. It\'s painful and restricting my movement.', '2023-11-01 22:15:00'),
    (1, 1, 'Has anyone experienced sensitivity to cold? I\'m shivering all the time.', '2023-11-02 23:00:00'),
    (2, 2, 'Feeling sensitivity to heat. Is this related to the medication or another issue?', '2023-11-03 23:45:00'),
    (1, 2, 'Experiencing stomach ulcers. It\'s causing me intense pain.', '2023-11-04 00:30:00'),
    (2, 3, 'Feeling kidney pain. It\'s a sharp pain. Should I go to the emergency room?', '2023-11-05 01:15:00'),
    (1, 1, 'Has anyone experienced throat tightness? It feels like my throat is closing up.', '2023-11-06 02:00:00'),
    (2, 2, 'Feeling weight fluctuations. My weight keeps changing rapidly.', '2023-11-07 02:45:00'),
    (1, 2, 'Experiencing bleeding gums. It\'s making it difficult to eat.', '2023-11-08 03:30:00'),
    (2, 3, 'Feeling nasal bleeding. It\'s continuous. Should I stop the medication?', '2023-11-09 04:15:00'),
    (1, 1, 'Has anyone experienced frequent burping? It\'s embarrassing in public.', '2023-11-10 05:00:00'),
    (2, 2, 'Feeling facial flushing. My face turns red and hot randomly.', '2023-11-11 05:45:00'),
    (1, 2, 'Experiencing difficulty speaking clearly. My words get jumbled up.', '2023-11-12 06:30:00'),
    (2, 3, 'Feeling increased nervousness. It\'s hard to relax.', '2023-11-13 07:15:00'),
    (1, 1, 'Has anyone experienced loss of energy? It\'s making it hard to get out of bed.', '2023-11-14 08:00:00'),
    (2, 2, 'Feeling loss of strength in muscles. It\'s affecting my ability to exercise.', '2023-11-15 08:45:00'),
    (1, 2, 'Experiencing hair thinning. It\'s making my hair look sparse.', '2023-11-16 09:30:00'),
    (2, 3, 'Feeling joint swelling. It\'s making it difficult to bend my joints.', '2023-11-17 10:15:00');




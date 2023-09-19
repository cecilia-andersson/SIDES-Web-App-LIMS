CREATE TABLE drugs (
    drug_id INT PRIMARY KEY AUTO_INCREMENT,
    drug_brand VARCHAR(50) NOT NULL,
    drug_class VARCHAR(20) NOT NULL,
    drug_active_ingredient VARCHAR(70) NOT NULL,
    drug_inactive_ingredient VARCHAR(70) NOT NULL, 
    CONSTRAINT drug_name UNIQUE (drug_brand, drug_active_ingredient, drug_inactive_ingredient)

);

--PRIMARY KEY (drug_brand, drug_active_ingredient, drug_inactive_ingredient)


CREATE TABLE side_effects (
    se_id INT PRIMARY KEY AUTO_INCREMENT, 
    se_name VARCHAR(50) NOT NULL
);

--R as in Report
CREATE TABLE drug_association_report (
    R_association_id INT PRIMARY KEY AUTO_INCREMENT,
    R_drug_fk_id INT,
    R_se_fk_id INT,
    report BOOLEAN,
    report_date Timestamp, -- fk from when user makes a report.
    FOREIGN KEY (R_drug_fk_id) REFERENCES drugs(drug_id),
    FOREIGN KEY (R_se_fk_id) REFERENCES side_effects(se_id)  
    --FOREIGN KEY (report_date) REFERENCES usertable(report_date) -- this is added when someone reports.  
);


-- F as in FASS
CREATE TABLE drug_association_fass (
    F_association_id INT PRIMARY KEY AUTO_INCREMENT,
    F_drug_fk_id INT,
    F_ se_fk_id INT,
    -- in_fass BOOLEAN, -- but only save if yes? do we need this then
    FOREIGN KEY (F_drug_fk_id) REFERENCES drugs(drug_id),
    FOREIGN KEY (F_se_fk_id) REFERENCES side_effects(se_id)  
);






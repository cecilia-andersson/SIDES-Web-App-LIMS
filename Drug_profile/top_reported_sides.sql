-- DRAFT SQL CODE FOR DISPLAYING TOP USER-REPORTED SIDE EFFECTS

-- Current issue: I think I need to figure out how to concatenate the top 3 side effects into a string, because
-- right now this code (it runs in phpmyadmin!) outputs a table with up to 3 rows, with the drug brand/class/actives/inactives
-- (repeated identically in each row), and the top three (different) side effects. I think that's why it's having problems
-- populating the data correctly into the web page when I try adding this code (and a line to echo the top 3 side effects)
-- in the drug_page.php document. Will keep working :) - Cecilia, 22/9

--Creating a temp table joining side effect names and side effect, drug IDs
CREATE TEMPORARY TABLE occurrences AS
SELECT side_effects.se_name, side_effects.se_id, drug_association_report.R_drug_fk_id
FROM drug_association_report
INNER JOIN side_effects ON side_effects.se_id=drug_association_report.R_se_fk_id;
            
-- Creating a temp table with drug IDs, side effect names, and count of identical occurrences of that unique combo (drug ID+side effect name)
CREATE TEMPORARY TABLE running_tallies AS
SELECT R_drug_fk_id, se_name, COUNT(*) AS occurrence_count
FROM occurrences
GROUP BY R_drug_fk_id, se_name
ORDER BY R_drug_fk_id, occurrence_count DESC;
            
-- Temporary table of just the top 3 side effects for each drug, listed by drug ID
CREATE TEMPORARY TABLE top_reported_sides AS
SELECT R_drug_fk_id, se_name
FROM running_tallies 
LIMIT 3;

-- Fetching drug info and the top side effects
SELECT drugs.drug_brand, drugs.drug_class, drugs.drug_active_ingredient, drugs.drug_inactive_ingredient, top_reported_sides.se_name
FROM top_reported_sides
INNER JOIN drugs ON drugs.drug_id=top_reported_sides.R_drug_fk_id
WHERE drug_id = $drug_id -- from a click, made to align with 'drug_page' syntax

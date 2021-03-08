DROP TABLE IF EXISTS members_alphabet_asc;
SET @counter := 0;
CREATE TABLE members_alphabet_asc ENGINE=MyISAM SELECT (@counter := @counter + 1) AS position,id,username from users ORDER BY username ASC;
ALTER TABLE `members_alphabet_asc` CHANGE `position` `position` BIGINT(21) NOT NULL;
ALTER TABLE `members_alphabet_asc` ADD PRIMARY KEY(`position`);



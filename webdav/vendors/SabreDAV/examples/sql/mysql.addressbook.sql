CREATE TABLE addressbooks (
	id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	principaluri VARCHAR(255),
	displayname VARCHAR(255),
	uri VARCHAR(100),
	description TEXT,
	ctag INT(11) UNSIGNED NOT NULL DEFAULT '1'
);

CREATE TABLE cards ( 
	id INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	addressbookid INT(11) UNSIGNED NOT NULL, 
	carddata TEXT, 
	uri VARCHAR(100), 
	lastmodified INT(11) UNSIGNED 
);


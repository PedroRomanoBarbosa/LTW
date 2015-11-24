PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS eventUser;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS typeOfEvent;

CREATE TABLE user (
	id INTEGER PRIMARY KEY,
	name TEXT,
	username TEXT,
	password TEXT
);

CREATE TABLE typeOfEvent(
	id INTEGER PRIMARY KEY,
	type TEXT
);

CREATE TABLE event (
	id INTEGER PRIMARY KEY,
	ownerId INTEGER REFERENCES user(id),
	name TEXT,
	image INTEGER,
	imagePath TEXT,
	dateOfEvent DATE,
	description TEXT,
	type INTEGER REFERENCES typeOfEvent(id)
);

CREATE TABLE eventUser (
	userId INTEGER REFERENCES user(id) ON DELETE CASCADE,
	eventId INTEGER REFERENCES event(id) ON DELETE CASCADE,
	PRIMARY KEY (userId, eventId)
);

CREATE TABLE comment (
	id INTEGER PRIMARY KEY,
	userId INTEGER REFERENCES user(id),
	eventId INTEGER REFERENCES event(id) ON DELETE CASCADE,
	content TEXT
);


/* INSERT TYPES OF EVENTS */
INSERT INTO typeOfEvent (type) VALUES ("Party");
INSERT INTO typeOfEvent (type) VALUES ("Concert");
INSERT INTO typeOfEvent (type) VALUES ("Conference");
INSERT INTO typeOfEvent (type) VALUES ("Wedding");
INSERT INTO typeOfEvent (type) VALUES ("Meeting");

/* INSERT USERS */
INSERT INTO user (name,username,password) VALUES ("Pedro Romano Barbosa","Romanolas","123456");
INSERT INTO user (name,username,password) VALUES ("João Romano Barbosa","Greentong","123456");


/* INSERT EVENTS */
INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, type) VALUES (
	(SELECT id FROM user WHERE id=1),
	"D'bandada", 0, "example.jpg", "2015-11-23 12:00", "example description",
	(SELECT id FROM typeOfEvent WHERE id=2)
);

INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, type) VALUES (
	(SELECT id FROM user WHERE id=1),
	"Paredes de Coura", 1, "images/eventImages/image1.jpg", "2015-11-23 12:30", "example description",
	(SELECT id FROM typeOfEvent WHERE id=2)
);


/* INSERT EVENT USER JUNCTION TABLE */
INSERT INTO eventUser (userId, eventId) VALUES (1,1);
INSERT INTO eventUser (userId, eventId) VALUES (1,2);
INSERT INTO eventUser (userId, eventId) VALUES (2,1);


/* QUERIES */
SELECT * FROM typeOfEvent;
SELECT * FROM user;
SELECT * FROM event;
SELECT * FROM eventUser;

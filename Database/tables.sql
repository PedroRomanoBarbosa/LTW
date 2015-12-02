PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS eventUser;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS typeOfEvent;

CREATE TABLE user (
	id INTEGER PRIMARY KEY,
	name TEXT,
	username TEXT,
	password TEXT,
	imagePath TEXT
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
	typeId INTEGER REFERENCES typeOfEvent(id)
);

CREATE TABLE eventUser (
	userId INTEGER REFERENCES user(id) ON DELETE CASCADE,
	eventId INTEGER REFERENCES event(id) ON DELETE CASCADE,
	PRIMARY KEY (userId, eventId)
);

CREATE TABLE comment (
	id INTEGER PRIMARY KEY,
	userId INTEGER REFERENCES user(id) ON DELETE CASCADE,
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
INSERT INTO user (name,username,password,imagePath) VALUES ("Pedro Romano Barbosa","Romanolas","123456","images/userImages/image1.jpg");
INSERT INTO user (name,username,password,imagepath) VALUES ("João Romano Barbosa","Greentong","123456","images/userImages/image2.jpg");


/* INSERT EVENTS */
INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, typeId) VALUES (
	(SELECT id FROM user WHERE id=1),
	"D'bandada", 0, "example.jpg", "2015-11-23 12:00", "example description",
	(SELECT id FROM typeOfEvent WHERE id=2)
);

INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, typeId) VALUES (
	(SELECT id FROM user WHERE id=1),
	"Jantar de Curso MIEIC", 0, "example.jpg", "2016-01-10 12:30", "Jantar de curso ;)",
	(SELECT id FROM typeOfEvent WHERE id=1)
);

INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, typeId) VALUES (
	(SELECT id FROM user WHERE id=1),
	"Paredes de Coura", 1, "images/eventImages/image1.jpg", "2015-11-23 12:30", "example description",
	(SELECT id FROM typeOfEvent WHERE id=2)
);

INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, typeId) VALUES (
	(SELECT id FROM user WHERE id=1),
	"Back to The Past", 0, "example.jpg", "2014-11-23 12:30", "Time travel 0.o",
	(SELECT id FROM typeOfEvent WHERE id=2)
);


/* INSERT COMENTS */
INSERT INTO comment (userId, eventId, content) VALUES (1,1," Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae vestibulum nibh, eu mattis nunc. Donec ut diam nisl. Maecenas sed dolor vel sapien tristique maximus eu in leo. Mauris molestie eu diam a tempus. Fusce at ex mauris. Donec fermentum augue id elit dignissim gravida non eget eros. Aenean maximus purus sed aliquam rhoncus.");
INSERT INTO comment (userId, eventId, content) VALUES (2,1," Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae vestibulum nibh, eu mattis nunc. Donec ut diam nisl. Maecenas sed dolor vel sapien tristique maximus eu in leo. Mauris molestie eu diam a tempus. Fusce at ex mauris. Donec fermentum augue id elit dignissim gravida non eget eros. Aenean maximus purus sed aliquam rhoncus.");


/* INSERT EVENT USER JUNCTION TABLE */
INSERT INTO eventUser (userId, eventId) VALUES (1,3);
INSERT INTO eventUser (userId, eventId) VALUES (1,2);
INSERT INTO eventUser (userId, eventId) VALUES (1,4);

INSERT INTO eventUser (userId, eventId) VALUES (2,1);
INSERT INTO eventUser (userId, eventId) VALUES (2,2);
INSERT INTO eventUser (userId, eventId) VALUES (2,3);


/* QUERIES */
SELECT * FROM typeOfEvent;
SELECT * FROM user;
SELECT * FROM event;
SELECT * FROM eventUser;

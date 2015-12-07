PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS eventPhoto;
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
	image INTEGER,
	imagePath TEXT,
	biography TEXT
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

CREATE TABLE eventPhoto(
	id INTEGER PRIMARY KEY,
	eventId INTEGER REFERENCES event(id) ON DELETE CASCADE,
	imagePath TEXT
);


/* INSERT TYPES OF EVENTS */
INSERT INTO typeOfEvent (type) VALUES ("Party");
INSERT INTO typeOfEvent (type) VALUES ("Concert");
INSERT INTO typeOfEvent (type) VALUES ("Conference");
INSERT INTO typeOfEvent (type) VALUES ("Wedding");
INSERT INTO typeOfEvent (type) VALUES ("Meeting");

/* INSERT USERS */
INSERT INTO user (name,username,password,image,imagePath,biography) VALUES ("Pedro Romano Barbosa","Romanolas","$2y$10$ElJ6s4i5XqmZP5i.fbJdsuKp//QwDVxvKSWV.72jt5Bx3v2WV8aHa",1,"images/userImages/userImage1.jpg","I'm Pedro.");
INSERT INTO user (name,username,password,image,imagepath,biography) VALUES ("João Romano Barbosa","Greentong","$2y$10$ElJ6s4i5XqmZP5i.fbJdsuKp//QwDVxvKSWV.72jt5Bx3v2WV8aHa",1,"images/userImages/userImage2.jpg", "I'm João.");
INSERT INTO user (name,username,password,image,imagepath,biography) VALUES ("Pedro Romano Barbosa","Romano","$2y$10$ElJ6s4i5XqmZP5i.fbJdsuKp//QwDVxvKSWV.72jt5Bx3v2WV8aHa",1,"images/userImages/userImage3.jpg", "I'm João.");

/* INSERT EVENTS */
INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, typeId) VALUES (1,"D'bandada", 0, "images/defaultImage.jpeg", "2015-11-23 12:00", "example description",2);

INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, typeId) VALUES (1,"Jantar de Curso MIEIC", 0, "images/defaultImage.jpeg", "2016-01-10 12:30", "Jantar de curso ;)",1);

INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, typeId) VALUES (1,"Paredes de Coura", 1, "images/eventImages/eventImage3.jpg", "2015-11-23 12:30", "example description",2);

INSERT INTO event (ownerId, name, image, imagePath, dateOfEvent, description, typeId) VALUES (1,"Back to The Past", 0, "images/defaultImage.jpeg", "2014-11-23 12:30", "Time travel 0.o",2);


/* INSERT COMENTS */
INSERT INTO comment (userId, eventId, content) VALUES (1,1," Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae vestibulum nibh, eu mattis nunc. Donec ut diam nisl. Maecenas sed dolor vel sapien tristique maximus eu in leo. Mauris molestie eu diam a tempus. Fusce at ex mauris. Donec fermentum augue id elit dignissim gravida non eget eros. Aenean maximus purus sed aliquam rhoncus.");
INSERT INTO comment (userId, eventId, content) VALUES (2,1," Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vitae vestibulum nibh, eu mattis nunc. Donec ut diam nisl. Maecenas sed dolor vel sapien tristique maximus eu in leo. Mauris molestie eu diam a tempus. Fusce at ex mauris. Donec fermentum augue id elit dignissim gravida non eget eros. Aenean maximus purus sed aliquam rhoncus.");


/* INSER EVENT PHOTOS */
INSERT INTO eventPhoto (eventId, imagePath) VALUES (1,"images/eventGalleryPhotos/egp-1-1.jpg");
INSERT INTO eventPhoto (eventId, imagePath) VALUES (1,"images/eventGalleryPhotos/egp-1-2.jpg");
INSERT INTO eventPhoto (eventId, imagePath) VALUES (1,"images/eventGalleryPhotos/egp-1-3.jpg");
INSERT INTO eventPhoto (eventId, imagePath) VALUES (1,"images/eventGalleryPhotos/egp-1-4.jpg");
INSERT INTO eventPhoto (eventId, imagePath) VALUES (1,"images/eventGalleryPhotos/egp-1-5.jpg");



/* INSERT EVENT USER JUNCTION TABLE */
INSERT INTO eventUser (userId, eventId) VALUES (1,3);
INSERT INTO eventUser (userId, eventId) VALUES (1,2);
INSERT INTO eventUser (userId, eventId) VALUES (1,4);

INSERT INTO eventUser (userId, eventId) VALUES (2,1);
INSERT INTO eventUser (userId, eventId) VALUES (2,2);
INSERT INTO eventUser (userId, eventId) VALUES (2,3);

INSERT INTO eventUser (userId, eventId) VALUES (3,1);

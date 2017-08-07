-- These statements drop the tables and re-add them.
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS district;

-- table district
CREATE TABLE district (
districtId INT UNSIGNED AUTO_INCREMENT NOT NULL,
districtGeom GEOMETRY NOT NULL,
districtName VARCHAR(255),
PRIMARY KEY(districtId)
);

-- table profile
CREATE TABLE profile (
profileId INT UNSIGNED AUTOINCREMENT NOT NULL,
profileDistrictId INT,
profileActivationToken CHAR(32),
profileAddress1 STRING NOT NULL,
profileAddress2 STRING,
profileCity STRING NOT NULL,
profileEmail VARCHAR(128) NOT NULL,
profileFirstName STRING NOT NULL,
profileHash CHAR(128) NOT NULL,
profileLastName STRING NOT NULL,
profileRepresentative TINYINT,
profileSalt CHAR(64) NOT NULL,
profileState STRING NOT NULL,
profileUserName VARCHAR(32) NOT NULL,
profileZip VARCHAR(32) NOT NULL,
UNIQUE(profileEmail),
UNIQUE(profileUserName),
INDEX(postProfileId),
PRIMARY KEY(profileId)
);

-- table post
CREATE TABLE post (
postParentId INT UNSIGNED AUTOINCREMENT NOT NULL,
postProfileId INT NOT NULL,
postContent VARCHAR(255) NOT NULL,
postDateTime DATETIME(6) NOT NULL,
postDistrictId TINYINT NOT NULL,
INDEX(postProfileId)
FOREIGN KEY(postProfileId) REFERENCES profile(profileId),
PRIMARY KEY(postParentId)
);

-- table vote
CREATE TABLE vote (
votePostId INT UNSIGNED AUTOINCREMENT NOT NULL,
voteProfileId INT NOT NULL,
voteValue TINYINT NOT NULL,
INDEX(voteProfileId),
FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
PRIMARY KEY(votePostId)
);

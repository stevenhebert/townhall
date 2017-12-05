-- These statements drop the tables and re-add them.
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS district;

-- table district
CREATE TABLE district (
	districtId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	districtGeom GEOMETRY                  NOT NULL,
	districtName VARCHAR(64)	NOT NULL,
	PRIMARY KEY (districtId)
);

-- table profile
CREATE TABLE profile (
	profileId              INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileDistrictId      INT UNSIGNED                NOT NULL,
	profileActivationToken CHAR(32),
	profileAddress1        VARCHAR(64)                 NOT NULL,
	profileAddress2        VARCHAR(64),
	profileCity            VARCHAR(64)                 NOT NULL,
	profileDateTime        TIMESTAMP(6)                NOT NULL DEFAULT ON UPDATE CURRENT_TIMESTAMP(6),
	profileEmail           VARCHAR(128)                NOT NULL,
	profileFirstName       VARCHAR(64)                 NOT NULL,
	profileHash            CHAR(128)                   NOT NULL,
	profileLastName        VARCHAR(64)                 NOT NULL,
	profileRecoveryToken   CHAR(32),
	profileRepresentative  TINYINT UNSIGNED,
	profileSalt            CHAR(64)                    NOT NULL,
	profileState           CHAR(2)                     NOT NULL,
	profileUserName        VARCHAR(32)                 NOT NULL,
	profileZip             VARCHAR(10)                 NOT NULL,
	UNIQUE (profileEmail),
	UNIQUE (profileUserName),
	INDEX (profileDistrictId),
	FOREIGN KEY (profileDistrictId) REFERENCES district (districtId),
	PRIMARY KEY (profileId)
);

-- table post
CREATE TABLE post (
	postId         INT UNSIGNED AUTO_INCREMENT NOT NULL,
	postDistrictId INT UNSIGNED                NOT NULL,
	postParentId   INT UNSIGNED,
	postProfileId  INT UNSIGNED                NOT NULL,
	postContent    VARCHAR(8192)               NOT NULL,
	postDateTime   TIMESTAMP(6)                NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
	INDEX (postDistrictId),
	INDEX (postParentId),
	INDEX (postProfileId),
	FOREIGN KEY (postDistrictId) REFERENCES district (districtId),
	FOREIGN KEY (postParentId) REFERENCES post (postId),
	FOREIGN KEY (postProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (postId)
);

-- table vote
CREATE TABLE vote (
	votePostId    INT UNSIGNED                NOT NULL,
	voteProfileId INT UNSIGNED                NOT NULL,
	voteDateTime  TIMESTAMP(6)                NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
	voteValue     TINYINT                     NOT NULL,
	INDEX (votePostId),
	INDEX (voteProfileId),
	FOREIGN KEY (votePostId) REFERENCES post (postId),
	FOREIGN KEY (voteProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (votePostId, voteProfileId)
);

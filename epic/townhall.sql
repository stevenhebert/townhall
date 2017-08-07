-- These statements drop the tables and re-add them.
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS district;

-- table district

-- table profile

-- table post
CREATE TABLE post {
postParentId INT UNSIGNED AUTOINCREMENT NOT NULL,
postProfileId INT NOT NULL,
postContent VARCHAR(255) NOT NULL,
postDateTime DATETIME(6) NOT NULL,
postDistrictId TINYINT NOT NULL,
INDEX(postProfileId)
FOREIGN KEY(postProfileId) REFERENCES profile(profileId),
PRIMARY KEY(postParentId)
}

-- table vote
CREATE TABLE vote (
votePostId INT UNSIGNED AUTOINCREMENT NOT NULL,
voteProfileId INT NOT NULL,
voteValue TINYINT NOT NULL,
INDEX(voteProfileId),
FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
PRIMARY KEY(votePostId)
)

-- These statements drop the tables and re-add them.
DROP TABLE IF EXISTS vote;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS district;

-- table district

-- table profile

-- table post

-- table vote
CREATE TABLE vote (
votePostId INT UNSIGNED AUTOINCREMENT NOT NULL,
voteProfileId INT NOT NULL,
voteValue TINYINT NOT NULL,
INDEX(voteProfileId),
FOREIGN KEY(voteProfileId) REFERENCES profile(profileId),
PRIMARY KEY(votePostId)
)

votePostId int autoincrement</li>
			<li>voteProfileId int</li>
			<li>voteValue tinyint</li>
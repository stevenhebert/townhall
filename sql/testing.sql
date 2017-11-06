/* to check what data is in the tables, run these one at a time */
select count(*) from district;
select count(*) from profile;
select count(*) from post;
select count(*) from vote;
/*to delete values from the tables, delete in this order*/
delete from vote;
delete from post where postParentId is not null;
delete from post;
delete from profile;
delete from district;

/* insert statements to test data.  Run these in order. */

INSERT INTO district(districtGeom, districtName) VALUES (ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('{"type":"Polygon","coordinates":[[[0,0],[10,0],[10,10],[0,10],[0,0]]]}'))), 'District 15');

INSERT INTO profile(profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip) VALUES(
	(select districtId from district where districtName='District 15'), null, '123 Main St', null, 'Albuquerque', 'jeanluc@ussenterprise.gov', 'Jean-Luc', '0573f445ce054b1ddaf6f3b28e9e7cc408f8ca280e0e9fd2393cb22b37b5e8299d2813591c28a43f50963d9654664d76f949123766bd83f5a052d327df7778ac', 'Picard', null, null, '4c22bdf27a3f10ea798bee964db7ee662c79a03280e73e6d7854814f3ae1625c', 'NM', 'IamJeanLuc', '87112');

INSERT INTO post(postDistrictId, postParentId, postProfileId, postContent) VALUES ((select profileDistrictId from profile where profileEmail =  'jeanluc@ussenterprise.gov'), null, (select profileId from profile where profileEmail =  'jeanluc@ussenterprise.gov'), 'Nicely Done');

/* to create a parent post, add an additional profile and post  Password is 'ilovelucy' */
INSERT INTO profile(profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip) VALUES(
	(select districtId from district where districtName='District 15'), null, '11 Lizard Ln', null, 'Santa Fe', 'lucyeatslizards@leapinglizards.com', 'Lucy', '5e4e5bcb1b2f8cec7199196f6122824edc31301fb81d71960120ad6d909a96903fa6e773f75ef563099f19f09ed7833a29d6b3fda5f34e509f282bce9444b986', 'Lu', null, null, 'e55b4d3184769bc9f808782aa29ac6ec8b6fbfcbd325bd0b75fcc35a0876d404', 'NM', 'OmegaDog', '87112');

/*to do a parent post, use this.  I know this subquery wouldn't be a unique select from post if there were more than one post, but it works to add a parent for the one post here.*/
INSERT INTO post(postDistrictId, postParentId, postProfileId, postContent) VALUES ((select profileDistrictId from profile where profileEmail =  'lucyeatslizards@leapinglizards.com'), (select postId from post p where postprofileId =(select profileId from profile where profileEmail = 'jeanluc@ussenterprise.gov')), (select profileId from profile where profileEmail =  'lucyeatslizards@leapinglizards.com'), 'Squirrel?');

/*and here's the second profile with a valid activation token.  You can't add this if you've already added the profile for lucy, but if you need a profile with an activation token , you can use this.  password is the same, 'ilovelucy' */
INSERT INTO profile(profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileEmail, profileFirstName, profileHash, profileLastName, profileRepresentative, profileSalt, profileState, profileUserName, profileZip) VALUES(
	(select districtId from district where districtName='District 15'), 'abcabcabc11111122222233333344444', '111 Lizard Ln', null, 'Santa Fe', 'lucyeatslizards@leapinglizards.com', 'Lucy', '5e4e5bcb1b2f8cec7199196f6122824edc31301fb81d71960120ad6d909a96903fa6e773f75ef563099f19f09ed7833a29d6b3fda5f34e509f282bce9444b986', 'Lu', null, 'e55b4d3184769bc9f808782aa29ac6ec8b6fbfcbd325bd0b75fcc35a0876d404', 'NM', 'OmegaDog', '87112');
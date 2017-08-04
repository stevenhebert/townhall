<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Conceptual Model</title>
	</head>
	<body>
		<h1>Conceptual Model</h1>
		<h3>Entities</h3>
		<p>profile</p>
		<ul>
			<li>profileId int autoincrement</li>
			<li>profileDistrictId int</li>
			<li>profileActivationToken string</li>
			<li>profileAddress1 string</li>
			<li>profileAddress2 string</li>
			<li>profileCity string</li>
			<li>profileEmail string</li>
			<li>profileFirstName string</li>
			<li>profileHash string</li>
			<li>profileLastName string</li>
			<li>profileRepresentative tinyint</li>
			<li>profileSalt string</li>
			<li>profileState string</li>
			<li>profileUserName string</li>
			<li>profileZip string</li>
		</ul>

		<p>district</p>
		<ul>
			<li>districtId int autoincrement</li>
			<li>districtGeom geometry</li>
			<li>districtName string</li>
		</ul>


		<p>post</p>
		<ul>
			<li>postId int autoincrement</li>
			<li>postParentId int</li>
			<li>postProfileId int</li>
			<li>postContent string</li>
			<li>postDateTime datetime</li>
			<li>postDistrictId int</li>
			<li>postSticky tinyint</li>
		</ul>

		<p>vote</p>
		<ul>
			<li>votePostId int autoincrement</li>
			<li>voteProfileId int</li>
			<li>voteValue tinyint</li>
		</ul>

		<h3>Relations</h3>
		<ul>
			<li>One profile has one district (1 to 1)</li>
			<li>One post has one district (1 to 1)</li>
			<li>Many profiles can vote on many posts (m to n)</li>
			<li>Each post has one profile, but a profile can have many posts (1 to n)</li>

			<img src="images/townhall-erd.jpg" alt="townhall-erd"/>

	</body>
</html>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Conceptual Model</title>
	</head>
	<body>
		<h1>Conceptual Model</h1>
		<p>profile</p>
		<ul>
			<li>profileId int autoincrement</li>
			<li>profileDistrictId int</li>
			<li>profileFirstName string</li>
			<li>profileLastName string</li>
			<li>profileUserName string</li>
			<li>profileAddress1 string</li>
			<li>profileAddress2 string</li>
			<li>profileCity string</li>
			<li>profileState string</li>
			<li>profileZip string</li>
			<li>profileEmail string</li>
			<li>profileHash string</li>
			<li>profileSalt string</li>
			<li>profileActivationToken string</li>
			<li>profileRepresentative tinyint</li>
		</ul>

		<p>district</p>
		<ul>
			<li>districtId int autoincrement</li>
			<li>districtNumber string</li>
			<li>districtGeom geometry</li>
		</ul>


		<p>post</p>
		<ul>
			<li>postId int autoincrement</li>
			<li>postProfileId int</li>
			<li>postContent string</li>
			<li>postDateTime datetime</li>
			<li>postDistrictId int</li>
			<li>postSticky tinyint</li>
		</ul>

		<p>vote</p>
		<ul>
			<li>votePostId int</li>
			<li>voteProfileId int</li>
			<li>voteUpOrDown tinyint</li>
		</ul>

		<p>Relations</p>
		<ul>
			<li>One profile has one district, but one district is on many profile (1 to n)o</li>
			<li>One post has one district, but one district can be on many posts (1 to n)</li>
			<li>Many profiles can vote on many posts (m to n)</li>
			<li>Each post has one profile, but a profile can have many posts (1 to n)</li>
			<li>One profile can have many votes, but only vote per post (1 to n)</li>
			<li>One post can have many votes (1 to n)</li>
		</ul>

	</body>
</html>
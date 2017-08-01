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
			<li>profileTypeId int</li>
		</ul>

		<p>type</p>
		<ul><li>typeId int autoincrement</li>
			<li>typeCode string</li>
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

		</ul>
		<p>vote</p>
		<ul>
			<li></li>

		</ul>
	</body>
</html>
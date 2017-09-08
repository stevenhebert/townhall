<?php
require_once ("../classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Townhall\{Profile, Post, JsonObjectStorage};




/**
 * function to get ProfileName by PostId
 * @param \SplFixedArray $posts an array of post
 * @returns  $postProfiles[] storage of posts with coresponding user names
 *
 * @throws
 * Date: 9/8/17
 * Time: 9:55 AM
 */

function getPostProfileName (\SplFixedArray $posts) : array {

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/townhall.ini");
	$postProfiles = [];

	foreach($posts as  $post) {

		$profile = Profile::getProfileByProfileId($pdo, $post->getPostProfileId());
		$postProfile = (object) [
			'postId' => $post->getPostId(),
			'postDistrict' => $post->getPostDistrictId(),
			'postParentId' => $post->getPostParentId(),
			'postProfileName' => $profile->getProfileId(),
			'postContent' => $post->getPostContent(),
			'postDateTime' => $post->getPostDateTime()
		];

		$postProfiles[] =$postProfile;
	}
	return $postProfiles;
}
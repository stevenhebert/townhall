<?php

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

require_once (dirname(__DIR__) . "/classes/autoload.php");

use Edu\Cnm\Townhall\{Profile, Post, Vote, JsonObjectStorage};




/**
 * function to get ProfileName by PostId
 * @param \SplFixedArray $posts an array of post
 * @returns  $postProfiles[] storage of posts with coresponding user names
 *
 * @throws
 * Date: 9/8/17
 * Time: 9:55 AM
 */

function getPostProfileName (\SplFixedArray $posts) : JsonObjectStorage {

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/townhall.ini");
	$storage = new JsonObjectStorage();

	foreach($posts as  $post) {

		$profile = Profile::getProfileByProfileId($pdo, $post->getPostProfileId());
		$postProfile = (object) [
			'postId' => $post->getPostId(),
			'postDistrictId' => $post->getPostDistrictId(),
			'postParentId' => $post->getPostParentId(),
			'postProfileUserName' => $profile->getProfileUserName(),
			'postContent' => $post->getPostContent(),
			'postDateTime' => round($post->getPostDateTime()->format("U.u" ) * 1000)
		];

		$vote = Vote::getSumOfVoteValuesByPostId($pdo, $post->getPostId());

		$storage->attach($postProfile,$vote);
	}
	return $storage;
}

function getPostProfile(Post $post) {

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/townhall.ini");
	$storage = new JsonObjectStorage();

	$profile = Profile::getProfileByProfileId($pdo, $post->getPostProfileId());
	$postProfile = (object) [
		'postId' => $post->getPostId(),
		'postDistrictId' => $post->getPostDistrictId(),
		'postParentId' => $post->getPostParentId(),
		'postProfileUserName' => $profile->getProfileUserName(),
		'postContent' => $post->getPostContent(),
		'postDateTime' => round($post->getPostDateTime()->format("U.u" ) * 1000)
	];

	return $postProfile;
}
<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

// inclusion of profile and district classes is strictly for testing purposes
use Edu\Cnm\Townhall\{District, Profile, Post, Vote};

/**
 * api for the Vote class
 *
 * @author {} <mbojorquez2007@gmail.com>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/townhall.ini");

	// mock a logged in user by mocking the session and assigning a specific user to it.
	// this is only for testing purposes and should not be in the live code.
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);
	$person = 1234;
	// grab a profile by its profileId and add it to the session
	$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, $person);
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$VotePostId = filter_input(INPUT_GET, "VotePostId", FILTER_VALIDATE_FLOAT);
	$VoteProfileId = filter_input(INPUT_GET, "VoteProfileId", FILTER_VALIDATE_FLOAT);
	$voteValue = filter_input(INPUT_GET, "voteValue", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//
	$formattedSunriseDate = date_format(INPUT_GET, "Y-m-d H:i:s.u");
	$formattedSunsetDate = date_format(INPUT_GET, "Y-m-d H:i:s.u");
	//
	//
	$voteDistrictId = filter_input(INPUT_GET, "voteDistrictId", FILTER_VALIDATE_INT);
	$voteParentId = filter_input(INPUT_GET, "voteParentId", FILTER_VALIDATE_INT);
	//
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// handle GET request - if id is present, that vote is returned, otherwise all votes are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		if(empty($votePostId and $voteProfileId) === false) {
			$vote = Vote::getVoteByVotePostIdAndVoteProfileId($pdo, $votePostId, $voteProfileId);
			if($vote !== null) {
				$reply->data = $vote;
			}

		} else if(empty($voteValue) === false) {
			$votes = Vote::getVotebyVoteValue($pdo, $postProfileId)->toArray();
			if($votes !== null) {
				$reply->data = $votes;
			}
			//		} else if((empty($formattedSunriseDate) === true) || (empty($formattedSunsetDate) === true)) {
//				$votes = Vote::getVoteByVoteDate($pdo,$formattedSunriseDate, $formattedSunsetDate);
//			if($votes !== null) {
//				$reply->data = $votes;
//			}
		} else if(empty($voteDistrictId) === false) {
			$votes = Vote::getVoteByVoteDistrictId($pdo, $voteDistrictId)->toArray();
			if($votes !== null) {
				$reply->data = $votes;
			}
		} else if(empty($voteParentId) === false) {
			$votes = Vote::getVoteByVoteParentId($pdo, $voteParentId)->toArray();
			if($votes !== null) {
				$reply->data = $votes;
			}
		} else {
			$votes = Vote::getAllVotes($pdo)->toArray();
			if($votes !== null) {
				$reply->data = $votes;
			}
		}
	}
	else if($method === "PUT" || $method === "POST") {

			// enforce the user has a XSRF token
			verifyXsrf();

			//  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
			$requestContent = file_get_contents("php://input");

			// This Line Then decodes the JSON package and stores that result in $requestObject
			$requestObject = json_decode($requestContent);

			//make sure vote content is available (required field)
			if(empty($requestObject->voteContent) === true) {
				throw(new \InvalidArgumentException ("No value for Vote.", 405));
			}
			// make sure vote date is accurate
			//if(empty($requestObject->voteDate) === true) {
			//	throw(new \IntlException("date cannot be empty", 405));
			//}

			//  make sure profileId is available
			if(empty($requestObject->voteProfileId) === true) {
				throw(new \InvalidArgumentException ("no profileId found.", 405));
			}

			//  make sure districtId is available
			if(empty($requestObject->postDistrictId) === true) {
				throw(new \InvalidArgumentException ("no districtId found.", 405));
			}


	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$voteProfileId = filter_input(INPUT_GET, "tweetProfileId", FILTER_VALIDATE_INT);
	$tweetContent = filter_input(INPUT_GET, "tweetContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}



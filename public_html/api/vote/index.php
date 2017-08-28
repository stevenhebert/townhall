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
	$votePostId = filter_input(INPUT_GET, "VoteProfileId", FILTER_VALIDATE_INT);
	$voteProfileId = filter_input(INPUT_GET, "VoteTweetId", FILTER_VALIDATE_INT);
	$voteValue = filter_input(INPUT_GET, "VoteValue", FILTER_VALIDATE_INT);
	//
	$formattedSunriseDate = date_format(INPUT_GET, "Y-m-d H:i:s.u");
	$formattedSunsetDate = date_format(INPUT_GET, "Y-m-d H:i:s.u");
	//

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// handle GET request - if id is present, that vote is returned, otherwise all votes are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets  a vote based on its composite key
		if ($votePostId !== null & $voteProfileId !== null) {
			$vote = Vote::getVoteByVotePostIdAndVoteProfileId($pdo, $votePostId, $voteProfileId);
			if($vote!== null) {
				$reply->data = $vote;
			}
			//verify parameters exists if not throw an exception
		} else if(empty($votePostId) === false) {
			$vote = Vote::getVoteByVotePostId($pdo, $votePostId)->toArray();
			if($vote !== null) {
				$reply->data = $vote;
			}
			//get all the votes that belong to that vote profileId
		} else if(empty($voteProfileId) === false) {
			$vote = Vote::getVoteByVoteProfileId($pdo, $voteProfileId)->toArray();
			if($vote !== null) {
				$reply->data = $vote;
			}
			//verify vote value
		} else if(empty($voteValue) === false) {
			$vote = Vote::getVoteByVoteValue($pdo, $voteValue)->toArray();
			if($vote !== null) {
				$reply->data = $vote;
			}
		} else {
			throw new InvalidArgumentException("incorrect parameters ", 404);
		}
	} else if($method === "POST" || $method === "PUT") {
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->votePostId) === true) {
			throw (new \InvalidArgumentException("No Post found linked to vote", 405));
		}
		if(empty($requestObject->voteProfileId) === true) {
			throw (new \InvalidArgumentException("No profile found linked to vote", 405));
		}
		if(empty($requestObject->voteDate) === true) {
			$requestObject->voteDate = null;
		}
		if($method === "POST") {
			// ensure the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post a vote", 403));
			}
			// create new vote and insert into the database
			$vote = new Vote(null, $requestObject->voteProfileId, $requestObject->voteValue, null);
			$vote->insert($pdo);

			$vote = new Vote($requestObject->votePostId, $requestObject->voteProfileId, $requestObject->voteDate, $requestObject->voteValue);
			$vote->insert($pdo);
			$reply->message = "vote successful";
		} else if($method === "PUT") {
			//enforce that the end user has a XSRF token.
			verifyXsrf();
			//grab the vote by its composite key
			$vote = Vote::getVoteByVotePostIdAndVoteValue($pdo, $requestObject->votePostId, $requestObject->voteValue);
			if($vote === null) {
				throw (new RuntimeException("Vote does not exist"));
			}
			//enforce the user is signed in and only trying to edit their own vote
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $vote->getVoteProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this vote", 403));
			}
			//delete
			$vote->delete($pdo);
			//update the message
			$reply->message = "vote deleted";
		}
		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
	//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);
<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
// inclusion of profile classe is strictly for testing purposes
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
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize input
	$votePostId = filter_input(INPUT_GET, "votePostId", FILTER_VALIDATE_INT);
	$voteProfileId = filter_input(INPUT_GET, "voteProfileId", FILTER_VALIDATE_INT);
	$voteValue = filter_input(INPUT_GET, "voteValue", FILTER_VALIDATE_INT);
	//
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets  a vote based on its composite key
		if ($votePostId !== null && $voteProfileId !== null) {
			$vote = Vote::getVoteByPostIdAndProfileId($pdo, $votePostId, $voteProfileId);
			if($vote!== null) {
				$reply->data = $vote;
			}
			//sum votes by vote post id--only use for getting votes by votepostid
		} else if(empty($votePostId) === false) {
			$reply = Vote::getSumOfVoteValuesByPostId($pdo, $votePostId);

			//get all the votes that belong to that vote profileId
		} else if(empty($voteProfileId) === false) {
			$vote = Vote::getVoteByProfileId($pdo, $voteProfileId)->toArray();
			if($vote !== null) {
				$reply->data = $vote;
			}
			//verify vote value
		} else if(empty($voteValue) === false) {
			$vote = Vote::getVotebyVoteValue($pdo, $voteValue)->toArray();
			if($vote !== null) {
				$reply->data = $vote;
			}
		} else {
			throw new InvalidArgumentException("Incorrect parameters", 404);
		}
	} else if($method === "POST" || $method === "PUT") {
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->votePostId) === true) {
			throw (new \InvalidArgumentException("Vote is invalid, no associated post found", 405));
		}

		if($method === "POST") {
			// ensure the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("You must be logged in to vote", 403));
			}
			//does the vote exist?
			$vote = Vote::getVoteByPostIdAndProfileId($pdo, $requestObject->votePostId, $_SESSION["profile"]->getProfileId());
			//if vote does not exist, insert it
			if($vote === null) {
				$vote = new Vote($requestObject->votePostId, $_SESSION["profile"]->getProfileId(), null, $requestObject->voteValue);
				$vote->insert($pdo);
				$reply->message = "Vote successful";
			} else {
				//update vote
				$vote->setVoteValue($requestObject->voteValue);
				$vote->update($pdo);
				$reply->message = "Vote successful";
			}
		} else if($method === "PUT") {
			//enforce that the end user has a XSRF token.
			verifyXsrf();
			//grab the vote by its composite key
			$vote = Vote::getVoteByPostIdAndProfileId($pdo, $requestObject->votePostId, $requestObject->voteProfileId);
			if($vote === null) {
				throw (new RuntimeException("Vote does not exist"));
			}
			//update
			$vote->setVoteValue($requestObject->voteValue);
			$vote->update($pdo);
			// update reply
			$reply->message = "Vote updated";
			// if any other HTTP request is sent throw an exception
		} else {
			throw new \InvalidArgumentException("Invalid http request", 400);
		}
		// if any other HTTP request is sent throw an exception		 		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("Invalid http request", 400);
	}
	//catch any exceptions that is thrown and update the reply status and message		 	//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception)  {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null)
	unset($reply->data);
// encode and return reply to front end caller		 // encode and return reply to front end caller
echo json_encode($reply);
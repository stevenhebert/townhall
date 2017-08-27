<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

// inclusion of profile and district classes is strictly for testing purposes
use Edu\Cnm\Townhall\{District, Profile, Post};

/**
 * RESTapi for the Post class
 *
 * @author Steven Hebert <hebertsteven@me.com>
 *
 * Want this API to do the following:
 *
 ****** GET post(s) by postId "primary key"
 ****** GET a (all?) post(s) by postDistrictId
 ****** GET post(s) by postProfileId
 * GET post(s) by postParentId
 ****** GET post(s) by postContent
 * GET post(s) by postDate
 * GET all posts
 *
 * POST a new parent post
 * POST a non-parent "reply" post
 *
 * !== PUT "discussed no updating posts"
 *
 * DELETE a post by postId
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

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$postId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$postProfileId = filter_input(INPUT_GET, "postProfileId", FILTER_VALIDATE_INT);
	$postContent = filter_input(INPUT_GET, "postContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	// check if correct/needed ??????????????????????????????????????????????????????????????????????????????????????????
	$formattedSunriseDate = date_format(INPUT_GET, "Y-m-d H:i:s.u");
	$formattedSunsetDate = date_format(INPUT_GET, "Y-m-d H:i:s.u");
	//
	$postDistrictId = filter_input(INPUT_GET, "postDistrictId", FILTER_VALIDATE_INT);
	$postParentId = filter_input(INPUT_GET, "postParentId", FILTER_VALIDATE_INT);

	//make sure the id is valid for methods that require it
	if(($method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


	// handle the GET request - if the id is present then a* post is returned, otherwise all* posts are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific post or all posts and update reply
		if(empty($id) === false) {
			$post = Post::getPostByPostId($pdo, $id);
			if($post !== null) {
				$reply->data = $post;
			}
		} else if(empty($postProfileId) === false) {
			$posts = Post::getPostByPostProfileId($pdo, $postProfileId)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		} else if(empty($postContent) === false) {
			$posts = Post::getPostByPostContent($pdo, $postContent)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
//		} else if((empty($formattedSunriseDate) === true) || (empty($formattedSunsetDate) === true)) {
//				$posts = Post::getPostByPostDate($pdo,$formattedSunriseDate, $formattedSunsetDate);
//			if($posts !== null) {
//				$reply->data = $posts;
//			}
		} else if(empty($postDistrictId) === false) {
			$posts = Post::getPostByPostDistrictId($pdo, $postDistrictId)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		} else if(empty($postParentId) === false) {
			$posts = Post::getPostByPostParentId($pdo, $postParentId)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		} else {
			$posts = Post::getAllPosts($pdo)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}
		}
	} else if($method === "PUT" || $method === "POST") {

		//enforce that the user has an XSRF token
		verifyXsrf();

		$requestContent = file_get_contents("php://input");
		// Retrieves the JSON package that the front end sent, and stores it in $requestContent.
		// Here we are using file_get_contents("php://input") to get the request from the front end.
		//file_get_contents() is a PHP function that reads a file into a string.
		//The argument for the function, here, is "php://input".
		//This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This Line Then decodes the JSON package and stores that result in $requestObject

		//make sure post content is available (required field)
		if(empty($requestObject->postContent) === true) {
			throw(new \InvalidArgumentException ("post cannot be empty", 405));
		}

		/** make sure post date is accurate (optional field) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		if(empty($requestObject->postDate) === true) {
			$requestObject->postDate = null;
		}
		 **/

		//  make sure profileId is available
		if(empty($requestObject->postProfileId) === true) {
			throw(new \InvalidArgumentException ("no profileId found.", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the tweet to update
			$tweet = Tweet::getTweetByTweetId($pdo, $id);
			if($tweet === null) {
				throw(new RuntimeException("Tweet does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own tweet
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $tweet->getTweetProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this tweet", 403));
			}

			// update all attributes
			$tweet->setTweetDate($requestObject->tweetDate);
			$tweet->setTweetContent($requestObject->tweetContent);
			$tweet->update($pdo);

			// update reply
			$reply->message = "Tweet updated OK";

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post tweets", 403));
			}

			// create new tweet and insert into the database
			$tweet = new Tweet(null, $_SESSION["profile"]->getProfileId(), $requestObject->tweetContent, null);
			$tweet->insert($pdo);

			// update reply
			$reply->message = "Tweet created OK";
		}

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Tweet to be deleted
		$tweet = Tweet::getTweetByTweetId($pdo, $id);
		if($tweet === null) {
			throw(new RuntimeException("Tweet does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own tweet
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $tweet->getTweetProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this tweet", 403));
		}

		// delete tweet
		$tweet->delete($pdo);
		// update reply
		$reply->message = "Tweet deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
// update the $reply->status $reply->message
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
<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/postProfileId.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

// inclusion of profile and district classes is strictly for testing purposes
use Edu\Cnm\Townhall\{
	Profile, Post
};

/**
 * RESTapi for the Post class
 *
 * @author Steven Hebert <hebertsteven@me.com>
 *
 * Want this API to do the following:
 * GET post(s) by postId ($id) "primary key"
 * GET post(s) by postDistrictId
 * GET post(s) by postProfileId
 * GET post(s) by postParentId
 * GET post(s) by postContent
 * GET post(s) by postDate
 * GET all posts 
 * POST a new parent post
 * POST a non-parent "reply" post
 *
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

	$postId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//$id = filter_input(INPUT_GET, "postId", FILTER_VALIDATE_INT);
	$postProfileId = filter_input(INPUT_GET, "postProfileId", FILTER_VALIDATE_INT);
	$postContent = filter_input(INPUT_GET, "postContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$postDate = filter_input(INPUT_GET, "postDate");
	$sunriseDate = filter_input(INPUT_GET, "postDate");
	//$formattedSunriseDate = date_format($sunriseDate,"Y-m-d H:i:s.u");
	$sunsetDate = filter_input(INPUT_GET, "postDate");
	//$formattedSunriseDate = date_format($sunriseDate,"Y-m-d H:i:s.u");

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
		if(empty($postId) === false) {
			$post = Post::getPostByPostId($pdo, $postId);
			if($post !== null) {
				$postProfile = getPostProfile($post);
				$reply->data = $postProfile;
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
		} else if((empty($sunriseDate) === false) || (empty($sunsetDate) === false)) {
			$posts = Post::getPostByPostDate($pdo, $sunriseDate, $sunsetDate);
			if($posts !== null) {
				$postProfiles = getPostDateTime($posts);
				$reply->data = $postProfiles;
			}
		} else if(empty($postDistrictId) === false) {
			$posts = Post::getPostByPostDistrictId($pdo, $postDistrictId);
			if($posts !== null) {
				$postProfiles = getPostProfileName($posts);
				$reply->data = $postProfiles;
			}
		} else if(empty($postParentId) === false) {
			$posts = Post::getPostByPostParentId($pdo, $postParentId);
			if($posts !== null) {
				$postProfiles = getPostProfileName($posts);
				$reply->data = $postProfiles;
			}
		}
	} else if($method === "POST") {

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


		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException ("Sign in to create a post", 403));
		}

		//make sure post content is available (required field)
		if(empty($requestObject->postContent) === true) {
			throw(new \InvalidArgumentException ("You cannot make an empty post", 405));
		}

		// make sure that district id from profile matches the session district id
		if($_SESSION["profile"]->getProfileDistrictId() !== $requestObject->postDistrictId) {
			throw(new \InvalidArgumentException("Only residents of this district are allowed to create posts", 405));
		}

		// create the post and create the insert statement
		$post = new Post(null, $requestObject->postDistrictId, $requestObject->postParentId, $_SESSION["profile"]->getProfileId(), $requestObject->postContent);
		$post->insert($pdo);

		// post post/reply
		$reply->message = "Your post was successful";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request",418));
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
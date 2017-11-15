<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Townhall\{District};
/**
 * api for the District class
 *
 * @author Ryan Henson <hensojr@gmail.com>
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
	// mock a logged in user by forcing the session. This is only for testing purposes and should not be in the live code.
	// profileId of profile to use for testing,
//	$person = 2;
	// grab a profile by its profileId and add it to the session
//	$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, $person);
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	var_dump($id);
	$lat = filter_input(INPUT_GET, "lat", FILTER_VALIDATE_FLOAT);
	$long = filter_input(INPUT_GET, "long", FILTER_VALIDATE_FLOAT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("Id cannot be empty or negative", 405));
	}
	// handle GET request - if id is present, that district is returned, otherwise all districts are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//get a specific district or all districts and update reply
		if(empty($id) === false) {
			$district = District::getDistrictByDistrictId($pdo, $id);
			if($district !== null) {
				$reply->data = $district;
			}
		} else if(empty($lat and $long) === false) {
			$district = District::getDistrictByLongLat($pdo, $long, $lat);
			if($district !== null) {
				$reply->data = $district;
			}
		} else {
			$districts = District::getAllDistricts($pdo)->toArray();
			if($districts !== null) {
				$reply->data = $districts;
			}
		}
	}
	else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
		}
}
// update the $reply->status $reply->message
catch(\Exception | \TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);
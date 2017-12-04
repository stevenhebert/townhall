<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Townhall\Profile;

/**
 * API for checking profileRecoveryToken and resetting password
 *
 * @author Steven Hebert
 *
 * user follows link sent to email
 * posts token from email
 * posts email from email
 * check to see if token and email matches
 * if matches void profileRecoveryToken and accept users new password
 **/

// Check the session. If it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/townhall.ini");
	//check the HTTP method being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


	if($method === "POST") {
		//make sure the XSRF Token is valid
		verifyXsrf();
		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//never trust endtheworlduser
		$recovery = filter_var($requestObject->profileRecoveryToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);

		//verify that the user supplied an email
		if(empty($profileEmail) === true) {
			throw(new \InvalidArgumentException("Email address is required", 401));
		}
		//verify that the recovery token is not the wrong length
		if(strlen($recovery) !== 32) {
			throw(new InvalidArgumentException("Recovery token is invalid", 405));
		}
		//verify that the recovery token is not a string value of a hexadeciaml
		if(ctype_xdigit($recovery) === false) {
			throw (new \InvalidArgumentException("Recovery token is invalid", 405));
		}
		//verify that the user has supplied a new password
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException ("Password is required", 405));
		}
		//verify that the user can correctly type her password
		if(empty($requestObject->profilePasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Re-enter your password", 405));
		}
		//verify that the new password and password confirmation match
		if($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords do not match"));
		} else {
			//grab the profile from the database by the email provided
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		}
		//verify that the email is associated with a registered account
		if(empty($profile) === true) {
			throw(new \InvalidArgumentException("Account could not be verified", 401));
		}
		//verify that the recovery token was requested and matches
		if($profile->getProfileRecoveryToken() !== $recovery) {
			throw (new \InvalidArgumentException ("Account could not be verified", 403));
		}
		//verify that the recovery token is not older than 15 minutes
		$timenow = new DateTime();
		$timeexpires = $profile-> getProfileDateTime()-> add(new DateInterval('PT15M'));
		if($timenow >= $timeexpires) {
			throw (new \InvalidArgumentException("Recovery token has expired", 418));
		}

		//salt and hash the new password
		$newPasswordSalt = bin2hex(random_bytes(32));
		$newPasswordHash = hash_pbkdf2("sha512", $requestObject->profilePassword, $newPasswordSalt, 262144);

		//set new hash and salt
		$profile->setProfileHash($newPasswordHash);
		$profile->setProfileSalt($newPasswordSalt);

		//set users recovery token to null
		$profile->setProfileRecoveryToken(null);

		//update the profile in the database
		$profile->update($pdo);

		//congratulate user on her success
		$reply->message = "Your profile has been updated, you may now sign in";
	} else {
		//throw an exception if the HTTP request is not a POST
		throw(new InvalidArgumentException("Invalid HTTP method request", 403));
	}
	//update the reply objects status and message state variables if an exception or type exception was thrown;
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
//prepare and send the reply
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);
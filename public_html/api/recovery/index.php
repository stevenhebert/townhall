<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Townhall\Profile;

/**
 * API for checking forgot token and resetting password
 *
 * @author Steven Hebert
 *
 * user follows link sent to email
 * posts token from email
 * posts email from email
 * check to see if token and email matches
 * if matches void (forgot)token and accept users new password
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
	//sanitize input (never trust the end user)
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileRecoveryToken = filter_input(INPUT_GET, "profileRecoveryToken", FILTER_SANITIZE_STRING);

	if($method === "POST") {
		//make sure the XSRF Token is valid
		verifyXsrf();
		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//if the profile email is null throw an error
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("You must enter an email address.", 401));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}
		//if the forgot token is null throw an error
		if($requestObject->profileRecoveryToken() === true) {
			throw(new \InvalidArgumentException("You must enter your forgot token.", 401));
		}
		//if the forgot token is the wrong length throw an error
		if(strlen($recovery) !== 32) {
			throw(new InvalidArgumentException("token invalid", 405));
		}
		// if the forgot token is not a string value of a hexadeciaml throw an error
		if(ctype_xdigit($recovery) === false) {
			throw (new \InvalidArgumentException("token invalid", 405));
		} else {
			$profileRecoveryToken = filter_var($requestObject->profileRecoveryToken, FILTER_SANITIZE_STRING);
		}
		//grab the profile from the database by the email provided
		$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		if(empty($profile) === true) {
			throw(new \InvalidArgumentException("Account could not be verified.", 401));
		}
		//if the recovery token has expired => or does not match throw an error
		if($profile->getProfileRecoveryToken() !== $profileRecoveryToken) {
			throw (new \InvalidArgumentException ("Account could not be verified.", 403));
		}
		//verify that the user has entered a new password
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException ("A new password is required.", 405));
		}
		//verify that the confirm password is present
		if(empty($requestObject->profilePasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Re-enter your new password.", 405));
		}
		//verify that the new password and password confirmation match
		if($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords do not match"));
		}
			//salt and hash the new password
			$newPasswordSalt = bin2hex(random_bytes(16));
			$newPasswordHash = hash_pbkdf2("sha512", $requestObject->profilePassword, $newPasswordSalt, 262144);

			//set new hash and salt
			$profile->setProfileHash($newPasswordHash);
			$profile->setProfileSalt($newPasswordSalt);

			//set forgot to null
			$profile->setProfileRecoveryToken(null);

			//update the profile in the database
			$profile->update($pdo);

			//congratulate user on her success
			$reply->message = "profile password successfully updated";
		} else {
	//throw an exception if the HTTP request is not a POST
	throw(new InvalidArgumentException("Invalid HTTP method request", 403));
} 	//update the reply objects status and message state variables if an exception or type exception was thrown;
} catch (Exception $exception){
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError){
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
//prepare and send the reply
header("Content-type: application/json");
if($reply->data === null){
	unset($reply->data);
}
echo json_encode($reply);
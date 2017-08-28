<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Townhall\ {
	Profile
};
/**
 * API for Profile
 *
 * @author Leonora Sanchez
 * @version 1.0
 */
// verify the session; if not active, start it
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/townhall.ini");
	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profileUserName = filter_input(INPUT_GET, "profileUserName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//address, city firstname lastname state zip
	$profileAddress1 = filter_input(INPUT_GET, "profileAddress1", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileCity = filter_input(INPUT_GET, "profileCity", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileFirstName = filter_input(INPUT_GET, "profileFirstName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileLastName = filter_input(INPUT_GET, "profileLastName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileState = filter_input(INPUT_GET, "profileState", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileZip = filter_input(INPUT_GET, "profileZip", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$profileActivationToken = filter_input(INPUT_GET, "profileActivationToken", FILTER_SANITIZE_STRING);
	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();
		// gets a profile by content
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($profileName) === false) {
			$profile = Profile::getProfileByProfileUserName($pdo, $profileUserName);
			if($profile !== null) {
				$reply->data = $profile;
			}
		} elseif(empty($profileEmail) === false) {
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null) {
				$reply->data = $profile;
			}
		}




	} elseif($method === "PUT") {
		// enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $id) {
			throw(new \InvalidArgumentException("you are not allowed to access this profile", 403));
		}
		// decode the response from the frontend
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		// retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("profile does not exist", 404));
		}
		if(empty($requestObject->newPassword) === true) {
			// enforce that the XSRF token is present in the header
			verifyXsrf();
			// profile name
			if(empty($requestObject->profileUserName) === true) {
				throw(new \InvalidArgumentException("No profile name", 405));
			}
			// profile email is a required field
			if(empty($requestObject->profileEmail) === true) {
				throw(new \InvalidArgumentException("No profile email present", 405));
			}
			// profile address1 is a required field
			if(empty($requestObject->profileAddress1) === true) {
				throw(new \InvalidArgumentException("No profile address present", 405));
			}
			// profile city is a required field
			if(empty($requestObject->profileCity) === true) {
				throw(new \InvalidArgumentException("No profile city present", 405));
			}
			// profile first name is a required field
			if(empty($requestObject->profileFirstName) === true) {
				throw(new \InvalidArgumentException("No profile first name present", 405));
			}
			// profile last name is a required field
			if(empty($requestObject->profileLastName) === true) {
				throw(new \InvalidArgumentException("No profile last name present", 405));
			}
			// profile state is a required field
			if(empty($requestObject->profileState) === true) {
				throw(new \InvalidArgumentException("No profile state present", 405));
			}
			// profile zip is a required field
			if(empty($requestObject->profileZip) === true) {
				throw(new \InvalidArgumentException("No profile zip present", 405));
			}
			$profile->setProfileUserName($requestObject->profileName);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileAddress1($requestObject->profileAddress1);
			$profile->setProfileCity($requestObject->profileCity);
			$profile->setProfileLastName($requestObject->profileLastName);
			$profile->setProfileState($requestObject->profileState);
			$profile->setProfileZip($requestObject->profileZip);
			// update reply
			$reply->message = "Profile information updated successfully";
		}
		/**
		 * update the password if requested
		 */
		// enforce that the current password and new password are present
		if(empty($requestObject->profilePassword) === false && empty($requestObject->profileConfirmPassword) === false
			&& empty($requestObject->Confirm) === false) {
			// make sure of new password and enforce the password exists
			if($requestObject->newProfilePassword !== $requestObject->profileConfirmPassword) {
				throw(new RuntimeException("New passwords do not match", 401));
			}
			// hash the previous password
			$currentPasswordHash = hash_pbkdf2("sha512", $requestObject->currentProfilePassword,
				$profile->getProfileSalt(), 262144);
			// make sure the hash given by the end user matches what is in the database
			if($currentPasswordHash !== $profile->getProfileHash()) {
				throw(new \RuntimeException("Old password is incorrect", 401));
			}
			// salt and hash the new password and update the profile object
			$newPasswordSalt = bin2hex(random_bytes(16));
			$newPasswordHash = hash_pbkdf2("sha512", $requestObject->newProfilePassword, $newPasswordSalt, 262144);
			$profile->setProfileHash($newPasswordHash);
			$profile->setProfileSalt($newPasswordSalt);
		}
		// perform the actual update to the database and update the message
		$profile->update($pdo);
		$reply->message = "profile password successfully updated";

	} elseif($method === "DELETE") {
		// verify the XSRF token
		verifyXsrf();
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist"));
		}
		// enforce the user is signed in and trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}
		// delete the profile from the database
		$profile->delete($pdo);
		$reply->message = "Profile deleted";
	} else {
		throw(new InvalidArgumentException("Invalid HTTP request", 400));
	}
	// catch any exceptions that were thrown and update the status and message state variable fields
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
<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once dirname(__DIR__, 3) . "/php/lib/geocode.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Townhall\ {Profile, District};

/**
 * API for Profile
 *
 * @author Leonora Sanchez-Rees
 * @edited Steven Hebert
 * @version 1.1
 * profile only allows get and put.  User cannot delete profile.
 * Post is done in the sign-up API.
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
		}

	} elseif($method === "PUT") {
		// enforce the user is signed in and only trying to edit their own profile
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $id) {
			throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
		}
		// decode the response from the frontend
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		// retrieve the profile to be updated
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile does not exist", 404));
		}
		if(empty($requestObject->ProfilePassword) === true) {
			// enforce that the XSRF token is present in the header
			verifyXsrf();

			// profile username is a required field
			if(empty($requestObject->profileUserName) === true) {
				throw(new \InvalidArgumentException("Username is required", 405));
			}
			// profile email is a required field
			if(empty($requestObject->profileEmail) === true) {
				throw(new \InvalidArgumentException("Email is required", 405));
			}
			// profile first name is a required field
			if(empty($requestObject->profileFirstName) === true) {
				throw(new \InvalidArgumentException("First name is required", 405));
			}
			// profile last name is a required field
			if(empty($requestObject->profileLastName) === true) {
				throw(new \InvalidArgumentException("Last name is required", 405));
			}
			//if address2 empty set it too null
			if(empty($requestObject->profileAddress2) === true) {
				$requestObject->profileAddress2 = null;
			}

			$profile->setProfileUserName($requestObject->profileUserName);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileAddress2($requestObject->profileAddress2);
			$profile->setProfileFirstName($requestObject->profileFirstName);
			$profile->setProfileLastName($requestObject->profileLastName);

			// update reply
			$reply->message = "Your profile has been updated";
		}

		/**
		 * change the password if requested
		 */
		// enforce that the current password and new password are present
		if(empty($requestObject->profilePassword) === false && empty($requestObject->profileConfirmPassword) === false && empty($requestObject->Confirm) === false) {

			// make sure of new password and enforce the password exists
			if($requestObject->newProfilePassword !== $requestObject->profileConfirmPassword) {
				throw(new RuntimeException("Passwords do not match", 401));
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
			$reply->message = "Your profile has been updated";
		}

		/**
		 * update the address and district if user changes address
		 */

		if(empty($requestObject->profileAddress1) === false && empty($requestObject->profileCity) === false && empty($requestObject->profileState) === false && empty($requestObject->profileZip) === false) {

			//profile address1 is a required field
			if(empty($requestObject->profileAddress1) === true) {
				throw(new \InvalidArgumentException ("Address is required", 401));
			}
			//profile city is a required field
			if(empty($requestObject->profileCity) === true) {
				throw(new \InvalidArgumentException ("City is required", 401));
			}

			//profile state is a required field
			if(empty($requestObject->profileState) === true) {
				throw(new \InvalidArgumentException ("State is required", 401));
			}

			//profile zip is a required field
			if(empty($requestObject->profileZip) === true) {
				throw(new \InvalidArgumentException ("Zipcode is required", 401));
			}

			$latLongObject = getLatLongByAddress($requestObject->profileAddress1);
			$district = District::getDistrictByLongLat($pdo, $latLongObject->long, $latLongObject->lat);

			//make sure district is not null
			if($district == Null) {
				$districtId = 10;
			}
			else {
				$districtId = $district->getDistrictId();
			}

			//update the profile object
			$profile->setProfileDistrictId($districtId);
			$profile->setProfileAddress1($requestObject->profileAddress1);
			$profile->setProfileCity($requestObject->profileCity);
			$profile->setProfileState($requestObject->profileState);
			$profile->setProfileZip($requestObject->profileZip);

			$reply->message = "Your profile has been updated";
		}

		// perform the actual update to the database and update the message
		$profile->update($pdo);

	} //don't allow delete
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
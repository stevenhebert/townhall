<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/geocode.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Townhall\{Profile, District};

/**
 * api for signing up to ABQ Townhall
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
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "POST") {
		//decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//profile at first name is a required field
		if(empty($requestObject->profileAddress1) === true) {
			throw(new \InvalidArgumentException ("No profile address", 405));
		}
		//profile city is a required field
		if(empty($requestObject->profileCity) === true) {
			throw(new \InvalidArgumentException ("No profile city", 405));
		}
		//profile at first name is a required field
		if(empty($requestObject->profileFirstName) === true) {
			throw(new \InvalidArgumentException ("No profile first name", 405));
		}
		//profile last name is a required field
		if(empty($requestObject->profileLastName) === true) {
			throw(new \InvalidArgumentException ("No profile last name", 405));
		}
		//profile state is a required field
		if(empty($requestObject->profileState) === true) {
			throw(new \InvalidArgumentException ("No profile state", 405));
		}
		//profile username is a required field
		if(empty($requestObject->profileUserName) === true) {
			throw(new \InvalidArgumentException ("No profile username", 405));
		}
		//profile zip is a required field
		if(empty($requestObject->profileZip) === true) {
			throw(new \InvalidArgumentException ("No profile zip", 405));
		}
		//profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException ("No profile email present", 405));
		}
		//verify that profile password is present
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}
		//verify that the confirm password is present
		if(empty($requestObject->profilePasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}
		//if phone is empty set it too null
		if(empty($requestObject->profileAddress2) === true) {
			$requestObject->profileAddress2 = null;
		}
		//make sure the password and confirm password match
		if ($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords do not match"));
		}
		$latLongObject = getLatLongByAddress($requestObject->profileAddress1);
		$district = District::getDistrictByLongLat($pdo, $latLongObject->long, $latLongObject->lat);

		//make sure district is not null
		if($district == null) {
			$districtId = 10;
		}
		else {
			$districtId = $district->getDistrictId();
		}

		$salt = bin2hex(random_bytes(32));
		$hash = hash_pbkdf2("sha512", $requestObject->profilePassword, $salt, 262144);
		$profileActivationToken = bin2hex(random_bytes(16));
		//create the profile object and prepare to insert into the database
		$profile = new Profile(null, $districtId, $profileActivationToken, $requestObject->profileAddress1, $requestObject->profileAddress2, $requestObject->profileCity, null, $requestObject->profileEmail, $requestObject->profileFirstName, $hash, $requestObject->profileLastName,null, null, $salt, $requestObject->profileState, $requestObject->profileUserName, $requestObject->profileZip);
		//insert the profile into the database
		$profile->insert($pdo);
		//compose the email message to send with th activation token
		$messageSubject = "ABQ Town Hall Account Activation";
		//building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
		//make sure URL is /public_html/api/activation/$activation
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
		//create the path
		$urlglue = $basePath . "activation/" . $profileActivationToken;
		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		//compose message to send with email
		$message = <<< EOF
<h2>Welcome to ABQ Town Hall!</h2>
<p>Please click the link below to activate your account.</p>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;
		//create swift email
		$swiftMessage = new Swift_Message();
		// attach the sender to the message
		// this takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["admin@abqtownhall.com" => "ABQ Town Hall"]);
		/**
		 * attach recipients to the message
		 * notice this is an array that can include or omit the recipient's name
		 * use the recipient's real name where possible;
		 * this reduces the probability of the email is marked as spam
		 */
		//define who the recipient is
		$recipients = [$requestObject->profileEmail];
		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);
		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);
		/**
		 * attach the message to the email
		 * set two versions of the message: a html formatted version and a filter_var()ed version of the message, plain text
		 * notice the tactic used is to display the entire $confirmLink to plain text
		 * this lets users who are not viewing the html content to still access the link
		 */
		//attach the html version fo the message
		$swiftMessage->setBody($message, "text/html");
		//attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");
		/**
		 * send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
		 * this default may or may not be available on all web hosts; consult their documentation/support for details
		 * SwiftMailer supports many different transport methods; SMTP was chosen because it's the most compatible and has the best error handling
		 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
		 **/
		//setup smtp
		$smtp = new Swift_SmtpTransport(
			"localhost", 25);
		$mailer = new Swift_Mailer($smtp);
		//send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);
		/**
		 * the send method returns the number of recipients that accepted the Email
		 * so, if the number attempted is not the number accepted, this is an Exception
		 **/
		if($numSent !== count($recipients)) {
			// the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
			throw(new RuntimeException("Unable to send email",400));
		}
		// update reply
		$reply->message = "Thanks for creating an ABQ Town Hall account, check your email to complete your registration";
	} else {
		throw (new InvalidArgumentException("Invalid http request", 418));
	}
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);
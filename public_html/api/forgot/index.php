<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Townhall\{Profile};

/**
 * API for handling account forgot
 *
 * @author Steven Hebert
 *
 * user has forgotten password
 * API sends forgot link via email
 * forgot token is given a short life span
 * timely user can reset her password by supplying token and email
 **/

//start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/townhall.ini");
	//determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//If method is post handle the sign in logic
	if($method === "POST") {
		//make sure the XSRF Token is valid
		verifyXsrf();
		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check to make sure the email field is not empty
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Email address is required", 401));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}

		//grab the profile from the database by the email provided
		$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		if(empty($profile) === true) {
			throw(new \InvalidArgumentException("An account recovery request has been sent to your email", 418));
			//intentionally obscure
		}

		//set recovery token
		$profileRecoveryToken = bin2hex(random_bytes(16));
		$profile->setProfileRecoveryToken($profileRecoveryToken);

		//update the profile in the database
		$profile->update($pdo);

		//compose the email message to send with the recovery url
		$messageSubject = "ABQ Town Hall Account Recovery";

		//building the recovery link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
		//make sure URL is recovery/$profileRecoveryToken
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
		//create the path
		$urlglue = $basePath . "recovery/" . $profileRecoveryToken;
		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
		//compose message to send with email
		$message = <<< EOF
<h2>Your request to recover your ABQ Town Hall account</h2>
<p>Click the link below to reset your password.</p>
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
		$reply->message = "An account recovery link has been sent to your email, it is valid for 15 minutes";
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
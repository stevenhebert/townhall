<?php

namespace Edu\Cnm\Townhall;

/**
 * Etsy data design project class for profile
 * @author Ryan Henson <hensojr@gmail.com>
 * @version 1.0.0
 **/
class profile {
	/**
	 * id for this profile; this is the primary key
	 * @var int $profileId
	 **/
	private $profileId;
	/**
	 * activation toke for the profile
	 * @var string $profileActivationToken
	 **/
	private $profileActivationToken;
	/**
	 * handle associated with profile
	 * @var string $profileAtHandle
	 **/
	private $profileAtHandle;
	/**
	 * email address associated with profile
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * password hash associated with profile
	 * @var string $profileHash
	 **/
	private $profileHash;
	/**
	 * phone number associated with profile
	 * @var string $profilePhone
	 **/
	private $profilePhone;
	/**
	 * salt used for password hash on associated profile
	 * @var string $profileSalt
	 **/
	private $profileSalt;

	/**
	 * constructor for this profile
	 *
	 * @param int|null $newProfileId of this profile or null if a new user
	 * @param string $newProfileActivationToken of the user profile
	 * @param string $newProfileAtHandle of the user profile
	 * @param string $newProfileEmail of the user profile
	 * @param string $newProfileHash of the user profile
	 * @param string $newProfilePhone of the user profile
	 * @param string $newProfileSalt of the user profile
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProfileId, string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileEmail, string $newProfileHash, string $newProfilePhone, string $newProfileSalt) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAtHandle($newProfileAtHandle);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfilePhone($newProfilePhone);
			$this->setProfileSalt($newProfileSalt);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for profileId
	 *
	 * @return int|null value of productId
	 **/
	public function getProfileId(): int {
		return ($this->profileId);
	}

	/**
	 * mutator method for profileId
	 *
	 * @param int|null $newProfileId new value of product id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(?int $newProfileId): void {
		//if product id is null immediately return it
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}
		// verify the  profileId is positive
		if($newProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}
		// convert and store the profileId
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for profileActivationToken
	 *
	 * @return string value of profileActivationToken
	 **/
	public function getProfileActivationToken(): string {
		return ($this->profileActivationToken);
	}
	/**
	 * mutator method for profileActivationToken
	 *
	 * @param string $newProfileActivationToken new value of productDescription
	 * @throws \InvalidArgumentException if $newProfileActivationToken is not a string or insecure
	 * @throws \TypeError if $newProfileActivationToken is not a string
	 **/
	public function setProfileActivationToken(string $newProfileActivationToken): void {
		// verify the profileActivationToken is secure
		$newProfileActivationToken = trim($newProfileActivationToken);
		$newProfileActivationToken = filter_var($newProfileActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileActivationToken) === true) {
			throw(new \InvalidArgumentException("profile activation token is empty or insecure"));
		}
		// verify the profileActivationToken will fit in the database
		if(strlen($newProfileActivationToken) > 32) {
			throw(new \RangeException("profile activation token description content too large"));
		}
		// store the profileActivationToken
		$this->profileActivationToken = $newProfileActivationToken;
	}
	/**
	 * accessor method for profileAtHandle
	 *
	 * @return string value of profifeAtHandle
	 **/
	public function getProfileAtHandle(): string {
		return ($this->profileAtHandle);
	}
	/**
	 * mutator method for profileAtHandle
	 *
	 * @param string $newProfileAtHandle new value of profileAtHandle
	 * @throws \InvalidArgumentException if $newProfileAtHandle is not a string or insecure
	 * @throws \TypeError if $newProfileAtHandle is not a string
	 **/
	public function setProfileAtHandle(string $newProfileAtHandle): void {
		// verify the profileAtHandle is secure
		$newProfileAtHandle = trim($newProfileAtHandle);
		$newProfileAtHandle = filter_var($newProfileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAtHandle) === true) {
			throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
		}
		// verify the profileAtHandle will fit in the database
		if(strlen($newProfileAtHandle) > 32) {
			throw(new \RangeException("profile at table description content too large"));
		}
		// store the profileAtHandle
		$this->profileActivationToken = $newProfileAtHandle;
	}
	/**
	 * accessor method for profileEmail
	 *
	 * @return string value of profileEmail
	 **/
	public function getProfileEmail(): string {
		return ($this->profileEmail);
	}
	/**
	 * mutator method for profileEmail
	 *
	 * @param string $newProfileEmail new value of profileEmail
	 * @throws \InvalidArgumentException if $newProfileEmail is not a string or insecure
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail): void {
		// verify the profileEmail is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}
		// verify the profileEmailwill fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email content too large"));
		}
		// store the profileEmail
		$this->profileEmail = $newProfileEmail;
	}
	/**
	 * accessor method for profileHash
	 *
	 * @return string value of profileHash
	 **/
	public function getProfileHash(): string {
		return ($this->profileHash);
	}
	/**
	 * mutator method for profileHash
	 *
	 * @param string $newProfileHash new value of profileHash
	 * @throws \InvalidArgumentException if $newProfileHash is not a string or insecure
	 * @throws \TypeError if $newProfileHash is not a string
	 **/
	public function setProfileHash(string $newProfileHash): void {
		// verify the profileHash is secure
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = filter_var($newProfileHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile hash is empty or insecure"));
		}
		// verify the profileHash will fit in the database
		if(strlen($newProfileHash) > 128) {
			throw(new \RangeException("profile hash content too large"));
		}
		// store the profileHash
		$this->profileHash = $newProfileHash;
	}
	/**
	 * accessor method for profilePhone
	 *
	 * @return string value of profilePhone
	 **/
	public function getProfilePhone(): string {
		return ($this->profilePhone);
	}
	/**
	 * mutator method for profilePhone
	 *
	 * @param string $newProfilePhone new value of profilePhone
	 * @throws \InvalidArgumentException if $newProfilePhone is not a string or insecure
	 * @throws \TypeError if $newProfilePhone is not a string
	 **/
	public function setProfilePhone(string$newProfilePhone): void {
		// verify the profilePhone is secure
		$newProfilePhone = trim($newProfilePhone);
		$newProfilePhone = filter_var($newProfilePhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfilePhone) === true) {
			throw(new \InvalidArgumentException("profile phone is empty or insecure"));
		}
		// verify the profilePhone will fit in the database
		if(strlen($newProfilePhone) > 32) {
			throw(new \RangeException("profile phone content too large"));
		}
		// store the profilePhone
		$this->profilePhone = $newProfilePhone;
	}
	/**
	 * accessor method for profileSalt
	 *
	 * @return string value of profileSalt
	 **/
	public function getProfileSalt(): string {
		return ($this->profileSalt);
	}
	/**
	 * mutator method for profileSalt
	 *
	 * @param string $newProfileSalt new value of profileSalt
	 * @throws \InvalidArgumentException if $newProfileSalt is not a string or insecure
	 * @throws \TypeError if $newProfileSaltis not a string
	 **/
	public function setProfileSalt(string$newProfileSalt): void {
		// verify the profileSalt is secure
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = filter_var($newProfileSalt, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileSalt) === true) {
			throw(new \InvalidArgumentException("profile phone is empty or insecure"));
		}
		// verify the profileSalt will fit in the database
		if(strlen($newProfileSalt) > 64) {
			throw(new \RangeException("profile phone content too large"));
		}
		// store the profileSalt
		$this->profileSalt = $newProfileSalt;
	}
	/**
	 * inserts this profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// enforce the profileId is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new profile"));
		}

		// create query template
		$query = "INSERT INTO profile(profileActivationToken, profileAtHandle, profileEmail, profileHash, profilePhone, profileSalt) VALUES(:profileActivationToken, :profileAtHandle, :profileEmail, :profileHas, :profilePhone, :profileSalt)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);

		// update the null profileId with what mySQL just gave us
		$this->profileId = intval($pdo->lastInsertId());
	}
	/**
	 * deletes this profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// enforce the profileId is not null (i.e., don't delete a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new \PDOException("unable to delete a profile that does not exist"));
		}
		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}
	/**
	 * updates this profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// enforce the profileId is not null (i.e., don't update a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new \PDOException("unable to update a profile that does not exist"));
		}
		// create query template
		$query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileAtHandle = :profileAtHandle, profileEmail = :profileEmail, profileHash = :profileHash, profilePhone = :profileHash, profileSalt = :profileSalt WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);
	}
	/**
	 * gets the Profile by profileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileId profile id to search for
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, int $profileId) : ?Profile {
		// sanitize the profileId before searching
		if($profileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}

		// create query template
		$query = "SELECT profileId, profileAtHandle, profileEmail, profileHash, profilePhone FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);

		// grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"], $row["profilePhone"], $row["profileSalt"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}
}

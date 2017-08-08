<?php

namespace Edu\Cnm\Townhall;

/**
 * town hall capstone project class profile
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
	 * district id for this profile; this is a foreign key
	 * @var int $profileDistrictId
	 **/
	private $profileDistrictId;
	/**
	 * activation token for the profile
	 * @var string $profileActivationToken
	 **/
	private $profileActivationToken;
	/**
	 * first address field associated with profile
	 * @var string $profileAddress1
	 **/
	private $profileAddress1;
	/**
	 * second address field associated with profile
	 * @var string $profileAddress2
	 **/
	private $profileAddress2;
	/**
	 * city associated with profile
	 * @var string $profileCity
	 **/
	private $profileCity;
	/**
	 * email associated with profile
	 * @var string $profileEmail
	 */
	private $profileEmail;
	/**
	 * first name associated with profile
	 * @var string $profileFirstName
	 */
	private $profileFirstName;
	/**
	 * password hash associated with profile
	 * @var string $profileHash
	 **/
	private $profileHash;
	/**
	 * last name associated with profile
	 * @var string $profileLastName
	 **/
	private $profileLastName;
	/**
	 * whether or not profile is for representative
	 * @var tinyint $profileRepresentative
	 **/
	private $profileRepresentative;
	/**
	 * salt used for password hash on associated profile
	 * @var string $profileSalt
	 **/
	private $profileSalt;
	/**
	 * state associated with profile
	 * @var string $profileState
	 **/
	private $profileState;
	/**
	 * username associated with profile
	 * @var string $profileUserName
	 **/
	private $profileProfileUserName;
	/**
	 * zip associated with profile
	 * @var string $profileZip
	 **/
	private $profileZip;
	/**
	 * constructor for this profile
	 *
	 * @param int|null $newProfileId of this profile or null if a new user
	 * @param int $newProfileDistrictId of this profile
	 * @param string $newProfileActivationToken of the user profile
	 * @param string $newProfileAddress1 of the user profile
	 * @param string $newProfileAddress2 of the user profile
	 * @param string $newProfileCity of the user profile
	 * @param string $newProfileEmail of the user profile
	 * @param string $newProfileFirstName of the user profile
	 * @param string $newProfileHash of the user profile
	 * @param string $newProfileLastName of the user profile
	 * @param int $newProfileRepresentative of the user profile
	 * @param string $newProfileSalt of the user profile
	 * @param string $newProfileState of the user profile
	 * @param string $newProfileUserName of the user profile
	 * @param string $newProfileZip of the user profile
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProfileId, string $newProfileDistrictId, string $newProfileActivationToken, string $newProfileAddress1, string $newProfileAddress2, string $newProfileCity, string $newProfileEmail, string $newProfileFirstName, string $newProfileHash, string $newProfileLastName, int $newProfileRepresentative, string $newProfileSalt, string $newProfileState, string $newProfileUserName, string $newProfileZip) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileDistrictId($newProfileDistrictId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAddress1($newProfileAddress1);
			$this->setProfileAddress2($newProfileAddress2);
			$this->setProfileCity($newProfileCity);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileFirstName($newProfileFirstName);
			$this->setProfileHash($newProfileHash);
			$this->setProfileLastName($newProfileLastName);
			$this->setProfileRepresentative($newProfileRepresentative);
			$this->setProfileSalt($newProfileSalt);
			$this->profileSalt($newProfileState);
			$this->setProfileZip($newProfileZip);
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
	 * accessor method for profileDistrictId
	 *
	 * @return int|null value of profileDistrictId
	 **/
	public function getProfileDistrictId(): int {
		return ($this->profileDistrictId);
	}

	/**
	 * mutator method for profileDistrictId
	 *
	 * @param int|null $newProfileDistrictId new value of profile district id
	 * @throws \RangeException if $newProfileDistrictId is not positive
	 * @throws \TypeError if $newProfileDistrictId is not an integer
	 **/
	public function setProfileDistrictId(?int $newProfileDistrictId): void {
		//if product id is null immediately return it
		if($newProfileDistrictId === null) {
			$this->profileDistrictId = null;
			return;
		}
		// verify the  profileId is positive
		if($newProfileDistrictId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}
		// convert and store the profileId
		$this->profileDistrictId = $newProfileDistrictId;
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
	 * accessor method for profileAddress1
	 *
	 * @return string value of profileAddress1
	 **/
	public function getProfileAddress1(): string {
		return ($this->profileAddress1);
	}

	/**
	 * mutator method for profileAddress1
	 *
	 * @param string $newProfileAddress1 new value of profile
	 * @throws \InvalidArgumentException if $newProfileAddress1 is not a string or insecure
	 * @throws \TypeError if $newProfileAddress1 is not a string
	 **/
	public function setProfileAddress1(string $newProfileAddress1): void {
		// verify the profileAddress1 is secure
		$newProfileAddress1 = trim($newProfileAddress1);
		$newProfileAddress1 = filter_var($newProfileAddress1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAddress1) === true) {
			throw(new \InvalidArgumentException("profile address is empty or insecure"));
		}
		// verify the profileAddress1 fit in the database
		if(strlen($newProfileAddress1) > 64) {
			throw(new \RangeException("profile address too large"));
		}
		// store the profileAddress1
		$this->profileAddress1 = $newProfileAddress1;
	}

	/**
	 * accessor method for profileAddress2
	 *
	 * @return string value of profileAddress2
	 **/
	public function getProfileAddress2(): string {
		return ($this->profileAddress2);
	}

	/**
	 * mutator method for profileAddress2
	 *
	 * @param string $newProfileAddress2 new value of profile
	 * @throws \InvalidArgumentException if $newProfileAddress2 is not a string or insecure
	 * @throws \TypeError if $newProfileAddress2 is not a string
	 **/
	public function setProfileAddress2(string $newProfileAddress2): void {
		// verify the profileAddress1 is secure
		$newProfileAddress2 = trim($newProfileAddress2);
		$newProfileAddress2 = filter_var($newProfileAddress2, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAddress1) === true) {
			throw(new \InvalidArgumentException("profile address is empty or insecure"));
		}
		// verify the profileAddress2 fit in the database
		if(strlen($newProfileAddress2) > 64) {
			throw(new \RangeException("profile address content too large"));
		}
		// store the profileAddress2
		$this->profileAddress2 = $newProfileAddress2;
	}

	/**
	 * accessor method for profileCity
	 *
	 * @return string value of profileCity
	 **/
	public function getProfileCity(): string {
		return ($this->profileCity);
	}

	/**
	 * mutator method for profileCity
	 *
	 * @param string $newProfileCity new value of profile
	 * @throws \InvalidArgumentException if $newProfileCity is not a string or insecure
	 * @throws \TypeError if $newProfileCity is not a string
	 **/
	public function setProfileCity(string $newProfileCity): void {
		// verify the profileCity is secure
		$newProfileCity = trim($newProfileCity);
		$newProfileCity = filter_var($newProfileCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileCity) === true) {
			throw(new \InvalidArgumentException("profile city is empty or insecure"));
		}
		// verify the profileCity fit in the database
		if(strlen($newProfileCity) > 64) {
			throw(new \RangeException("profile city content too large"));
		}
		// store the profileCity
		$this->profileCity = $newProfileCity;
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
	 * accessor method for profileUserName
	 *
	 * @return string value of profileUserName
	 **/
	public function getProfileUserName(): string {
		return ($this->profileProfileUserName);
	}

	/**
	 * mutator method for profileUserName
	 *
	 * @param string $newProfileUserName new value of profileUserName
	 * @throws \InvalidArgumentException if $newProfileUserName is not a string or insecure
	 * @throws \TypeError if $newProfileUserName is not a string
	 **/
	public function setProfileUserName(string $newProfileUserName): void {
		// verify the profileUserName is secure
		$newProfileUserName = trim($newProfileUserName);
		$newProfileUserName = filter_var($newProfileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUserName) === true) {
			throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
		}
		// verify the profileUserName will fit in the database
		if(strlen($newProfileUserName) > 32) {
			throw(new \RangeException("profile at table description content too large"));
		}
		// store the profileUserName
		$this->profileUserName = $newProfileUserName;
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

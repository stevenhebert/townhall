v<?php

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
	 * accessor method for profileFirstName
	 *
	 * @return string value of profileFirstName
	 **/
	public function getProfileFirstName(): string {
		return ($this->profileFirstName);
	}

	/**
	 * mutator method for profileFirstName
	 *
	 * @param string $newProfileFirstName new value of profile
	 * @throws \InvalidArgumentException if $newProfileFirstName is not a string or insecure
	 * @throws \TypeError if $newProfileFirstName is not a string
	 **/
	public function setProfileFirstName(string $newProfileFirstName): void {
		// verify the profileFirstName is secure
		$newProfileFirstName = trim($newProfileFirstName);
		$newProfileFirstName = filter_var($newProfileFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileFirstName) === true) {
			throw(new \InvalidArgumentException("profile first name is empty or insecure"));
		}
		// verify the profileFirstName fit in the database
		if(strlen($newProfileFirstName) > 64) {
			throw(new \RangeException("profile first name content too large"));
		}
		// store the profileFirstName
		$this->profileFirstName = $newProfileFirstName;
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
	 * accessor method for profileLastName
	 *
	 * @return string value of profileLastName
	 **/
	public function getProfileLastName(): string {
		return ($this->profileLastName);
	}

	/**
	 * mutator method for profileLastName
	 *
	 * @param string $newProfileLastName new value of profile
	 * @throws \InvalidArgumentException if $newProfileLastName is not a string or insecure
	 * @throws \TypeError if $newProfileLastName is not a string
	 **/
	public function setProfileLastName(string $newProfileLastName): void {
		// verify the profileLastName is secure
		$newProfileLastName = trim($newProfileLastName);
		$newProfileLastName = filter_var($newProfileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLastName) === true) {
			throw(new \InvalidArgumentException("profile last name is empty or insecure"));
		}
		// verify the profileLastName fit in the database
		if(strlen($newProfileLastName) > 64) {
			throw(new \RangeException("profile last name content too large"));
		}
		// store the profileLastName
		$this->profileLastName = $newProfileLastName;
	}

	/**
	 * accessor method for profileRepresentative
	 *
	 * @return int|null value of productId
	 **/
	public function getProfileRepresentative(): int {
		return ($this->profileRepresentative);
	}

	/**
	 * mutator method for profileRepresentative
	 *
	 * @param int|null $newProfileRepresentative new value of product id
	 * @throws \RangeException if $newProfileRepresentative is not zero
	 * @throws \TypeError if $newProfileRepresentative is not an integer
	 **/
	public function setProfileRepresentative(?int $newProfileRepresentative): void {
		//if product representative is null immediately return it
		if($newProfileRepresentative === null) {
			$this->profileRepresentative = null;
			return;
		}
		// verify the  profileRepresentative is 0 if not NULL
		if($newProfileRepresentative = 0) {
			throw(new \RangeException("profile representative is not zero"));
		}
		// convert and store the profileId
		$this->profileRepresentative = $newProfileRepresentative;
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
	 * @throws \TypeError if $newProfileSalt is not a string
	 **/
	public function setProfileSalt(string$newProfileSalt): void {
		// verify the profileSalt is secure
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = filter_var($newProfileSalt, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileSalt) === true) {
			throw(new \InvalidArgumentException("profile salt is empty or insecure"));
		}
		// verify the profileSalt will fit in the database
		if(strlen($newProfileSalt) > 64) {
			throw(new \RangeException("profile salt content too large"));
		}
		// store the profileSalt
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * accessor method for profileState
	 *
	 * @return string value of profileState
	 **/
	public function getProfileState(): string {
		return ($this->profileState);
	}

	/**
	 * mutator method for profileState
	 *
	 * @param string $newProfileState new value of profileState
	 * @throws \InvalidArgumentException if $newProfileState is not a string or insecure
	 * @throws \TypeError if $newProfileState is not a string
	 **/
	public function setProfileState(string$newProfileState): void {
		// verify the profileState is secure
		$newProfileState = trim($newProfileState);
		$newProfileState = filter_var($newProfileState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileState) === true) {
			throw(new \InvalidArgumentException("profile state is empty or insecure"));
		}
		// verify the profileState will fit in the database
		if(strlen($newProfileState) > 2) {
			throw(new \RangeException("profile state content too large"));
		}
		// store the profileState
		$this->profileState = $newProfileState;
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
	 * accessor method for profileZip
	 *
	 * @return string value of profileZip
	 **/
	public function getProfileZip(): string {
		return ($this->profileProfileZip);
	}

	/**
	 * mutator method for profileZip
	 *
	 * @param string $newProfileZip new value of profileZip
	 * @throws \InvalidArgumentException if $newProfileZip is not a string or insecure
	 * @throws \TypeError if $newProfileZip is not a string
	 **/
	public function setProfileZip(string $newProfileZip): void {
		// verify the profileZip is secure
		$newProfileZip = trim($newProfileZip);
		$newProfileZip	 = filter_var($newProfileZip	, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileZip) === true) {
			throw(new \InvalidArgumentException("profile zip is empty or insecure"));
		}
		// verify the profileZip will fit in the database
		if(strlen($newProfileZip) > 10) {
			throw(new \RangeException("profile zip too large"));
		}
		// store the profileZip
		$this->profileZip = $newProfileZip;
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
		$query = "INSERT INTO profile(profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileEmail, profileFirstName, profileHash, profileLastName, profileRepresentative, profileSalt, profileState, profileUserName, profileZip) VALUES(:profileDistrictId, :profileActivationToken, :profileAddress1, :profileAddress2, :profileCity, :profileEmail, :profileFirstName, :profileHash, :profileLastName, :profileRepresentative, :profileSalt, :profileState, :profileUserName, :profileZip)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileDistricId" => $this->profileDistrictId, "profileActivationToken" => $this->profileActivationToken, "profileAddress1" => $this->profileAddress1, "profileAddress2" => $this->profileAddress2, "profileCity" => $this->profileCity,"profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName,"profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName,"profileRepresentative" => $this->profileRepresentative, "profileSalt" => $this->profileSalt, "profileState" => $this->profileState, "profileZip" => $this->profileZip];
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
		$query = "INSERT INTO profile(profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileEmail, profileFirstName, profileHash, profileLastName, profileRepresentative, profileSalt, profileState, profileUserName, profileZip) VALUES(:profileDistrictId, :profileActivationToken, :profileAddress1, :profileAddress2, :profileCity, :profileEmail, :profileFirstName, :profileHash, :profileLastName, :profileRepresentative, :profileSalt, :profileState, :profileUserName, :profileZip)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileDistricId" => $this->profileDistrictId, "profileActivationToken" => $this->profileActivationToken, "profileAddress1" => $this->profileAddress1, "profileAddress2" => $this->profileAddress2, "profileCity" => $this->profileCity,"profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName,"profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName,"profileRepresentative" => $this->profileRepresentative, "profileSalt" => $this->profileSalt, "profileState" => $this->profileState, "profileZip" => $this->profileZip];
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
		$query = "INSERT INTO profile(profileId, profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileEmail, profileFirstName, profileHash, profileLastName, profileRepresentative, profileSalt, profileState, profileUserName, profileZip) VALUES(:profileDistrictId, :profileActivationToken, :profileAddress1, :profileAddress2, :profileCity, :profileEmail, :profileFirstName, :profileHash, :profileLastName, :profileRepresentative, :profileSalt, :profileState, :profileUserName, :profileZip)";
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
				$profile = new Profile($row["profileId"], $row["profileDistrictId"], $row["profileActivationToken"], $row["profileAddress1"], $row["profileAddress2"], $row["profileCity"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileRepresentative"], $row["profileSalt"],$row["profileState"], $row["profileUserName"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

}

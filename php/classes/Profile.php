<?php

namespace Edu\Cnm\Townhall;

require_once("autoload.php");

/**
 * town hall capstone project class profile
 * @author Ryan Henson <hensojr@gmail.com>
 * @version 1.0.0
 **/
class Profile implements \JsonSerializable {
	use ValidateDate;
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
	 * timestamp when the profile was created. automagically added by the database
	 * @var \DateTime $profileDateTime
	 **/
	private $profileDateTime;
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
	 * recovery token for the profile
	 * @var string $profileRecoveryToken
	 **/
	private $profileRecoveryToken;
	/**
	 * whether or not profile is for representative
	 * @var int $profileRepresentative
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
	private $profileUserName;
	/**
	 * zip associated with profile
	 * @var string $profileZip
	 **/
	private $profileZip;

	/**
	 * constructor for the profile class
	 *
	 * @param int | null $newProfileId of this profile or null if a new user
	 * @param int $newProfileDistrictId of this profile
	 * @param string | null $newProfileActivationToken of the user profile
	 * @param string $newProfileAddress1 of the user profile
	 * @param string | null $newProfileAddress2 of the user profile
	 * @param string $newProfileCity of the user profile
	 * @param \DateTime | null $newProfileDateTime timestamp of the profile
	 * @param string $newProfileEmail of the user profile
	 * @param string $newProfileFirstName of the user profile
	 * @param string $newProfileHash of the user profile
	 * @param string $newProfileLastName of the user profile
	 * @param string | null $newProfileRecoveryToken of the user profile
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
	public function __construct(?int $newProfileId, int $newProfileDistrictId, ?string $newProfileActivationToken, string $newProfileAddress1, ?string $newProfileAddress2, string $newProfileCity, $newProfileDateTime = null, string $newProfileEmail, string $newProfileFirstName, string $newProfileHash, string $newProfileLastName, ?string $newProfileRecoveryToken, ?int $newProfileRepresentative, string $newProfileSalt, string $newProfileState, string $newProfileUserName, string $newProfileZip) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileDistrictId($newProfileDistrictId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAddress1($newProfileAddress1);
			$this->setProfileAddress2($newProfileAddress2);
			$this->setProfileCity($newProfileCity);
			$this->setProfileDateTime($newProfileDateTime);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileFirstName($newProfileFirstName);
			$this->setProfileHash($newProfileHash);
			$this->setProfileLastName($newProfileLastName);
			$this->setProfileRecoveryToken($newProfileRecoveryToken);
			$this->setProfileRepresentative($newProfileRepresentative);
			$this->setProfileSalt($newProfileSalt);
			$this->setprofileState($newProfileState);
			$this->setProfileUserName($newProfileUserName);
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
	 * @return int|null value of profileId
	 **/
	public function getProfileId(): int {
		return ($this->profileId);
	}

	/**
	 * mutator method for profileId
	 *
	 * @param int|null $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(?int $newProfileId): void {
		//if profile id is null immediately return it
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
		//if profile id is null immediately return it
		if($newProfileDistrictId === null) {
			$this->profileDistrictId = null;
			return;
		}
		// verify the  profileDistrictId is positive
		if($newProfileDistrictId <= 0) {
			throw(new \RangeException("profile district id is not positive"));
		}
		// convert and store the profileId
		$this->profileDistrictId = $newProfileDistrictId;
	}

	/**
	 * accessor method for profileActivationToken
	 *
	 * @return string value of profileActivationToken
	 **/
	public function getProfileActivationToken(): ?string {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for profileActivationToken
	 *
	 * @param string $newProfileActivationToken new value of profileDescription
	 * @throws \InvalidArgumentException if $newProfileActivationToken is not a string or insecure
	 * @throws \TypeError if $newProfileActivationToken is not a string
	 **/
	public function setProfileActivationToken(?string $newProfileActivationToken): void {
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}

		// verify the profileActivationToken is secure
		$newProfileActivationToken = trim($newProfileActivationToken);
		$newProfileActivationToken = filter_var($newProfileActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileActivationToken) === true) {
			throw(new \InvalidArgumentException("profile activation token is empty or insecure"));
		}
		// verify the profileActivationToken will fit in the database
		if(strlen($newProfileActivationToken) > 32) {
			throw(new \RangeException("profile activation token is too long"));
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
			throw(new \InvalidArgumentException("address is empty or insecure"));
		}
		// verify the profileAddress1 fit in the database
		if(strlen($newProfileAddress1) > 64) {
			throw(new \RangeException("address can be no more than 64 characters"));
		}
		// store the profileAddress1
		$this->profileAddress1 = $newProfileAddress1;
	}

	/**
	 * accessor method for profileAddress2
	 * @param string|null $newProfileAddress2 new value of profile address 2
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
	public function setProfileAddress2(?string $newProfileAddress2): void {
		//if address 2 is null immediately return it
		if($newProfileAddress2 === null) {
			$this->profileAddress2 = null;
			return;
		}
		// verify the profileAddress2 is secure
		$newProfileAddress2 = trim($newProfileAddress2);
		$newProfileAddress2 = filter_var($newProfileAddress2, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAddress2) === true) {
			throw(new \InvalidArgumentException("address is empty or insecure"));
		}
		// verify the profileAddress2 fit in the database
		if(strlen($newProfileAddress2) > 64) {
			throw(new \RangeException("address can be no more than 64 characters"));
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
		// verify the profile city is secure
		$newProfileCity = trim($newProfileCity);
		$newProfileCity = filter_var($newProfileCity, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileCity) === true) {
			throw(new \InvalidArgumentException("city is empty or insecure"));
		}
		// verify the profile city fits in the database
		if(strlen($newProfileCity) > 64) {
			throw(new \RangeException("name of city can be no more than 64 characters, please abbreviate"));
		}
		// store the profile city
		$this->profileCity = $newProfileCity;
	}

	/*
 	* accessor method for profileDateTime
 	*
 	* @return \DateTime value of profileDateTime when created
 	**/
	public function getProfileDateTime(): \DateTime {
		return ($this->profileDateTime);
	}

	/**
	 * mutator method for profileDateTime
	 *
	 * @param \DateTime |string |null $newProfileDateTime dateTime profile was created as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newProfileDateTime is not a valid object or string
	 * @throws \RangeException if $newProfileDateTime is a date that does not exist
	 *
	 **/
	public function setProfileDateTime($newProfileDateTime = null): void {
		//base case:  if the date is null, wait for mySQL
		if($newProfileDateTime === null) {
			$this->profileDateTime = null;
			return;
		}

		//store the profile date using the ValidateDate trait
		try {
			$newProfileDateTime = self::validateDateTime($newProfileDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileDateTime = $newProfileDateTime;
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
		// verify the profile email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("email is empty or insecure"));
		}
		// verify the profile email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("email can be no more than 64 characters"));
		}
		// store the profile email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile first name
	 *
	 * @return string value of profile first name
	 **/
	public function getProfileFirstName(): string {
		return ($this->profileFirstName);
	}

	/**
	 * mutator method for profile first name
	 *
	 * @param string $newProfileFirstName new value of profile
	 * @throws \InvalidArgumentException if $newProfileFirstName is not a string or insecure
	 * @throws \TypeError if $newProfileFirstName is not a string
	 **/
	public function setProfileFirstName(string $newProfileFirstName): void {
		// verify the profile first name is secure
		$newProfileFirstName = trim($newProfileFirstName);
		$newProfileFirstName = filter_var($newProfileFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileFirstName) === true) {
			throw(new \InvalidArgumentException("first name is empty or insecure"));
		}
		// verify the profile first name fits in the database
		if(strlen($newProfileFirstName) > 64) {
			throw(new \RangeException("first name can be no more than 64 characters"));
		}
		// store the profileFirstName
		$this->profileFirstName = $newProfileFirstName;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string value of profileHash
	 **/
	public function getProfileHash(): string {
		return ($this->profileHash);
	}

	/**
	 * mutator method for profile hash
	 *
	 * @param string $newProfileHash new value of profileHash
	 * @throws \InvalidArgumentException if $newProfileHash is not a string or insecure
	 * @throws \TypeError if $newProfileHash is not a string
	 **/
	public function setProfileHash(string $newProfileHash): void {
		// verify the profile hash is secure
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = filter_var($newProfileHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile hash is empty or insecure"));
		}
		// verify the profile hash will fit in the database
		if(strlen($newProfileHash) > 128) {
			throw(new \RangeException("profile hash content too large"));
		}
		// store the profile hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for profile last name
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
		// verify the profile last name is secure
		$newProfileLastName = trim($newProfileLastName);
		$newProfileLastName = filter_var($newProfileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLastName) === true) {
			throw(new \InvalidArgumentException("last name is empty or insecure"));
		}
		// verify the profile last name fits in the database
		if(strlen($newProfileLastName) > 64) {
			throw(new \RangeException("last name can be no more than 64 characters"));
		}
		// store the profile last name
		$this->profileLastName = $newProfileLastName;
	}

	/**
	 * accessor method for profileRecoveryToken
	 *
	 * @return string value of profileRecoveryToken
	 **/
	public function getProfileRecoveryToken(): ?string {
		return ($this->profileRecoveryToken);
	}

	/**
	 * mutator method for profileRecoveryToken
	 *
	 * @param string $newProfileRecoveryToken new value of profileRecoveryToken
	 * @throws \InvalidArgumentException if $newProfileRecoveryToken is not a string or insecure
	 * @throws \TypeError if $newProfileRecoveryToken is not a string
	 **/
	public function setProfileRecoveryToken(?string $newProfileRecoveryToken): void {
		if($newProfileRecoveryToken === null) {
			$this->profileRecoveryToken = null;
			return;
		}

		// verify the profileRecoveryToken is secure
		$newProfileRecoveryToken = trim($newProfileRecoveryToken);
		$newProfileRecoveryToken = filter_var($newProfileRecoveryToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileRecoveryToken) === true) {
			throw(new \InvalidArgumentException("profile recovery token is empty or insecure"));
		}
		// verify the profileActivationToken will fit in the database
		if(strlen($newProfileRecoveryToken) > 32) {
			throw(new \RangeException("profile recovery token is too long"));
		}
		// store the profileRecoveryToken
		$this->profileRecoveryToken = $newProfileRecoveryToken;
	}

	/**
	 * accessor method for profile representative
	 *
	 * @return int|null value of profileRepresentative
	 **/
	public function getProfileRepresentative(): ?int {
		if($this->profileRepresentative === null) {
			return $this->profileDistrictId = null;
		}
		return ($this->profileRepresentative);
	}

	/**
	 * mutator method for profile representative
	 *
	 * @param int|null $newProfileRepresentative new value of profile id
	 * @throws \RangeException if $newProfileRepresentative is not zero
	 * @throws \TypeError if $newProfileRepresentative is not an integer
	 **/
	public function setProfileRepresentative(?int $newProfileRepresentative): void {
		//if profile representative is null immediately return it
		if($newProfileRepresentative === null) {
			$this->profileRepresentative = null;
			return;
		}
		// verify the  profile representative is 0 if not NULL
		if($newProfileRepresentative !== 1) {
			throw(new \RangeException("profile representative must be true"));
		}
		// convert and store the profile representative
		$this->profileRepresentative = $newProfileRepresentative;
	}

	/**
	 * accessor method for profile salt
	 *
	 * @return string value of profileSalt
	 **/
	public function getProfileSalt(): string {
		return ($this->profileSalt);
	}

	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt new value of profileSalt
	 * @throws \InvalidArgumentException if $newProfileSalt is not a string or insecure
	 * @throws \TypeError if $newProfileSalt is not a string
	 **/
	public function setProfileSalt(string $newProfileSalt): void {
		// verify the profile salt is secure
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = filter_var($newProfileSalt, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileSalt) === true) {
			throw(new \InvalidArgumentException("profile salt is empty or insecure"));
		}
		// verify the profileS salt will fit in the database
		if(strlen($newProfileSalt) > 64) {
			throw(new \RangeException("too salty"));
		}
		// store the profile salt
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
	 * mutator method for profile state
	 *
	 * @param string $newProfileState new value of profileState
	 * @throws \InvalidArgumentException if $newProfileState is not a string or insecure
	 * @throws \TypeError if $newProfileState is not a string
	 **/
	public function setProfileState(string $newProfileState): void {
		// verify the profile state is secure
		$newProfileState = trim($newProfileState);
		$newProfileState = filter_var($newProfileState, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileState) === true) {
			throw(new \InvalidArgumentException("state is empty or insecure"));
		}
		// verify the profile state will fit in the database
		if(strlen($newProfileState) > 2) {
			throw(new \RangeException("please use the state abbreviation"));
		}
		// store the profile state
		$this->profileState = $newProfileState;
	}

	/**
	 * accessor method for profile user name
	 *
	 * @return string value of profileUserName
	 **/
	public function getProfileUserName(): string {
		return ($this->profileUserName);
	}

	/**
	 * mutator method for profile user name
	 *
	 * @param string $newProfileUserName new value of profileUserName
	 * @throws \InvalidArgumentException if $newProfileUserName is not a string or insecure
	 * @throws \TypeError if $newProfileUserName is not a string
	 **/
	public function setProfileUserName(string $newProfileUserName): void {
		// verify the profile user name is secure
		$newProfileUserName = trim($newProfileUserName);
		$newProfileUserName = filter_var($newProfileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUserName) === true) {
			throw(new \InvalidArgumentException("username is empty or insecure"));
		}
		// verify the profile user name will fit in the database
		if(strlen($newProfileUserName) > 32) {
			throw(new \RangeException("username can be no more than 32 characters"));
		}
		// store the profile user name
		$this->profileUserName = $newProfileUserName;
	}

	/**
	 * accessor method for profileZip
	 *
	 * @return string value of profileZip
	 **/
	public function getProfileZip(): string {
		return ($this->profileZip);
	}

	/**
	 * mutator method for profile zip
	 *
	 * @param string $newProfileZip new value of profileZip
	 * @throws \InvalidArgumentException if $newProfileZip is not a string or insecure
	 * @throws \TypeError if $newProfileZip is not a string
	 **/
	public function setProfileZip(string $newProfileZip): void {
		// verify the profile zip is secure
		$newProfileZip = trim($newProfileZip);
		$newProfileZip = filter_var($newProfileZip, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileZip) === true) {
			throw(new \InvalidArgumentException("zip is empty or insecure"));
		}
		// verify the profile zip will fit in the database
		if(strlen($newProfileZip) > 10) {
			throw(new \RangeException("zip can be no more than 10 characters"));
		}
		// store the profile zip
		$this->profileZip = $newProfileZip;
	}

	/**
	 * inserts this profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// enforce the profileId is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new \PDOException("not a new account"));
		}
		// enforce the profileEmail is unique
		$checkEmail = Profile::getProfileByProfileEmail($pdo, $this->profileEmail);
		if(empty($checkEmail) === false) {
			throw(new \PDOException("email is associated an active account"));
		}
		// create query template
		$query = "INSERT INTO profile(profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip) VALUES(:profileDistrictId, :profileActivationToken, :profileAddress1, :profileAddress2, :profileCity, :profileEmail, :profileFirstName, :profileHash, :profileLastName, :profileRecoveryToken, :profileRepresentative, :profileSalt, :profileState, :profileUserName, :profileZip)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["profileDistrictId" => $this->profileDistrictId, "profileActivationToken" => $this->profileActivationToken, "profileAddress1" => $this->profileAddress1, "profileAddress2" => $this->profileAddress2, "profileCity" => $this->profileCity, "profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName, "profileRecoveryToken" => $this->profileRecoveryToken, "profileRepresentative" => $this->profileRepresentative, "profileSalt" => $this->profileSalt, "profileState" => $this->profileState, "profileUserName" => $this->profileUserName, "profileZip" => $this->profileZip];

		$statement->execute($parameters);

		// update the null profileId with what mySQL just gave us
		$this->profileId = intval($pdo->lastInsertId());

		// generate a timestamp
		$tempProfile = Profile::getProfileByProfileId($pdo, $this->profileId);
		$this->setProfileDateTime($tempProfile->getProfileDateTime());
	}

	/**
	 * deletes this profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// enforce the profileId is not null (i.e., don't delete a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new \PDOException("profile that does not exist, unable to delete"));
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
	public function update(\PDO $pdo): void {
		// enforce the profile id is not null (i.e., don't update a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new \PDOException("profile that does not exist, unable to update"));
		}
		// create query template
		$query = "UPDATE profile SET profileDistrictId = :profileDistrictId, profileActivationToken = :profileActivationToken, profileAddress1 = :profileAddress1, profileAddress2 = :profileAddress2, profileCity = :profileCity, profileEmail = :profileEmail, profileFirstName = :profileFirstName, profileHash = :profileHash, profileLastName = :profileLastName, profileRecoveryToken = :profileRecoveryToken, profileRepresentative = :profileRepresentative, profileSalt = :profileSalt, profileState = :profileState, profileUserName = :profileUserName, profileZip = :profileZip WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId, "profileDistrictId" => $this->profileDistrictId, "profileActivationToken" => $this->profileActivationToken, "profileAddress1" => $this->profileAddress1, "profileAddress2" => $this->profileAddress2, "profileCity" => $this->profileCity, "profileEmail" => $this->profileEmail, "profileFirstName" => $this->profileFirstName, "profileHash" => $this->profileHash, "profileLastName" => $this->profileLastName, "profileRecoveryToken" => $this->profileRecoveryToken, "profileRepresentative" => $this->profileRepresentative, "profileSalt" => $this->profileSalt, "profileState" => $this->profileState, "profileUserName" => $this->profileUserName, "profileZip" => $this->profileZip];
		$statement->execute($parameters);

		// update the auto generated timestamp
		$tempProfile = Profile::getProfileByProfileId($pdo, $this->profileId);
		$this->setProfileDateTime($tempProfile->getProfileDateTime());
	}

	/**
	 * GET profile by profileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileId profile id to search for
	 * @return null Profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, int $profileId): ?Profile {
		// sanitize the profileId before searching
		if($profileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		// create query template
		$query = "SELECT profileId, profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileDateTime, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip FROM profile WHERE profileId = :profileId";
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
				$profile = new Profile($row["profileId"], $row["profileDistrictId"], $row["profileActivationToken"], $row["profileAddress1"], $row["profileAddress2"], $row["profileCity"], $row["profileDateTime"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileRecoveryToken"], $row["profileRepresentative"], $row["profileSalt"], $row["profileState"], $row["profileUserName"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * GET an array of profiles by profileDateTime
	 *
	 * @param \PDO $pdo connection object
	 * @param \DateTime $sunriseProfileDate beginning date of search
	 * @param \DateTime $sunsetProfileDate ending date of search
	 * @return \SplFixedArray of profiles found
	 * @throws \PDOException error when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @throws \InvalidArgumentException if either sun dates are in the wrong format
	 **/
	public static function getProfileByProfileDate(\PDO $pdo, $sunriseProfileDate, $sunsetProfileDate): \SplFixedArray {
		//enforce both dates are present
		if((empty($sunriseProfileDate) === true) || (empty($sunsetProfileDate) === true)) {
			throw(new \InvalidArgumentException("dates are empty or insecure"));
		}

		//ensure both dates are in the correct format and are secure
		try {
			$sunriseProfileDate = self::validateDateTime($sunriseProfileDate);
			$sunsetProfileDate = self::validateDateTime($sunsetProfileDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT profileId, profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileDateTime, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip FROM profile WHERE profileDateTime >= :sunriseProfileDate AND profileDateTime <= :sunsetProfileDate";
		$statement = $pdo->prepare($query);

		//format the dates so that mySQL can use them
		$formattedSunriseDate = $sunriseProfileDate->format("Y-m-d H:i:s.u");
		$formattedSunsetDate = $sunsetProfileDate->format("Y-m-d H:i:s.u");


		$parameters = ["sunriseProfileDate" => $formattedSunriseDate, "sunsetProfileDate" => $formattedSunsetDate];
		$statement->execute($parameters);

		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileDistrictId"], $row["profileActivationToken"], $row["profileAddress1"], $row["profileAddress2"], $row["profileCity"], $row["profileDateTime"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileRecoveryToken"], $row["profileRepresentative"], $row["profileSalt"], $row["profileState"], $row["profileUserName"], $row["profileZip"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}


	/**
	 * GET profileDistrictId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \int $profileDistrictId to search by
	 * @return \SplFixedArray SplFixedArray of profiles found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileDistrictId(\PDO $pdo, int $profileDistrictId): \SPLFixedArray {
		// sanitize the district id before searching
		if($profileDistrictId <= 0) {
			throw(new \RangeException("profile district id must be positive"));
		}
		// create query template
		$query = "SELECT profileId, profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileDateTime, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip FROM profile WHERE profileDistrictId = :profileDistrictId";
		$statement = $pdo->prepare($query);

		// bind the profile district id to the place holder in the template
		$parameters = ["profileDistrictId" => $profileDistrictId];
		$statement->execute($parameters);

		// build an array of profiles
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileDistrictId"], $row["profileActivationToken"], $row["profileAddress1"], $row["profileAddress2"], $row["profileCity"], $row["profileDateTime"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileRecoveryToken"], $row["profileRepresentative"], $row["profileSalt"], $row["profileState"], $row["profileUserName"], $row["profileZip"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

	/**
	 * GET profileActivationToken
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileActivationToken content to search for
	 *
	 * @return Profile|null Profile found or null if not found
	 *
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByActivationToken(\PDO $pdo, string $profileActivationToken): ?Profile {
		// sanitize the description before searching
		$profileActivationToken = trim($profileActivationToken);
		$profileActivationToken = filter_var($profileActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileActivationToken) === true) {
			throw(new \PDOException("profile activation token is invalid"));
		}
		// create query template
		$query = "SELECT profileId, profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileDateTime, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);
		// grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileDistrictId"], $row["profileActivationToken"], $row["profileAddress1"], $row["profileAddress2"], $row["profileCity"], $row["profileDateTime"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileRecoveryToken"], $row["profileRepresentative"], $row["profileSalt"], $row["profileState"], $row["profileUserName"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * gets the profile by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileEmail content to search for
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail): ?Profile {
		// sanitize the description before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("profile email is invalid"));
		}
		// create query template
		$query = "SELECT profileId, profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileDateTime, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);
		// grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileDistrictId"], $row["profileActivationToken"], $row["profileAddress1"], $row["profileAddress2"], $row["profileCity"], $row["profileDateTime"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileRecoveryToken"], $row["profileRepresentative"], $row["profileSalt"], $row["profileState"], $row["profileUserName"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * GET profileRecoveryToken
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileRecoveryToken content to search for
	 *
	 * @return Profile|null Profile found or null if not found
	 *
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByRecoveryToken(\PDO $pdo, string $profileRecoveryToken): ?Profile {
		// sanitize the description before searching
		$profileRecoveryToken = trim($profileRecoveryToken);
		$profileRecoveryToken = filter_var($profileRecoveryToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileRecoveryToken) === true) {
			throw(new \PDOException("profile recovery token is invalid"));
		}
		// create query template
		$query = "SELECT profileId, profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileDateTime, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip FROM profile WHERE profileRecoveryToken = :profileRecoveryToken";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileRecoveryToken" => $profileRecoveryToken];
		$statement->execute($parameters);
		// grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileDistrictId"], $row["profileActivationToken"], $row["profileAddress1"], $row["profileAddress2"], $row["profileCity"], $row["profileDateTime"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileRecoveryToken"], $row["profileRepresentative"], $row["profileSalt"], $row["profileState"], $row["profileUserName"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * GET the profile by username
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileUserName content to search for
	 * @return Profile|null Profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileUserName(\PDO $pdo, string $profileUserName): ?Profile {
		// sanitize the description before searching
		$profileUserName = trim($profileUserName);
		$profileUserName = filter_var($profileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileUserName) === true) {
			throw(new \PDOException("profile user name is invalid"));
		}
		// create query template
		$query = "SELECT profileId, profileDistrictId, profileActivationToken, profileAddress1, profileAddress2, profileCity, profileDateTime, profileEmail, profileFirstName, profileHash, profileLastName, profileRecoveryToken, profileRepresentative, profileSalt, profileState, profileUserName, profileZip FROM profile WHERE profileUserName = :profileUserName";
		$statement = $pdo->prepare($query);
		// bind the profile id to the place holder in the template
		$parameters = ["profileUserName" => $profileUserName];
		$statement->execute($parameters);
		// grab the profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileDistrictId"], $row["profileActivationToken"], $row["profileAddress1"], $row["profileAddress2"], $row["profileCity"], $row["profileDateTime"], $row["profileEmail"], $row["profileFirstName"], $row["profileHash"], $row["profileLastName"], $row["profileRecoveryToken"], $row["profileRepresentative"], $row["profileSalt"], $row["profileState"], $row["profileUserName"], $row["profileZip"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
	/*
* needed to add the microsecond to the profileDateTime field
*
* @param $fields object to process profileDateTime
*
*/
	public function jsonSerialize() {
		$fields = get_object_vars($this);

		//format the data so that the front end can consume it
		//$fields["profileDateTime"] = round(floatval($this->profileDateTime->format("U.u")) * 1000);

		unset($fields["profileHash"]);
		unset($fields["profileSalt"]);

		return($fields);
	}
}
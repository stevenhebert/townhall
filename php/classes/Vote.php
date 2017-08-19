<?php

namespace Edu\Cnm\TownHall;

require_once("autoload.php");

/**
 * townhall capstone project class Vote
 * @author Michelle Allen <mbojorquez2007@gmail.com>
 * @version 1.0.0
 * */
class Vote {
	 use ValidateDate;
	/**
	 * id for this Post; this and profileId is the primary key
	 * @var int $votePostId
	 **/
	private $votePostId;
	/**
	 * profile id for this profile; this is part of the primary
	 * @var int $voteProfileId
	 **/
	private $voteProfileId;
	/**
	 * timestamp of the post
	 * @var \DateTime $voteDateTime
	 **/
	private $voteDateTime;
	/**
	 * value of the vote
	 * @var int $voteValue
	 * */
	private $voteValue;

	/**
	 *
	 * constructor for this vote
	 *
	 * @param\null int $newPostVoteId for this vote or null if a new postVote
	 * @param int $newVoteProfileId for the Profile that voted on this post
	 * @param \DateTime|string|null $newVoteDateTime date and time vote was sent or null if set to current date and time
	 * @param int $newVoteValue value for this vote
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newVotePostId, int $newVoteProfileId, $newVoteDateTime = null, int $newVoteValue = null) {
		try {
			$this->setVotePostId($newVotePostId);
			$this->setVoteProfileId($newVoteProfileId);
			$this->setVoteDateTime($newVoteDateTime);
			$this->setVoteValue($newVoteValue);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for votePostId
	 *
	 * @return int|null value of votePostId
	 **/
	public function getVotePostId(): int {
		return ($this->votePostId);
	}

	/**
	 * mutator method for votePostId
	 *
	 * @param int|null $newPostVoteId new value of newPostVoteId
	 * @throws \RangeException if $newPostVoteId is not positive
	 * @throws \TypeError if $newPostVoteId is not an integer
	 **/
	public function setVotePostId(?int $newVotePostId): void {
		//if votePostId is null immediately return it
		if($newVotePostId === null) {
			$this->votePostId = null;
			return;
		}

		// verify the votePostId is positive
		if($newVotePostId <= 0) {
			throw(new \RangeException("votePostId is not positive"));
		}


		// convert and store the vote post id
		$this->votePostId = $newVotePostId;
	}

	/**
	 * accessor method for voteProfileId
	 *
	 * @return int value of voteProfileId
	 **/

	public function getVoteProfileId(): int {
		return ($this->voteProfileId);
	}

	/**
	 * mutator method for voteProfileId
	 *
	 * @param int $newVoteProfileId new value of voteProfileId
	 * @throws \RangeException if $newVoteProfileId is not positive
	 * @throws \TypeError if $newVoteProfileId is not an integer
	 **/
	public function setVoteProfileId(int $newVoteProfileId): void {

		// verify the voteProfileId is positive
		if($newVoteProfileId <= 0) {
			throw(new \RangeException("voteProfileId is not positive"));
		}

		// convert and store the voteProfileId
		$this->voteProfileId = $newVoteProfileId;
	}

	/**
	 * accessor method for voteDateTime
	 *
	 * @return \ DateTime value of voteDateTime
	 **/
	public function getVoteDateTime(): \DateTime {
		return ($this->voteDateTime);
	}

	/**
	 * mutator method for vote date/time
	 *
	 * @param \DateTime|string|null $newVoteDateTime vote date time as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newVoteDatetime is not a valid object or
	 * string
	 * @throws \RangeException if $newVoteDateTime is a date that does not exist
	 **/
	public function setVoteDateTime($newVoteDateTime = null): void {
		// base case: if the date is null, use the current date and time
		if($newVoteDateTime === null) {
			$this->voteDateTime = null;
			return;
		}

		// store the like date using the ValidateDate trait
		try {
			$newVoteDateTime = self::validateDate($newVoteDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->voteDateTime = $newVoteDateTime;
	}

	/**
	 * accessor method for voteValue
	 *
	 * @return int|null value of voteValue
	 **/
	public function getVoteValue(): int {
		return ($this->voteValue);
	}

	/**
	 * mutator method for voteValue
	 *
	 * @param int|null $newVoteValue new value of newVoteValue
	 * @throws \RangeException if $newVoteValue is -1 || 1
	 * @throws \TypeError if $newVoteValue is not an integer
	 **/
	public function setVoteValue(?int $newVoteValue): void {
		//if votevalue is null immediately return it
		if($newVoteValue === null) {
			$this->voteValue = null;
			return;
		}

		// verify the value is -1 || 1
		if($newVoteValue <= 0) {
			throw(new \RangeException("voteValue is not -1 || 1"));
		}


		// convert and store the voteValue
		$this->voteValue = $newVoteValue;
	}


	/**
	 * inserts this VoteDateTime into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		//enforce the postVoteId is null (i.e, don't insert a vote that already exist)
		if($this->votePostId !== null) {
			throw(new \PDOException("not a new vote"));
		}
		// create query template
		$query = "INSERT INTO vote (votePostId, voteProfileId, voteDateTime, voteValue) VALUES(:votePostId, :voteProfileId, :voteDateTime, :voteValue)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$formattedDateTime = $this->voteDateTime->format("Y-m-d H:i:s");
		$parameters = ["votePostId" => $this->votePostId, "voteProfileId" => $this->voteProfileId, "voteDateTime" => $formattedDateTime, "voteValue" => $this->voteValue];
		$statement->execute($parameters);

		// update the null votePostId with what mySql just gave us
		$this->votePostId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this vote from mySQL
	 *
	 * @param\PDO $pdo PDO connection object
	 * @throws \PDOException when my SQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		//enforce the votePostId is not null
		if($this->votePostId === null) {
			throw(new \PDOException("unable to delete a vote that does not exist "));
		}

// create query template
		$query = "DELETE FROM vote WHERE votePostId = : votePostId and voteProfileId = :voteProfileId";
		$statement = $pdo->prepare($query);

//bind the member variables to the place holder in the template
		$parameters = ["votePostId" => $this->votePostId, "voteProfileId" => $this->voteProfileId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Vote in mySQL
	 *
	 * @parm \PDO $pdo PDO connect object
	 * @throws \TypeError if $pdo is not a PDO connect object
	 **/
	public function update(\PDO $pdo): void {
		// enforce the postVoteId is not null (i.e., don't update a vote that hasn't been inserted)
		if($this->votePostId === null) {
			throw(new \PDOException("unable to update a vote that does not exist"));
		}

		//create query temple
		$query = "UPDATE vote SET votePostId = : votePostId, voteProfileId = : voteProfileId, voteDateTime = : voteDateTime, voteValue = : voteValue";
		$statement = $pdo
			->prepare($query);

//bind the member variables to the place holders in the template
		$formattedDateTime = $this->voteDateTime->format("Y-m-d H:i:s");
		$parameters = ["votePostId" => $this->votePostId, "voteProfileId" => $this->voteProfileId, "voteDateTime" => $formattedDateTime, "voteValue" => $this->voteValue];
		$statement->execute($parameters);
	}


	/**gets the vote by postId and profileId, primary key
	 *
	 * @param \PDO $pdo connection object
	 * @param int $votePostId to search for
	 * @param int $voteProfileId to search for
	 * @return Vote | null Vote found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVoteByPostIdProfileId(\PDO $pdo, int $votePostId, $voteProfileId): ?Vote {
		//sanitize the PostId before searching
		if($votePostId <= 0) {
			throw(new \PDOException("post Id is not positive"));
		}
		if($voteProfileId <= 0 ) {
			throw(new \PDOException("profile Id is not positive"));
		}

		//create query template
		$query = "SELECT votePostId, voteProfileId, voteDateTime, voteValue FROM vote WHERE votePostId = :votePostId and voteProfileId = :voteProfileId";
		$statement = $pdo->prepare($query);

		//bind the post id to the place holder in the template
		$parameters = ["votePostId" => $votePostId, "voteProfileId" => $voteProfileId];
		$statement->execute($parameters);

		//grab post from mySQL
		try {
			$vote = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$vote = new Vote($row["votePostId"], $row["voteProfileId"], $row["voteDateTime"], $row["voteValue"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($vote);
	}

	/**gets the vote by votePostId
	 *
	 * @param \PDO $pdo connection object
	 * @param int $PostId to search for
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVoteByPostId(\PDO $pdo, int $votePostId): \SplFixedArray {
		//sanitize the postDistrictId before searching
		if($votePostId <= 0) {
			throw(new \PDOException("vote Post Id is not positive"));
		}

		//create query template
		$query = "SELECT votePostId, voteProfileId, voteDateTime, voteValue FROM vote WHERE votePostId = :votePostId";
		$statement = $pdo->prepare($query);

		//bind the post district id to the place holder in the template
		$parameters = ["votePostId" => $votePostId];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$vote = new Vote($row["votePostId"], $row["voteProfileId"], $row["voteDateTime"], $row["voteValue"]);
				$votes[$votes->key()]= $vote;
				$vote->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($votes);
	}


	/**gets the vote by voteProfileId
	 *
	 * @param \PDO $pdo connection object
	 * @param int $postProfileId to search for
	 * @return \SplFixedArray SplFixedArray of Profile found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVoteByProfileId(\PDO $pdo, int $voteProfileId): \SplFixedArray {
		//sanitize the voteProfileId before searching
		if($voteProfileId <= 0) {
			throw(new \PDOException("vote profile Id is not positive"));
		}

		//create query template
		$query = "SELECT votePostId, voteProfileId, voteDateTime, voteValue FROM vote WHERE voteProfileId = :voteProfileId";
		$statement = $pdo->prepare($query);

		//bind the post district id to the place holder in the template
		$parameters = ["voteProfileId" => voteProfileId];
		$statement->execute($parameters);

		//build an array of votes
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$vote = new Vote($row["votePostId"], $row["voteProfileId"], $row["voteDateTime"], $row["voteValue"]);
				$votes[$votes->key()]= $vote;
				$vote->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($votes);
	}

	/**
	 * gets an array of votes based on its dates and time
	 *
	 * @param \PDO $pdo connect object
	 * @param \DateTime $sunsetVoteDateTime ending date to search for
	 * @param \DateTime $sunsetVoteDateTime ending date to search for
	 * @return \SplFixedArray of votes found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @throws \InvalidArgumentException if either sun dates are in the wrong format
	 */
	public static function getVoteByVoteDateTime(\PDO $pdo, \DateTime $sunriseVoteDateTime, \DateTime $sunsetVoteDateTime): \SplFixedArray {
		//enforce both date are present
		if((empty ($sunriseVoteDateTime) === true) || (empty($sunsetVoteDateTime) === true)) {
			throw (new \InvalidArgumentException("dates are empty of insecure"));
		}

		//ensure both dates are in the correct format and are secure
		try {
			$sunriseVoteDateTime = self::validateDateTime($sunriseVoteDateTime);
			$sunsetVoteDateTime = self::validateDateTime($sunsetVoteDateTime);

		} catch(\InvalidArgumentException|\RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

//create query template
		$query = "SELECT votePostId, voteProfileID, voteDateTime, voteValue from vote WHERE voteDateTime >= :sunriseVoteDateTime AND voteDateTime <= : sunsetVoteDateTime";
		$statement = $pdo->prepare($query);


		//format the dates so that mySQL can use them
		$formattedSunriseDate = $sunriseVoteDateTime->format("Y-m-d H:i:s");
		$formattedSunsetDateTime = $sunsetVoteDateTime->format("Y-m-d H:i:s");


		$parameters = ["sunriseVoteDateTime" => $formattedSunriseDate, "sunsetVoteDateTime" => $formattedSunsetDateTime];
		$statement->execute($parameters);


//build an array of votes
		$votes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row = $statement->fetch()) !== false) {
			try {

				$vote = new Vote($row["votePostId"], $row["voteProfileId"], $row["voteDateTime"], $row["voteValue"]);
				$votes[$votes->key()] = $vote;
				$votes->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($votes);
	}

	/**
	 * getVoteByValue
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $voteValue vote value to search by
	 * @return \SplFixedArray SplFixedArray of votes found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getVotebyVoteValue(\ PDO $pdo, int $voteValue): \SPLFixedArray {
		// sanitize the value before searching
		if($voteValue !== -1 || $voteValue !== 1) {
			throw(new \RangeException("vote value must be an int"));
		}
		// create query template
		$query = "SELECT votePostId, voteProfileId, voteDateTime, voteValue FROM vote WHERE voteValue =voteValue";
		$statement = $pdo->prepare($query);
		// bind the vote value to the place holder in the template
		$parameters = ["voteValue" => $voteValue];
		$statement->execute($parameters);
//build an array of votes
		$votes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$vote = new Vote($row["votePostId"], $row["voteProfileId"], $row["voteDateTime"], $row["voteValue"]);
				$vote[$votes->key()] = $vote;
				$votes->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, retrow it
				throw(new \PDOException($exception->getmessage(), 0, $exception));
			}
		}
		return ($votes);
	}

	/**
	 * gets all votes
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Votes found or null if not found
	 * @throws \PDOEXception when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllVotes(\PDO $pdo): \SplFixedArray {
		//create query template
		$query = "SELECT votePostId, voteProfileId, voteDateTime, voteValue FROM vote";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of votes
		$votes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO:: FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$vote = new Vote($row["votePostId"], $row["voteProfileId"], $row["voteDateTime"], $row["voteValue"]);
				$votes[$votes->key()] = $vote;
				$votes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($votes);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		//format the data so that the front end can consume it
		$fields["voteDateTime"] = round(floatval($this->voteDateTime->format("U.u")) * 1000);

		return ($fields);
	}
}
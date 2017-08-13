<?php
namespace Edu\Cnm\TownHall;

require_once("autoload.php");

/**
 * townhall capstone project class Vote
 * @author Michelle Allen <mbojorquez2007@gmail.com>
 * @version 1.0.0
 * */

class vote {
	/**
	 * id for this Post; this is the primary key
	 * @var int $votePostId
	 **/
	private $votePostId;
	/**
	 * profile id for this profile; this is a foreign key
	 * @var int $voteProfileId
	 **/
	private $voteProfileId;
	/**
	 * timestamp of the post
	 * @var \DateTime $postDateTime
	 **/
	private $postDateTime;
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
	public function __construct(?int $newPostVoteId, int $newVoteProfileId, $newVoteDateTime, int $newVoteValue = null) {
		try {
			$this->setPostVoteId($newPostVoteId);
			$this->setVoteProfileId($newVoteProfileId);
			$this->setVoteDateTime($newVoteDateTime);
			$this->setVoteValue($newVoteValue);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for postVoteId
	 *
	 * @return int|null value of postVoteID
	 **/public function getPostVoteId() : int {
	return($this->postVoteId);
	}
/**
 * mutator method for postVoteID
 *
 * @param int|null $newPostVoteId new value of newPostVoteId
 * @throws \RangeException if $newPostVoteId is not positive
 * @throws \TypeError if $newPostVoteId is not an integer
 **/
	public function setPostVoteId(?int $newPostVoteId) :
	void {
		//if postVoteId is null immediately return it
		if($newPostVoteId === null) {
			$this->postVoteId = null;
			return;
		}

		// verify the postVoteId is positive
		//if($newPostVoteId <= 0) {
		throw(new \RangeException("postVoteId is not positive"));
	}

			// convert and store the postVoteId
			$this->postVoteId = $newPostVoteId;
		}
/**
 * accessor method for vote profile id
 *
 * @return int value of vote profile id
 **/
public function getVoteProfileId() : int{
	return ($this->VoteProfileId);
}
/**
 * mutator method for voteProfileId
 *
 * @param int $newVoteProfileId new value of vote profileId
 * @throws \RangeException if $newVoteProfileId is not positive
 * @throws \TypeError if $newVoteProfileId is not an integer
 **/
		public function setVoteProfileId(int $newVoteProfileId) :
void {

	// verify the voteProfile id is positive
	if($newVoteProfileId <= 0) {
		throw(new \RangeException("vote profile id is not positive"));
	}

	// convert and store the vote profile id
	$this->voteProfileId = $newVoteProfileId;
}

/**
 * accessor method for voteDateTime
 *
 * @return \ DateTime value of voteDateTime
 **/
public function getVoteDateTime() : \DateTime {
	return($this->VoteDateTime);
}

/**
 * mutator method for vote date/time
 *
 * @param \DateTime|string|null $newVoteDateTime vote date time as a DateTime object or string (or null to load the current time)
 * @throws \InvalidArgumentException if $newVoteDatetime is not a valid object or
string
 * @throws \RangeException if $newVoteDateTime is a date that does not exist
 **/
public function setVoteDateTime($newVoteDateTime = null) : void {
	// base case: if the date is null, use the current date and time
	if($newVoteDateTime === null) {
		$this->VoteDatetime = new \DateTime();
		return;
		}

			// store the like date using the ValidateDate trait
			try {
				$newVoteDateTime = self::validateDateTime($newVoteDateTime);
			} catch(\InvalidArgumentException | \RangeException $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
			$this->voteDateTime = $newVoteDateTime;
		}

/**
 * inserts this VoteDateTime into mySQL
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function insert(\PDO $pdo) : void {
	//enforce the postVoteId is null (i.e, don't insert a vote that already exist)
	if($this->votePostId !== null) {
		throw(new \PDOException("not a new vote"));
	}
	// create query template
	$query = "Insert Into vote(votePostId, voteProfileId, voteDateTime, voteValue) VALUES(:votePostId, voteProfileId, voteDateTime,voteValue)";
		$statement = $pdo -> prepare($query);

	//bind the member variables to the place holders in the template
		$formattedDateTime = $this->voteDateTime->format("Y-m-d H:i:s");
		$parameters = ["votePostId" => $this->votePostId, "voteProfileId" => $this->voteProfileId, "voteDateTime" => voteDateTime, "voteValue" => $formattedDate];
		$statement->execute($parameters);

		// update the null votePostId with what mySql just gave us
		$this->votePostId = intval($pdo -.lastInsertId());
		}

/**
 * deletes this vote from mySQL
 *
 * @param\PDO $pdo PDO connection object
 * @throws \PDOException when my SQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
 public function delete(\PDO $pdo) : void {
 			//enforce the votePostId is not null
	 //if($this->postVoteId === null) {
	 			throw(new \PDOException("unable to delete a vote that does not exist "));
}

// create query template
$query ="DELETE FROM vote WHERE postVoteId =:postVoteId";
$statement= $pdo-.prepare(query);

//bind the member variables to the place holder in the templlate









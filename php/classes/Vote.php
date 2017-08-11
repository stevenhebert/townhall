<?php
namespace Edu\Cnm\vote;
/**
* vote Class
 * This class stores all the vote data and the time of the vote
* Referenced by Profile and Post
*
 * @author Michelle Allen <mbojorquez4@cnm.edu>
 * @version 1.0
*/
class Vote {
	/**
	 * id for the original post; this is the primary key
	 * @var int $postVoteId
	 **/
	private $postVoteId;
	/**
	 * id of the profile that voted on post; this is a foreign key
	 * @var int $voteProfileId
	 **/
	private $voteProfileId;
	/**
	 * date and time the vote was posted, in a PHP DateTime object
	 * @var \DateTime $voteDateTime
	 **/
	private $voteDateTime;
	/**
	 * value of the vote that was posted, int as 1 or -1
	 * @var int $voteValue
	 */
	private $voteValue;
	/**
	 * constructor for this vote
	 *
	 * @param int $newPostVoteId for this vote
	 * @param int $newVoteProfileId for the Profile that voted on this post
	 * @param \DateTime|string|null $newVoteDateTime date and time vote was sent or null 		if set to current date and time
	 * @param int $newVoteValue value for this vote
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, 		negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct(?int $newPostVoteId, int $newVoteProfileId, $newVoteDateTime = null, int $newVoteValue) {
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
	 **/

	public function getPostVoteId() : int {
		return($this->postVoteId);
	}

/**
 * mutator method for postVoteID
 *
 * @param int|null $newPostVoteId new value of newPostVoteId
 * @throws \RangeException if $newPostVoteId is not positive
 * @throws \TypeError if $newPostVoteId is not an integer
 **/

	public function setPostVoteId(?int $newPostVoteId) : void {
		//if postVoteId is null immediately return it
		if($newPostVoteId === null) {
			$this->postVoteId = null;
			return;

			// verify the postVoteId is positive
			if($newPostVoteId <= 0) {
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

		public function getVoteProfileId() : int {
			return ($this->VoteProfileId);
		}

		/**
		 * mutator method for voteProfileId
		 *
		 * @param int $newVoteProfileId new value of vote profileId
		 * @throws \RangeException if $newVoteProfileId is not positive
		 * @throws \TypeError if $newVoteProfileId is not an integer
		 **/

		public function setVoteProfileId(int $newVoteProfileId) : void {

			// verify the voteProfile is positive
			if($newVoteProfileId <= 0) {
				throw(new \RangeException("vote profile id is not positive"));
			}

			// convert and store the vote profile id
			$this->voteProfileId = $newVoteProfileId;
		}

		/**
		 * accessor method for voteDateTime
		 *
		 * @return string value of voteDateTime
		 **/

		public function getVoteDateTime() : \DateTime {
			return($this->VoteDateTime);
		}

		/**
		 * mutator method for vote date/time
		 *
		 * @param \DateTime|string|null $newVoteDateTime vote date time as a DateTime 		object or string (or null to load the current time)
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
				$newVoteDateTime = self::validateVoteDateTime($newVoteDateTime);
			} catch(\InvalidArgumentException | \RangeException $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
			$this->VoteDateTime = $newVoteDateTime;
		}

		/**
		 * inserts this VoteDateTime into mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 **/

		/**
		 * accessor method for voteValue
		 *
		 * @return int|null value of voteValue
		 **/

		public function getvoteValue() : int {
			return($this->voteValue);
		}

		/**
		 * mutator method for voteValue
		 *
		 * @param int|null $newvoteValue new value voteValue
		 * @throws \RangeException if $newVoteValue is not = 1 or -1
		 * @throws \TypeError if $newVoteValue is not an integer
		 voteValue**/

		public function setVoteValue(?int $newVoteValue) : void {
			//if  is null immediately return it
			if($newVoteValue === null) {
				$this->voteValue = null;
				return;
			}

			// verify the VoteValue is an interger = 1 or -1
			if($newVoteValue <= -1 or => 1) {
		}

				throw(new \RangeException("tweet id is not an interger");
	}
	// convert and store the voteValue
		$this->voteValue= $newVoteValue;
	}

	/**
	 * accessor method for VoteValue
	 * @return int value of VoteValue
	 */

public function getVoteValue() : int{
	 return($this->voteValue);
}

	/**
	 * mutator method for voteValue
	 * @param int $newVoteValue new value of voteValue
	 * @throws \RangeException if $newVoteValue is not 1 or -1
	 * @throws \TypeError if $newVoteValue is not an interger
	 * */

public function setVoteValue (int $voteValue) : void {
	 // verify the voteValue is -1 0r 1
	if(voteValue not -1 or 1) {
		throw(new \RangeException("voteValue is not -1 or 1"));
	}

	// convert and store the voteValue
	$this->voteValue =$newVotValue;
}

		/**
		 * @param \PDO $pdo
		 */

		public function insert(\PDO $pdo) : void {
			// enforce the voteProfileId is null (i.e., don't insert a vote that already 		exists)
			if($this->voteProfileId !== null) {
				throw(new \PDOException("not a new voteProfileId"));
			}

			// create query template
			$query = "INSERT INTO vote(votePostId, voteProfileId, voteDate, voteValue) VALUES(:votePostId, :voteProfileId, :voteDateTime, :voteValue)";
			$statement = $pdo->prepare($query);

			// bind the member variables to the place holders in the template
			$formattedDate = $this->voteDate->format("Y-m-d H:i:s.u");
			$parameters = ["votePostId" => $this->votePostId, "voteProfileId" => $this->voteProfileId, "voteDateTime" => $formattedVoteDateTime "voteValue"=> 			$this->voteValue];
			$statement->execute($parameters);

			//update the null postVoteId with what mySQL just gave us
$this->postVoteId = intval($pdo->lastinsertId());
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
	 			throw(new \PDOException("unable to delete a tweet that does not exist "))
}

// create query template
$query ="DELETE FROM vote WHERE postVoteId =:postVoteId";










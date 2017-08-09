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
	 * @param int $newPostVoteId id for this vote
	 * @param int $newVoteProfileId id for the Profile that voted on this post
	 * @param \DateTime|string|null $newVoteDateTime date and time vote was sent or null if set to current date and time
	 * @param int $newVoteValue value for this vote
	 *



}
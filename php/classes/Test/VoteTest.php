<?php
namespace Edu\Cnm\Townhall\Test;
use Edu\Cnm\Townhall\{District, Profile, Post, Vote};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
/**
 * Full PHPUnit test for the Vote class
 *
 * This is a complete PHPUnit test of the Vote class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 *
 * @author Michelle Allen <Mbojorquez2007@gmail.com>
 **/
class VoteTest extends TownhallTest {
	/*district data needs to be set up first*/
	/**
	 * district that created the profile; this is for foreign key relations
	 * @var District district
	 **/
	protected $district = null;
	/**
	 * valid district id to use to create the profile object to own the test
	 * @var int $VALID_DISTRICT_ID
	 */
	protected $VALID_DISTRICT_ID;
	/**
	 * valid DISTRICT NAME to use to create the profile object to own the test
	 * @var string $VALID_DISTRICT_NAME
	 */
	protected $VALID_DISTRICT_NAME = "DIstrict 1";
	/**
	 * valid district geom to use to create the profile object to own the test
	 * @var string $VALID_DISTRICT_GEOM
	 */
	protected $VALID_DISTRICT_GEOM = '{"type":"Polygon","coordinates":[[[0,0],[10,0],[10,10],[0,10],[0,0]]]}';
	/**
	 * Profile that created the Post; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;
	/**
	 * 2nd Profile ; this is for foreign key relations
	 * @var Profile profile2
	 **/
	protected $profile2 = null;
	/**
	 * valid profile id to use to create the profile object to own the test
	 * @var int $VALID_PROFILE_ID
	 */
	protected $VALID_PROFILE_ID;
	/**
	 * valid district id to use to create the profile object to own the test
	 * @var int $VALID_PROFILE_DISTRICT_ID
	 */
	protected $VALID_PROFILE_DISTRICT_ID;
	/**
	 * valid activation token to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ACTIVATION_TOKEN
	 */
	protected $VALID_PROFILE_ACTIVATION_TOKEN;
	/**
	 * valid address1 to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ADDRESS1
	 */
	protected $VALID_PROFILE_ADDRESS1 = "123 Main St";
	/**
	 * valid CITY to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_CITY
	 */
	protected $VALID_PROFILE_CITY = "Albuquerque";
	/**
	 * valid email to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL = "myemail@email.com";
	/**
	 * valid first name to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_FIRSTNAME
	 */
	protected $VALID_PROFILE_FIRSTNAME = "Jean-Luc";
	/**
	 * valid profile hash to create the profile object to own the test
	 * @var string $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;
	/**
	 * valid profile hash to create the profile object to own the test
	 * @var string $VALID_HASH2
	 * */
	protected $VALID_PROFILE_HASH2;
	/**
	 * valid last name to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_LASTNAME
	 */
	protected $VALID_PROFILE_LASTNAME = "Picard";
	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_PROFILE_SALT;
	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT2
	 */
	protected $VALID_PROFILE_SALT2;
	/**
	 * valid state to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_STATE
	 */
	protected $VALID_PROFILE_STATE = "NM";
	/**
	 * valid username to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_USERNAME
	 */
	protected $VALID_PROFILE_USERNAME = "IamJeanLuc";
	/**
	 * valid zip to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ZIP
	 */
	protected $VALID_PROFILE_ZIP = "87508";
	/*set up the variables for the post table*/

	/**
	 * Post to test vote; this is for foreign key relations
	 * @var Post post
	 **/
	protected $post = null;
	/**
	/**
	 * Post to test vote; this is for foreign key relations
	 * @var Post post
	 **/
	protected $post2 = null;
	/**
	 * Post to test vote; this is for foreign key relations
	 * @var Post post
	 **/
	protected $post3 = null;
	/**
	 * Post to test vote; this is for foreign key relations
	 * @var Post post
	 **/
	protected $post4 = null;

	/**
	 * district id of the Post
	 * @var int $VALID_POST_DISTRICTID
	 **/
	protected $VALID_POST_DISTRICTID;
	/**
	 * PARENT ID of the Post
	 * @var int $VALID_POST_PARENTID
	 **/
	protected $VALID_POST_PARENTID;
	/**
	 * PROFILE ID of the Post
	 * @var int $VALID_POST_PROFILEID
	 **/
	protected $VALID_POST_PROFILEID;
	/**
	 * content of the Post
	 * @var string $VALID_POSTCONTENT
	 **/
	protected $VALID_POSTCONTENT = "May the force be with you.  Oops, wrong reference.";
	/**
	 * content of the updated Post
	 * @var string $VALID_POSTCONTENT2
	 **/
	protected $VALID_POSTCONTENT2 = "Let's ask some serious questions here.";
	/**
	 * timestamp of the Post; this starts as null and is assigned later
	 * @var \DateTime $VALID_POSTDATE
	 **/
	protected $VALID_POSTDATE = null;
	/**
	 * Valid timestamp to use as sunrisePostDate
	 */
	protected $VALID_SUNRISEDATE = null;
	/**
	 * Valid timestamp to use as sunsetPostDate
	 */
	protected $VALID_SUNSETDATE = null;
	/**
	 * vote id of the Post
	 * @var int $VALID_VOTE_POSTID
	 **/
	protected $VALID_VOTE_POSTID;

	/**
	 * PROFILE ID of the Vote
	 * @var int $VALID_VOTE_PROFILEID
	 **/
	protected $VALID_VOTE_PROFILEID;
	/**
	 * timestamp of the Vote; this starts as null and is assigned later
	 * @var \DateTime $VALID_POSTDATE
	 **/
	protected $VALID_VOTEDATE = null;

	/**
	 * VALUE of the VOTE
	 * @var int $VALID_VOTEVALUE
	 **/
	protected $VALID_VOTEVALUE = 1;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);

		$this->VALID_PROFILE_SALT2 = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH2 = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);

		// create and insert a district for the test post
		$this->district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);
		$this->district->insert($this->getPDO());

		// create and insert a profile to own the post
		// get districtId from the district
		$this->profile = new Profile(null, $this->district->getDistrictId(), "123", "123 Main St", "+12125551212", "Albuquerque", null, "test@email.com", "Jean-Luc", $this->VALID_PROFILE_HASH, "Picard", "789",null, $this->VALID_PROFILE_SALT, "NM", "iamjeanluc", "12345");
		$this->profile->insert($this->getPDO());

		//create second profile
		$this->profile2 = new Profile(null, $this->district->getDistrictId(), "456", "124 Main St", "+12125551212", "Albuquerque", null, "test2@email.com", "Lucy", $this->VALID_PROFILE_HASH2, "Lu", "101112",null, $this->VALID_PROFILE_SALT2, "NM", "lucygirl", "12345");
		$this->profile2->insert($this->getPDO());

		// create valid posts to vote on
		$this->post = new Post(null, $this->district->getDistrictId(), null, $this->profile->getProfileId(),$this->VALID_POSTCONTENT, null);
		$this->post->insert($this->getPDO());
		$this->post2 = new Post(null, $this->district->getDistrictId(), null, $this->profile->getProfileId(),$this->VALID_POSTCONTENT, null);
		$this->post2->insert($this->getPDO());
		$this->post3 = new Post(null, $this->district->getDistrictId(), null, $this->profile->getProfileId(),$this->VALID_POSTCONTENT, null);
		$this->post3->insert($this->getPDO());
		$this->post4 = new Post(null, $this->district->getDistrictId(), null, $this->profile->getProfileId(),$this->VALID_POSTCONTENT, null);
		$this->post4->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Vote and verify that the actual mySQL data matches
	 **/
	public function testInsertValidVote(): void {
		$numRows = $this->getConnection()->getRowCount("vote");
		// create a new vote and insert to into mySQL
		$vote = new Vote($this->post->getPostId(), $this->profile->getProfileId(), null,$this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByPostIdAndProfileId($this->getPDO(), $this->post->getPostId(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVotePostId(), $this->post->getPostId());
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
	}


	/**
	 * test inserting a Vote that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidVote(): void {

		// create a vote with a invalid Ids and watch it fail
		$vote = new Vote(TownhallTest::INVALID_KEY, TownhallTest::INVALID_KEY, null, 1);
		$vote->insert($this->getPDO());
	}

/* update a valid vote */
	public function testUpdateValidVote() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");
		// create a new vote and insert to into mySQL

		$vote = new Vote($this->post->getPostId(),$this->profile->getProfileId(), null, $this->VALID_VOTEVALUE);

		$vote->insert($this->getPDO());
		// edit the vote and update it in mySQL
		$vote->setVoteValue(-1);
		$vote->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations

		$pdoVote = Vote::getVoteByPostIdAndProfileId($this->getPDO(), $vote->getVotePostId(), $vote->getVoteProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVotePostId(), $this->post->getPostId());
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
	}

	/**
	 * test updating a Vote that doesn't exist
	 *
	 * @expectedException \TypeError
	 **/
	public function testUpdateInvalidVote(): void {
		// create a Vote and update post or profile id--should fail
		$vote = new Vote(null, $this->profile->getProfileId(), null, $this->VALID_VOTEVALUE);
		$vote->update($this->getPDO());
	}

	/**
	 * test creating a Vote and then deleting it
	 **/
	public function testDeleteValidVote(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");
		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->post->getPostId(), $this->profile->getProfileId(), null, $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());
		// delete the Vote from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$vote->delete($this->getPDO());
		// grab the data from mySQL and enforce the Vote does not exist
		$pdoVote = Vote::getVoteByPostIdAndProfileId($this->getPDO(), $vote->getVotePostId(), $vote->getVoteProfileId());
		$this->assertNull($pdoVote);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("vote"));
	}

	/**
	 * test deleting a Vote that does not exist
	 *
	 * @expectedException \TypeError
	 **/
	public function testDeleteInvalidVote(): void {
		// create a Vote and try to delete it without actually inserting it
		$vote = new Vote(null, $this->profile->getProfileId(), null, $this->VALID_VOTEVALUE);
		$vote->delete($this->getPDO());
	}

	public function testGetValidVoteByVotePostId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");
		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->post->getPostId(), $this->profile->getProfileId(), null, $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Vote::getVoteByPostId($this->getPDO(), $vote->getVotePostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Vote", $results);
		// grab the result from the array and validate it
		$pdoVote = $results[0];
		$this->assertEquals($pdoVote->getVotePostId(), $this->post->getPostId());
	}

	/**
	 * test grabbing a Vote that does not exist
	 **/
	public function testGetInvalidVoteByVotePostId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$vote = Vote::getVoteByPostId($this->getPDO(), TownhallTest::INVALID_KEY);
		$this->assertCount(0, $vote);
	}

	/**
	 * test inserting a Vote and regrabbing it from mySQL
	 **/
	public function testGetValidVoteByVoteProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");
		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->post->getPostId(), $this->profile->getProfileId(), null, $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Vote::getVoteByProfileId($this->getPDO(), $vote->getVoteProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Vote", $results);
		// grab the result from the array and validate it
		$pdoVote = $results[0];
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
		}

	/**
	 * test grabbing a Vote that does not exist
	 **/
	public function testGetInvalidVoteByVoteProfileId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$vote = Vote::getVoteByProfileId($this->getPDO(), TownhallTest::INVALID_KEY);
		$this->assertCount(0, $vote);
	}

	/**
	 * test grabbing a Vote by vote value
	 **/
	public function testGetValidPostByVoteValue(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");
		// create a new Vote and insert to into mySQL

		$vote = new Vote($this->post->getPostId(), $this->profile->getProfileId(), null, $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Vote::getVoteByVoteValue($this->getPDO(), $vote->getVoteValue());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertCount(1, $results);
		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Vote", $results);
		// grab the result from the array and validate it
		$pdoVote = $results[0];
		$this->assertEquals($pdoVote->getvoteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoVote->getvotePostId(), $this->post->getPostId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}

	/**
	 * test grabbing a Vote by value that does not exist
	 **/
	public function testGetInvalidVoteByVoteValue(): void {
		// grab a vote by value that does not exist
		$vote = Vote::getVotebyVoteValue($this->getPDO(), 1);
		$this->assertCount(0, $vote);
	}



	/**
	 * test grabbing all Votes
	 **/
	public function testGetAllValidVotes(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");
		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->post->getPostId(), $this->profile->getProfileId(), null, $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Vote::getAllVotes($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Vote", $results);
		// grab the result from the array and validate it
		$pdoVote = $results[0];
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoVote->getVotePostId(), $this->post->getPostId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}

	/*
	 * test get sum of vote value
	 *
	 */
	public function testGetValidSumOfVoteValues(): void {
		// create new Votes and insert into mySQL

		$vote = new Vote($this->post->getPostId(), $this->profile->getProfileId(), null, 1);
		$vote->insert($this->getPDO());

		$vote2 = new Vote($this->post->getPostId(), $this->profile2->getProfileId(), null, -1);
		$vote2->insert($this->getPDO());

		$vote3 = new Vote($this->post2->getPostId(), $this->profile->getProfileId(), null, 1);
		$vote3->insert($this->getPDO());

		$vote4 = new Vote($this->post2->getPostId(), $this->profile2->getProfileId(), null, 1);
		$vote4->insert($this->getPDO());

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		//votes are in place, so we need to test the values
		$results = Vote::getSumOfVoteValuesByPostId($this->getPDO(), $this->post->getPostId());
		$results2 = Vote::getSumOfVoteValuesByPostId($this->getPDO(), $this->post2->getPostId());


		$this->assertEquals($results->votePostId, $this->post->getPostId());
		//$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));

		$this->assertEquals($results2->votePostId, $this->post2->getPostId());
		//$this->assertEquals($numRows + 2, $this->getConnection()->getRowCount("vote"));
	}

}
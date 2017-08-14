<?php
namespace Edu\Cnm\Townhall\Test;
use Edu\Cnm\Townhall\{District, Profile, Post};
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
/**
 * Full PHPUnit test for the Post class
 *
 * This is a complete PHPUnit test of the Post class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 *
 * @author Leonora Sanchez-Rees <leonora621@yahoo.com>
 **/
class PostTest extends TownhallTestSetup {
	/*district data needs to be set up first*/
	/**
	 * district that created the profile; this is for foreign key relations
	 * @var District district
	 **/
	protected $district = null;
	/**t
	 * valid district id to use to create the profile object to own the test
	 * @var string $VALID_DISTRICT_ID
	 */
	protected $VALID_DISTRICT_ID;
	/**
	 * valid DISTRICT NAME to use to create the profile object to own the test
	 * @var string $VALID_DISTRICT_NAME
	 */
	protected $VALID_DISTRICT_NAME;
	/**
	 * valid district geom to use to create the profile object to own the test
	 * @var string $VALID_DISTRICT_GEOM
	 */
	protected $VALID_DISTRICT_GEOM;
	/**
	 * Profile that created the Post; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;
	/**
	 * valid profile id to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ID
	 */
	protected $VALID_PROFILE_ID;
	/**
	 * valid district id to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_DISTRICT_ID
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
	protected $VALID_PROFILE_ADDRESS1;
	/**
	 * valid CITY to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_CITY
	 */
	protected $VALID_PROFILE_CITY;
	/**
	 * valid email to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL;
	/**
	 * valid first name to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_FIRSTNAME
	 */
	protected $VALID_PROFILE_FIRSTNAME;
	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;
	/**
	 * valid last name to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_LASTNAME
	 */
	protected $VALID_PROFILE_LASTNAME;
	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_PROFILE_SALT;
	/**
	 * valid state to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_STATE
	 */
	protected $VALID_PROFILE_STATE;
	/**
	 * valid username to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_USERNAME
	 */
	protected $VALID_PROFILE_USERNAME;
	/**
	 * valid zip to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ZIP
	 */
	protected $VALID_PROFILE_ZIP;
	/*set up the variables for the post table*/
	/**
	 * district id of the Post
	 * @var string $VALID_POST_DISTRICTID
	 **/
	protected $VALID_POST_DISTRICTID;
	/**
	 * PARENT ID of the Post
	 * @var string $VALID_POST_PARENTID
	 **/
	protected $VALID_POST_PARENTID;
	/**
	 * PROFILE ID of the Post
	 * @var string $VALID_POST_PROFILEID
	 **/
	protected $VALID_POST_PROFILEID;
	/**
	 * content of the Post
	 * @var string $VALID_POSTCONTENT
	 **/
	protected $VALID_POSTCONTENT = "Hey, we created some content.  We're special.";
	/**
	 * content of the updated Post
	 * @var string $VALID_POSTCONTENT2
	 **/
	protected $VALID_POSTCONTENT2 = "Ooh, more content. Look what we did";
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
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);
		// create and insert a District to own the test Post
		$poly = 'Polygon((0 0,10 0,10 10,0 10,0 0))';
		$this->district = new District(null, ST_GeomFromText($poly),"1");
		$this->district->insert($this->getPDO());
		// create and insert a Profile to own the test Post
		$this->profile = new Profile(null, null,"123", "123 Main St", "+12125551212", "test1@email.com", "test@email.com", "Jean-Luc", $this->VALID_PROFILE_HASH, "Picard", 0, $this->VALID_PROFILE_SALT, "NM", "iamjeanluc");
		$this->profile->insert($this->getPDO());
		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_POSTDATE = new \DateTime();
		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));
		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}
	/**
	 * test inserting a valid Post and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPost() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null, $this->VALID_POST_PARENTID, $this->VALID_POST_PARENTID, $this->VALID_POST_PROFILEID, $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPost->getPostDateTime()->getTimestamp(), $this->VALID_POSTDATE->getTimestamp());
	}
	/**
	 * test inserting a Post that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidPost() : void {
		// create a Post with a non null post id and watch it fail
		$post = new Post(TownhallTestSetup::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
	}
	/**
	 * test inserting a Post, editing it, and then updating it
	 **/
	public function testUpdateValidPost() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->VALID_DISTRICT_ID, $this->VALID_POST_PARENTID, $this->VALID_POST_PROFILEID, $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
		// edit the Post and update it in mySQL
		$post->setPostContent($this->VALID_POSTCONTENT2);
		$post->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT2);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPost->getPostDateTime()->getTimestamp(), $this->VALID_POSTDATE->getTimestamp());
	}
	/**
	 * test updating a Post that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidPost() : void {
		// create a Post with a non null tweet id and watch it fail
		$post = new Post(null, $this->VALID_POST_DISTRICTID, $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->update($this->getPDO());
	}
	/**
	 * test creating a Post and then deleting it
	 **/
	public function testDeleteValidPost() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
		// delete the Post from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$post->delete($this->getPDO());
		// grab the data from mySQL and enforce the Post does not exist
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertNull($pdoPost);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("tweet"));
	}
	/**
	 * test deleting a Post that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidPost() : void {
		// create a Post and try to delete it without actually inserting it
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
		$post->delete($this->getPDO());
	}
	/**
	 * test inserting a Post and regrabbing it from mySQL
	 **/
	public function testGetValidPostByPostId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPost->getPostDateTime()->getTimestamp(), $this->VALID_POSTDATE->getTimestamp());
	}
	/**
	 * test grabbing a Post that does not exist
	 **/
	public function testGetInvalidPostByPostId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$tweet = Post::getPostByPostId($this->getPDO(), TownhallTestSetup::INVALID_KEY);
		$this->assertNull($tweet);
	}
	/**
	 * test inserting a Post and regrabbing it from mySQL
	 **/
	public function testGetValidPostByPostProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostProfileId($this->getPDO(), $post->getPostProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Post", $results);
		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPost->getPostDate()->getTimestamp(), $this->VALID_POSTDATE->getTimestamp());
	}
	/**
	 * test grabbing a Post that does not exist
	 **/
	public function testGetInvalidPostByPostProfileId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$this->assertCount(0, $post);
	}
	/**
	 * test grabbing a Post by post content
	 **/
	public function testGetValidPostByPostContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostContent($this->getPDO(), $post->getPostContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Post", $results);
		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPost->getPostDate()->getTimestamp(), $this->VALID_POSTDATE->getTimestamp());
	}
	/**
	 * test grabbing a Post by content that does not exist
	 **/
	public function testGetInvalidPostByPostContent() : void {
		// grab a tweet by content that does not exist
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$this->assertCount(0, $post);
	}
	/**
	 * test grabbing a valid Post by sunset and sunrise date
	 *
	 */
	public function testGetValidPostBySunDate() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		//create a new Post and insert it into the database
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
		// grab the tweet from the database and see if it matches expectations
		$results = Post::getPostByPostDate($this->getPDO(), $this->VALID_SUNRISEDATE, $this->VALID_SUNSETDATE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1,$results);
		//enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Post", $results);
		//use the first result to make sure that the inserted tweet meets expectations
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostId(), $post->getPostId());
		$this->assertEquals($pdoPost->getPostProfileId(), $post->getPostProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $post->getPostContent());
		$this->assertEquals($pdoPost->getPostDate()->getTimestamp(), $this->VALID_POSTDATE->getTimestamp());
	}
	/**
	 * test grabbing all Posts
	 **/
	public function testGetAllValidPosts() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, $this->VALID_POSTDATE);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getAllPosts($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tweet"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\DataDesign\\Post", $results);
		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoPost->getPostDate()->getTimestamp(), $this->VALID_POSTDATE->getTimestamp());
	}
}
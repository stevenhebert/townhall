<?php

namespace Edu\Cnm\Townhall\Test;
use Edu\Cnm\Townhall\{Post, Profile, District};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Post class
 *
 * This is a complete PHPUnit test of the Post class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @author Leonora Sanchez-Rees <leonora621@yahoo.com>
 **/

class PostTest extends TownhallTest {

	/**
	 * District of this profile; this is for foreign key relations
	 * @var District district
	 *
	 **/
	protected $district = null;

	/**
	 * valid DISTRICT NAME to use to create the profile object to own the test
	 * @var string $VALID_DISTRICT_NAME
	 */
	protected $VALID_DISTRICT_NAME = "District 1";

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
	 * valid profile id to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ID
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
	protected $VALID_PROFILE_ACTIVATION_TOKEN = "abcdef123456";

	/**
	 * valid address1 to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ADDRESS1
	 */
	protected $VALID_PROFILE_ADDRESS1 = "123 Main St";

	/**
	 * valid address2 to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ADDRESS2
	 */
	protected $VALID_PROFILE_ADDRESS2 = "Suite 311";

	/**
	 * valid CITY to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_CITY
	 */
	protected $VALID_PROFILE_CITY = "Albuquerque";

	/**
	 * valid email to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL = "mybestemailever@email.com";

	/**
	 * valid first name to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_FIRSTNAME
	 */
	protected $VALID_PROFILE_FIRSTNAME = "Jean-Luc";

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;

	/**
	 * valid last name to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_LASTNAME
	 */
	protected $VALID_PROFILE_LASTNAME = "Picard";

	/**
	 * valid representative indicator to use to create the profile object
	 * @var int $VALID_PROFILE_REPRESENTATIVE;
	 */
	protected $VALID_PROFILE_RECOVERY_TOKEN = "111111111111";

	/**
	 * invalid profile activation token to create the profile object to own the test
	 * @var $INVALID_PROFILE_RECOVERY_TOKEN
	 **/
	protected $VALID_PROFILE_REPRESENTATIVE;

	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_PROFILE_SALT;

	/**
	 * valid state to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_STATE
	 */
	protected $VALID_PROFILE_STATE = "NM";

	/**
	 * valid username to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_USERNAME
	 */
	protected $VALID_PROFILE_USERNAME ="IamJeanLuc";

	/**
	 * valid zip to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ZIP
	 */
	protected $VALID_PROFILE_ZIP = "87508";

	/*set up the variables for the post table*/
	/**
	 * district id of the Post
	 * @var int $VALID_POST_DISTRICTID
	 **/
	protected $VALID_POST_DISTRICTID;

	/**
	 * PARENT ID of the Post
	 * @var int $VALID_POST_PARENTID
	 **/
	protected $VALID_POST_PARENTID = null;

	/**
	 * PARENT ID of the 2nd Post
	 * @var int $VALID_POST_PARENTID2
	 **/
	protected $VALID_POST_PARENTID2 = null;

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
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);

		// create and insert a District for the test Post
		$this->district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);
		$this->district->insert($this->getPDO());

		// create and insert a Profile to own the test Post
		//need to get the districtId from the district
		// create a new Profile and insert to into mySQL
		$this->profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null ,$this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRSTNAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LASTNAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USERNAME, $this->VALID_PROFILE_ZIP);
		$this->profile->insert($this->getPDO());

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
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null, $this->district->getDistrictId(), null, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
	}
	/**
	 * test inserting a Post that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidPost() : void {
		// create a Post with a non null post id and watch it fail
		$post = new Post(TownhallTest::INVALID_KEY, $this->district->getDistrictId(), null, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());
	}
	/**
	 * test inserting a Post, editing it, and then updating it
	 **/
	public function testUpdateValidPost() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->district->getDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());
		// edit the Post and update it in mySQL
		$post->setPostContent($this->VALID_POSTCONTENT2);
		$post->update($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT2);
	}
	/**
	 * test updating a Post that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidPost() : void {
		// create a Post with a non null post id and watch it fail
		$post = new Post(null, $this->district->getDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->update($this->getPDO());
	}
	/**
	 * test creating a Post and then deleting it
	 **/
	public function testDeleteValidPost() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());
		// delete the Post from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$post->delete($this->getPDO());
		// grab the data from mySQL and enforce the Post does not exist
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertNull($pdoPost);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("post"));
	}
	/**
	 * test deleting a Post that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidPost() : void {
		// create a Post and try to delete it without actually inserting it
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->delete($this->getPDO());
	}
	/**
	 * test inserting a Post and regrabbing it from mySQL
	 **/
	public function testGetValidPostByPostId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
	}
	/**
	 * test grabbing a Post that does not exist
	 **/
	public function testGetInvalidPostByPostId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$tweet = Post::getPostByPostId($this->getPDO(), TownhallTest::INVALID_KEY);
		$this->assertNull($tweet);
	}
	/**
	 * test inserting a Post and regrabbing it from mySQL, using postProfileId
	 **/
	public function testGetValidPostByPostDistrictId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null, $this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostDistrictId($this->getPDO(), $post->getPostDistrictId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Post", $results);
		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
	}
	/**
	 * test grabbing a Post that does not exist
	 **/
	public function testGetInvalidPostByDistrictId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$post = Post::getPostByPostDistrictId($this->getPDO(), TownhallTest::INVALID_KEY);
		$this->assertCount(0, $post);
	}

	/*
	 * get a post by parent id
	 * row gets inserted but function fails because of parent setup
	 */
	public function testGetValidPostByPostParentId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());

		//now insert a parent post based on 1st post
		$postChild = new Post(null,$this->profile->getProfileDistrictId(),$post->getPostId(), $this->profile->getProfileId(), "oh yeah!",null);
		$postChild->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostParentId($this->getPDO(), $postChild->getPostParentId());
		$this->assertEquals($numRows + 2, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Post", $results);


		//delete the post with a parent id so other tests don't fail
		$postChild->delete($this->getPDO());
	}

	/*
	 * test inserting an invalid parent key, must exist as a post in the table
	 */
	public function testGetInvalidPostByParentId() : void {
		//try to get post by invalid parent key

		$post = Post::getPostByPostParentId($this->getPDO(), TownhallTest::INVALID_KEY);
		$this->assertCount(0, $post);
	}

	/*
	 * test getting post by profile id
	 */
	public function testGetValidPostByPostProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostProfileId($this->getPDO(), $post->getPostProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Post", $results);
		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
	}

	/**
	 * test grabbing a Post by profile that does not exist
	 **/
	public function testGetInvalidPostByPostProfileId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$post = Post::getPostByPostProfileId($this->getPDO(), TownhallTest::INVALID_KEY);
		$this->assertCount(0, $post);
	}

	/**
	 * test grabbing a Post by post content
	 **/
	public function testGetValidPostByPostContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostContent($this->getPDO(), $post->getPostContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Post", $results);
		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
	}

	/**
	 * test inserting a Post and regrabbing it from mySQL, using postProfileId
	 **/
	public function testGetInvalidPostByPostContent() : void {
		// grab a tweet by content that does not exist
		$post = Post::getPostByPostContent($this->getPDO(), "Reports of my assimilation are greatly exaggerated.");
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
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());
		// grab the post from the database and see if it matches expectations
		$results = Post::getPostByPostDate($this->getPDO(), $this->VALID_SUNRISEDATE, $this->VALID_SUNSETDATE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1,$results);
		//enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Post", $results);
		//use the first result to make sure that the inserted post meets expectations
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostId(), $post->getPostId());
		$this->assertEquals($pdoPost->getPostDistrictId(), $post->getPostDistrictId());
		$this->assertEquals($pdoPost->getPostParentId(), $post->getPostParentId());
		$this->assertEquals($pdoPost->getPostProfileId(), $post->getPostProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $post->getPostContent());
		$this->assertEquals($pdoPost->getPostDateTime(), $post->getPostDateTime());
	}

	/**
	 * test grabbing all Posts
	 **/
	public function testGetAllValidPosts() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");
		// create a new Post and insert to into mySQL
		$post = new Post(null,$this->profile->getProfileDistrictId(), $this->VALID_POST_PARENTID, $this->profile->getProfileId(), $this->VALID_POSTCONTENT, null);
		$post->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getAllPosts($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Post", $results);
		// grab the result from the array and validate it
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_POSTCONTENT);
	}
}
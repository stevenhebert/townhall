<?php

namespace Edu\Cnm\Townhall;

use Edu\Cnm\Townhall\{Profile, Test\TownhallTest};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Ryan Henson <hensojr@gmail.com>
 **/
class ProfileTest extends TownhallTest {
	/**
	 * District of this profile; this is for foreign key relations
	 * @var District
	 **/
	protected $district = null;

	/**
	 * valid profile activation token to create the profile object to own the test
	 * @var $VALID_PROFILE_ACTIVATION_TOKEN
	 */
	protected $VALID_PROFILE_ACTIVATION_TOKEN;

	/**
	 * valid address1 to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ADDRESS1
	 */
	protected $VALID_PROFILE_ADDRESS1 = "4228 Courtney Ave NE";

	/**
	 * valid address2 to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ADDRESS2
	 */
	protected $VALID_PROFILE_ADDRESS2 = "Apt. 302";

	/**
	 * valid address2 to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ADDRESS_TEST
	 */
	protected $VALID_PROFILE_ADDRESS_TEST = "515 Central Ave NW";

	/**
	 * valid city to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_CITY
	 */
	protected $VALID_PROFILE_CITY = "Albuquerque";

	/**
	 * valid email to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_EMAIL
	 */
	protected $VALID_PROFILE_EMAIL = "hensojr@gmail.com";

	/**
	 * valid first name to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_FIRST_NAME ;
	 */
	protected $VALID_PROFILE_FIRST_NAME = "Ryan";

	/**
	 * hash of the profile
	 * @var string $VALID_PROFILE_HASH
	 **/
	protected $VALID_PROFILE_HASH;

	/**
	 * valid last name to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_LAST_NAME ;
	 */
	protected $VALID_PROFILE_LAST_NAME = "Henson";

	/**
	 * valid profile representative to use to create the profile object to own the test
	 * @var int $VALID_PROFILE_REPRESENTATIVE ;
	 */
	protected $VALID_PROFILE_REPRESENTATIVE;

	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_SALT
	 */
	protected $VALID_PROFILE_SALT;

	/**
	 * valid state to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_STATE
	 */
	protected $VALID_PROFILE_STATE = "NM";

	/**
	 * valid user name to use to create the profile object to own the test
	 * @var string $VALID_USER_NAME
	 */
	protected $VALID_PROFILE_USER_NAME = "rowdyryan";

	/**
	 * valid zip use to create the profile object to own the test
	 * @var string $VALID_USER_ZIP
	 */
	protected $VALID_PROFILE_ZIP = "87108";

	/**
	 * valid zip use to create the profile object to own the test
	 * @var string $VALID_USER_ZIP_TEST
	 */
	protected $VALID_PROFILE_ZIP_TEST = "87102";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		parent::setUp();
		$password = "SecurePassword";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = bash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);

		// create and insert a District to own the test profile
		$this->district = new District(null, "ST_GeomFromText('Polygon((0 0,10 0,10 10,0 10,0 0))'))", "District-6");
		$this->district->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->Profile->getProfileDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidProfile(): void {
		// create a Profile with a non null profile id and watch it fail
		$profile = new Profile("1", $this->Profile->getProfileDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile(): void {
		//count the number of rows and save it for later
		$numRows = $this->$this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->getProfileDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		//edit profile and update it in mySQL
		$profile->setProfileAddress1($this->VALID_PROFILE_ADDRESS_TEST);
		$profile->insert($this->getPDO());
		$profile->setProfileZip($this->VALID_PROFILE_ZIP_TEST);
		$profile->insert($this->getPDO());

		//grab the profile data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS_TEST);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP_TEST);
	}

	/**
	 * test creating a Profile and then deleting it
	 **/
	public function testDeleteValidProfile(): void {
		//count the number of rows and save it for later
		$numRows = $this->$this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->getProfileDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		//delete the profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		//grab the data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test deleting a Profile that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidProfile(): void {
		// create a Profile and try to delete it without actually inserting it
		$profile = new Profile(null, $this->getProfileDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->delete($this->getPDO());
	}

	/**
	 * test inserting a Profile and regrabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId(): void {
		//count the number of rows and save it for later
		$numRows = $this->$this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->getProfileDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
	}

	/**
	 * test grabbing a Profile that does not exist
	 **/
	public function testGetInvalidProfileByProfileId(): void {
		// grab a profile id that is not valid
		$profile = Profile::getProfileByProfileId($this->getPDO(), "-1");
		$this->assertNull($profile);
	}

	/**
	 * test inserting a Profile and regrabbing it from mySQL by email
	 **/
	public function testGetValidProfileByProfileEmail(): void {
		//count the number of rows and save it for later
		$numRows = $this->$this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->getProfileDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
	}

	/**
	 * test grabbing a Profile with email that does not exist
	 **/
	public function testGetInvalidProfileByProfileEmail(): void {
		// grab a profile email that is not valid
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "xzy@qrs.abc");
		$this->assertNull($profile);
	}

	/**
	 * test inserting a Profile and regrabbing it from mySQL by username
	 **/
	public function testGetValidProfileByProfileUserName(): void {
		//count the number of rows and save it for later
		$numRows = $this->$this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->getProfileDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileUserName($this->getPDO(), $profile->getProfileUserName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
	}

	/**
	 * test grabbing a Profile with user name that does not exist
	 **/
	public function testGetInvalidProfileByUserName(): void {
		// grab a profile email that is not valid
		$profile = Profile::getProfileByProfileUserName($this->getPDO(), "unrowdyryan");
		$this->assertNull($profile);
	}
}
<?php

namespace Edu\Cnm\Townhall\Test;
use Edu\Cnm\Townhall\ {Profile, District};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @author Ryan Henson <hensojr@gmail.com>
 **/

class ProfileTest extends TownhallTest {

	/**
	 * Distict of this profile; this is for foreign key relations
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
	 * @var string $VALID_DISTRICT_GEOM
	 *
	 **/
	protected $VALID_DISTRICT_GEOM = '{"type":"Polygon","coordinates":[[[0,0],[10,0],[10,10],[0,10],[0,0]]]}';

	/**
	 * valid profile activation token to create the profile object to own the test
	 * @var $VALID_PROFILE_ACTIVATION_TOKEN
	 **/
	protected $VALID_PROFILE_ACTIVATION_TOKEN = "111111111111";

	/**
	 * invalid profile activation token to create the profile object to own the test
	 * @var $INVALID_PROFILE_ACTIVATION_TOKEN
	 **/
	protected $INVALID_PROFILE_ACTIVATION_TOKEN = "2222222222222";

	/**
	 * valid profile activation token to create the profile object to own the test
	 * @var $VALID_PROFILE_RECOVERY_TOKEN
	 **/
	protected $VALID_PROFILE_RECOVERY_TOKEN = "111111111111";

	/**
	 * invalid profile activation token to create the profile object to own the test
	 * @var $INVALID_PROFILE_RECOVERY_TOKEN
	 **/
	protected $INVALID_PROFILE_RECOVERY_TOKEN = "2222222222222";

	/**
	 * valid address1 to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ADDRESS1
	 */
	protected $VALID_PROFILE_ADDRESS1 = "4228 Courtney Ave NE";

	/**
	 * valid address2 to use to create the profile object to own the test
	 * @var string $VALID_PROFILE_ADDRESS2
	 */
	protected $VALID_PROFILE_ADDRESS2 = "Apt 302";

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
	 * Valid timestamp to use as sunriseProfileDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as sunsetProfileDate
	 */
	protected $VALID_SUNSETDATE = null;

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
	 * @var int $VALID_PROFILE_REPRESENTATIVE;
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
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);

		$this->district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);
		$this->district->insert($this->getPDO());

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));
		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}

	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS1);
		$this->assertEquals($pdoProfile->getProfileAddress2(), $this->VALID_PROFILE_ADDRESS2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileDateTime(), $profile->getProfileDateTime());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileRepresentative(), $this->VALID_PROFILE_REPRESENTATIVE);
		$this->assertEquals($pdoProfile->getProfileRecoveryToken(), $this->VALID_PROFILE_RECOVERY_TOKEN);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USER_NAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}


	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidProfile(): void {
		// create a Profile with a non null profile id and watch it fail
		$profile = new Profile("5", $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		//edit profile and update it in mySQL
		$profile->setProfileAddress1($this->VALID_PROFILE_ADDRESS_TEST);
		$profile->update($this->getPDO());
		$profile->setProfileZip($this->VALID_PROFILE_ZIP_TEST);
		$profile->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS_TEST);
		$this->assertEquals($pdoProfile->getProfileAddress2(), $this->VALID_PROFILE_ADDRESS2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileDateTime(), $profile->getProfileDateTime());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileRepresentative(), $this->VALID_PROFILE_REPRESENTATIVE);
		$this->assertEquals($pdoProfile->getProfileRecoveryToken(), $this->VALID_PROFILE_RECOVERY_TOKEN);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USER_NAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP_TEST);
	}

	/**
	 * test updating a Profile that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidProfile(): void {
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->update($this->getPDO());
	}

	/**
	 * test creating a Profile and then deleting it
	 **/
	public function testDeleteValidProfile(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
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
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->delete($this->getPDO());
	}

	/**
	 * test inserting a Profile and regrabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS1);
		$this->assertEquals($pdoProfile->getProfileAddress2(), $this->VALID_PROFILE_ADDRESS2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileDateTime(), $profile->getProfileDateTime());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileRepresentative(), $this->VALID_PROFILE_REPRESENTATIVE);
		$this->assertEquals($pdoProfile->getProfileRecoveryToken(), $this->VALID_PROFILE_RECOVERY_TOKEN);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USER_NAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

	/**
	 * test grabbing a Profile that does not exist
	 **/
	public function testGetInvalidProfileByProfileId(): void {
		// grab a profile id that is not valid
		$profile = Profile::getProfileByProfileId($this->getPDO(), TownhallTest::INVALID_KEY);
		$this->assertNull($profile);
	}

	/**
	 * test inserting a Profile and regrabbing it from mySQL by email
	 **/
	public function testGetValidProfileByProfileEmail(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$result = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		// grab the result from the array and validate it
		$pdoProfile = $result;
		$this->assertEquals($pdoProfile->getProfileDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS1);
		$this->assertEquals($pdoProfile->getProfileAddress2(), $this->VALID_PROFILE_ADDRESS2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileDateTime(), $profile->getProfileDateTime());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileRepresentative(), $this->VALID_PROFILE_REPRESENTATIVE);
		$this->assertEquals($pdoProfile->getProfileRecoveryToken(), $this->VALID_PROFILE_RECOVERY_TOKEN);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USER_NAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

	/**
	 * test grabbing a Profile with email that does not exist
	 **/
	public function testGetInvalidProfileByProfileEmail(): void {
		// grab a profile email that is not valid
		$profile = Profile::getProfileByProfileEmail($this->getPDO(),"xzy@qrs.abc");
		$this->assertNull($profile);
	}

	/**
	 * test inserting a Profile and regrabbing it from mySQL by username
	 **/
	public function testGetValidProfileByProfileUserName(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$result = Profile::getProfileByProfileUserName($this->getPDO(), $profile->getProfileUserName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		// grab the result from the array and validate it
		$pdoProfile = $result;
		$this->assertEquals($pdoProfile->getProfileDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS1);
		$this->assertEquals($pdoProfile->getProfileAddress2(), $this->VALID_PROFILE_ADDRESS2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileDateTime(), $profile->getProfileDateTime());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileRepresentative(), $this->VALID_PROFILE_REPRESENTATIVE);
		$this->assertEquals($pdoProfile->getProfileRecoveryToken(), $this->VALID_PROFILE_RECOVERY_TOKEN);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USER_NAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

	/**
	 * test grabbing a Profile with user name that does not exist
	 **/
	public function testGetInvalidProfileByUserName(): void {
		// grab a profile email that is not valid
		$profile = Profile::getProfileByProfileUserName($this->getPDO(), "unrowdyryan");
		$this->assertNull($profile);
	}

	public function testGetProfileByValidActivationToken(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$result = Profile::getProfileByActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		// grab the result from the array and validate it
		$pdoProfile = $result;
		$this->assertEquals($pdoProfile->getProfileDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS1);
		$this->assertEquals($pdoProfile->getProfileAddress2(), $this->VALID_PROFILE_ADDRESS2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileDateTime(), $profile->getProfileDateTime());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileRepresentative(), $this->VALID_PROFILE_REPRESENTATIVE);
		$this->assertEquals($pdoProfile->getProfileRecoveryToken(), $this->VALID_PROFILE_RECOVERY_TOKEN);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USER_NAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

	/**
	 * test grabbing a Profile with an invalid profile activation token that does not exist
	 **/
	public function testGetProfileByInvalidActivationToken(): void {
		// grab a profile email that is not valid
		$profile = Profile::getProfileByActivationToken($this->getPDO(), TownhallTest::INVALID_KEY);
		$this->assertNull($profile);
	}

	/**
	 * test grabbing Profiles by district ID
	 **/
	public function testGetValidProfileByProfileDistrictId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Tweet and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileDistrictId($this->getPDO(), $this->district->getDistrictId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Profile", $results);

		// grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS1);
		$this->assertEquals($pdoProfile->getProfileAddress2(), $this->VALID_PROFILE_ADDRESS2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileDateTime(), $profile->getProfileDateTime());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileRepresentative(), $this->VALID_PROFILE_REPRESENTATIVE);
		$this->assertEquals($pdoProfile->getProfileRecoveryToken(), $this->VALID_PROFILE_RECOVERY_TOKEN);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USER_NAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

	public function testGetValidProfileByRecoveryToken(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$result = Profile::getProfileByRecoveryToken($this->getPDO(), $profile->getProfileRecoveryToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		// grab the result from the array and validate it
		$pdoProfile = $result;
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS1);
		$this->assertEquals($pdoProfile->getProfileAddress2(), $this->VALID_PROFILE_ADDRESS2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileDateTime(), $profile->getProfileDateTime());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileRepresentative(), $this->VALID_PROFILE_REPRESENTATIVE);
		$this->assertEquals($pdoProfile->getProfileRecoveryToken(), $this->VALID_PROFILE_RECOVERY_TOKEN);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USER_NAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

	/**
	 * test grabbing a Profile with a recovery token that does not exist
	 **/
	public function testGetInvalidProfileByRecoveryToken(): void {
		// grab a recovery token that is invalid
		$profile = Profile::getProfileByRecoveryToken($this->getPDO(), TownhallTest::INVALID_KEY);
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a valid Profile by sunset and sunrise date
	 *
	 */
	public function testGetValidProfileBySunDate(): void {

			//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->district->getDistrictId(), $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_ADDRESS1, $this->VALID_PROFILE_ADDRESS2, $this->VALID_PROFILE_CITY, null, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME, $this->VALID_PROFILE_HASH, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_RECOVERY_TOKEN, $this->VALID_PROFILE_REPRESENTATIVE, $this->VALID_PROFILE_SALT, $this->VALID_PROFILE_STATE, $this->VALID_PROFILE_USER_NAME, $this->VALID_PROFILE_ZIP);
		$profile->insert($this->getPDO());

		// grab the profile from the database and see if it matches expectations
		$results = Profile::getProfileByProfileDate($this->getPDO(), $this->VALID_SUNRISEDATE, $this->VALID_SUNSETDATE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);

		//enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\Profile", $results);

		//use the first result to make sure that the inserted profile meets expectations
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileDistrictId(), $this->district->getDistrictId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileAddress1(), $this->VALID_PROFILE_ADDRESS1);
		$this->assertEquals($pdoProfile->getProfileAddress2(), $this->VALID_PROFILE_ADDRESS2);
		$this->assertEquals($pdoProfile->getProfileCity(), $this->VALID_PROFILE_CITY);
		$this->assertEquals($pdoProfile->getProfileDateTime(), $profile->getProfileDateTime());
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileRepresentative(), $this->VALID_PROFILE_REPRESENTATIVE);
		$this->assertEquals($pdoProfile->getProfileRecoveryToken(), $this->VALID_PROFILE_RECOVERY_TOKEN);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILE_SALT);
		$this->assertEquals($pdoProfile->getProfileState(), $this->VALID_PROFILE_STATE);
		$this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_PROFILE_USER_NAME);
		$this->assertEquals($pdoProfile->getProfileZip(), $this->VALID_PROFILE_ZIP);
	}

}

<?php

namespace Edu\Cnm\Townhall\Test;

use Edu\Cnm\Townhall\District;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Complete PHPUnit test for the District class
 *
 * want to test all mySQL/PDO enabled methods for both invalid and valid inputs
 *
 * - geojson to sql
 * - geocoded address within polygon
 * - match with district name
 * - return district name to profile
 *
 * @author Steven Hebert <shebert2@cnm.edu>
 *
 **/
class DistrictTest extends TownhallTest {
	/**
	 * @var string $VALID_DISTRICT_GEOM
	 *
	 **/
	protected $VALID_DISTRICT_GEOM = '{"type":"Polygon","coordinates":[[[0,0],[10,0],[10,10],[0,10],[0,0]]]}';

	/**
	 * @var string $VALID_DISTRICT_NAME
	 *
	 */
	protected $VALID_DISTRICT_NAME = "district1";

	/**
	 * @var string $VALID_DISTRICT_GEOM_4
	 *
	 **/
	protected $VALID_DISTRICT_GEOM_4 = '{"type":"Polygon","coordinates":[[[0,0],[10,0],[10,-10],[0,-10],[0,0]]]}';

	/**
	 * @var string $VALID_DISTRICT_NAME_4
	 *
	 */
	protected $VALID_DISTRICT_NAME_4 = "district4";

	/**
	 * @var string $INVALID_DISTRICT_GEOM
	 *
	 **/
	protected $INVALID_DISTRICT_GEOM = '{"type":"Polygon","coordinates":[[[181,0],[10,0],[10,-10],[0,-10],[181,0]]]}';

	/**
	 * @var string $VALID_LONG
	 *
	 **/
	protected $VALID_LONG = "5";

	/**
	 * @var string $VALID_LAT
	 *
	 **/
	protected $VALID_LAT = "5";

	/**
	 * create dependent objects before running each test
	 *
	 **/
	public final function setUp() {
		// run the setup method so the test can run properly
		// this is where all dependencies would be squashed so the test could be run properly.
		parent::setUp();
	}


	/**
	 * test valid INSERT district
	 *
	 **/
	public function testValidDistrictInsert(): void {
		// count number of rows for post test comparison
		$numRows = $this->getConnection()->getRowCount("district");

		// create district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);

		// insert into mySQL
		$district->insert($this->getPDO());

		// grab the data from MySQL and enforce that it meets expectations
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertJsonStringEqualsJsonString($pdoDistrict->getDistrictGeom(), $district->getDistrictGeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	}

	/**
	 * test invalid INSERT district
	 *
	 * @expectedException \PDOException
	 *
	 **/
	public function testInvalidDistrictInsert(): void {
		// create district object with an invalid districtId
		$district = new District(TownhallTest::INVALID_KEY, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);

		// try to insert district object with invalid districtId
		$district->insert($this->getPDO());
	}

	/**
	 * test valid UPDATE district
	 *
	 **/
	public function testValidDistrictUpdate(): void {
		// count number of rows for post test comparison
		$numRows = $this->getConnection()->getRowCount("district");

		// create district object
		// used polygon in first quadrant
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);

		//insert new object into mySQL
		$district->insert($this->getPDO());

		// set the new district object
		// changed district polygon to 4th quadrant poly
		$district->setDistrictGeom($this->VALID_DISTRICT_GEOM_4);

		// update the database
		$district->update($this->getPDO());

		// grab the district out of the database and enforce the object meets expectations
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertJsonStringEqualsJsonString($pdoDistrict->getDistrictGeom(), $district->getDistrictGeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	}

	/**
	 * test invalid UPDATE district
	 *
	 * @expectedException \PDOException
	 *
	 */
	public function testInvalidDistrictUpdate() {
		// create district object
		// don't insert object into database
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);

		//try to update district object that does not exist
		$district->update($this->getPDO());
	}


	/**
	 * test valid DELETE district
	 *
	 **/
	public function testValidDistrictDelete() {
		// count number of rows for post test comparison
		$numRows = $this->getConnection()->getRowCount("district");

		// create district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);

		//insert new object into mySQL
		$district->insert($this->getPDO());

		//count rows to verify new district added
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("district"));

		//delete the district from the database
		$district->delete($this->getPDO());

		//enforce that the deletion was successful
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());
		$this->assertNull($pdoDistrict);

		//count rows to verify new district was deleted
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("district"));
	}

	/**
	 * test invalid DELETE district
	 *
	 * @expectedException \PDOException
	 *
	 **/
	public function testInvalidDistrictDelete() {
		// create the quote object
		// don't insert the new object into mySQL
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);

		// try to delete the object without putting it into the db
		$district->delete($this->getPDO());
	}


	/**
	 * test valid GET district by districtId
	 *
	 **/
	public function testValidGetByDistrictId() {
		// count number of rows for post test comparison
		$numRows = $this->getConnection()->getRowCount("district");

		// create the district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);

		// insert new object into mySQL
		$district->insert($this->getPDO());

		// grab the district from the database and enforce that the object meets expectations
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertJsonStringEqualsJsonString($pdoDistrict->getDistrictGeom(), $district->getDistrictGeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	}

	/**
	 * test invalid GET district by districtId
	 * try to grab a district that doesn't exist
	 *
	 **/
	public function testInvalidGetByDistrictId() {
		// try to GET a district using an invalid districtId
		$district = District::getDistrictByDistrictId($this->getPDO(), TownhallTest::INVALID_KEY);
		// verify GET returned empty row
		$this->assertNull($district);
	}

	/**
	 * test valid GET by district by long lat
	 * testing to see if lat long exceptions work correctly
	 *
	 **/
	public function testValidGetDistrictByLongLat(): void {
		// create district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);

		//insert new object into mySQL
		$district->insert($this->getPDO());

		// grab the tweet from the database and see if it matches expectations
		$pdoDistrict = District::getDistrictByLongLat($this->getPDO(), $this->VALID_LONG, $this->VALID_LAT);

		$this->assertEquals($pdoDistrict->getDistrictName(),$district->getDistrictName());

		//enforce that no other objects are bleeding into the test
		//$this->assertContainsOnlyInstancesOf("Edu\Cnm\Townhall\Test", $results);
	}

	/**
	 * test invalid GET by district by long lat
	 *
	 **/
	public function testInvalidGetByLongLat(): void {
		// search for a district without one existing in the table
		$district = District::getDistrictByLongLat($this->getPDO(), "5", "5");
		$this->assertNull($district);
	}

	/**
	 * test grabbing all districts
	 *
	 **/
	public function testGetAllDistricts() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("district");
		// create a new Post and insert to into mySQL
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);
		$district->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = District::getAllDistricts($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Townhall\\District", $results);
		// grab the result from the array and validate it
		$pdoDistrict = $results[0];
		$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertJsonStringEqualsJsonString($pdoDistrict->getDistrictGeom(), $district->getDistrictGeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $this->VALID_DISTRICT_NAME);
	}
}

<?php

namespace Edu\Cnm\Townhall\Test;

use Edu\Cnm\Townhall\{
	District
};

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
	protected $VALID_DISTRICT_GEOM_4 = '{"type":"Polygon","coordinates":[[[0,0],[5,0],[7,7],[0,5],[0,0]]]}';

	/**
	 * @var string $VALID_DISTRICT_NAME_4
	 *
	 */
	protected $VALID_DISTRICT_NAME_4 = "district4";

	/**
	 * @var string $INVALID_DISTRICT_GEOM
	 *
	 **/
	protected $INVALID_DISTRICT_GEOM = '{"type":"Polygon","coordinates":[[[0,0],[10,0],[10,10],[0,10],[0,0]]]}';

	/**
	 * @var string $VALID_DISTRICT_NAME_4
	 *
	 */
	protected $INVALID_DISTRICT_NAME = "districtInvalidGeom";


	/**
	 * create dependent objects before running each test
	 *

	public final function setUp() {
		// run the setup method so the test can run properly
		// this is where all dependencies would be squashed so the test could be run properly.
		parent::setUp();
	}**/

	/**
	 * test valid INSERT district
	 *
	 **/
	public function testValidDistrictInsert(): void {
		// count number of row and save to compare after running test
		$numRows = $this->getConnection()->getRowCount("district");

		// create district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);
		// insert into mySQL
		$district->insert($this->getPDO());

		// grab the data from MySQL and enforce that it meets expectations
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		//$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertEquals($pdoDistrict->getDistrictGeom(), $district->getDistrictGeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	}

	/**
	 * test invalid INSERT district
	 *
	 **/
	public function testInvalidDistrictInsert(): void {
		$district = new District(TownhallTest::INVALID_KEY, $this->INVALID_DISTRICT_GEOM, $this->INVALID_DISTRICT_NAME);

		//
		$district->insert($this->getPDO());
	}


	/**
	 * test valid UPDATE district
	 *
	 **/
	public function testValidDistrictUpdate(): void {
		// count number of row and save to compare after running test
		$numRows = $this->getConnection()->getRowCount("district");

		// create district object and insert it back into the db
		// using the same polygon as "district1"
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);
		$district->insert($this->getPDO());

		// edit the district object then insert the object back into the database
		// changed district polygon to 4th quadrant poly
		$district->setDistrictGeom($this->VALID_DISTRICT_GEOM_4);
		$district->update($this->getPDO());

		// grab the district out of the database and enforce the object meets expectations
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertEquals($pdoDistrict->getDistrictGeom(), $district->getDistrictGeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	}

	/**
	 * test invalid UPDATE district
	 *
	 */
	public function testInvalidDistrictUpdate() {
		//create a new district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISTRICT_NAME);

		//try to update a district object that does not exist: "Area 51"
		$district->update($this->getPDO());
	}


	/**
	 * test valid DELETE district
	 *
	 **/
	public function testValidDistrictDelete() {
		// count number of row and save to compare after running test
		$numRows = $this->getConnection()->getRowCount("district");

		// create the district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->INVALID_DISTRICT_NAME);

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
	 **/
	public function testInvalidDistrictDelete() {
		//create the quote object
		//don't insert the new object into mySQL
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->INVALID_DISTRICT_NAME);

		//try to delete the object without putting it into the db
		$district->delete($this->getPDO());
	}


	/**
	 * test valid GET by districtId
	 *
	 **/
	public function testValidDistrictIDGet() {
		// count number of row and save to compare after running test
		$numRows = $this->getConnection()->getRowCount("district");

		//create the district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->INVALID_DISTRICT_NAME);

		//insert new object into mySQL
		$district->insert($this->getPDO());

		//grab the district from the database and enforce that the object meets expectations
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertEquals($pdoDistrict->getDistrictGeom(), $district->getDistrictgeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	}
	/**
	 * test invalid GET by districtId
	 * try to grab a district that doesn't exist
	 *
	 **/
	public function testInvalidDistrictIDGet() {
		//create the district object
		//don't insert the new object into mySQL
		$district = District::getDistrictByDistrictId($this->getPDO(), "9001");

		// verify GET returned empty row
		$this->assertEmpty($district);
	}
	/**
	 * test valid GET by districtId
	 *

	public function testValidDistrictNameGet() {
		// count number of row and save to compare after running test
		$numRows = $this->getConnection()->getRowCount("district");

		//create the district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->INVALID_DISTRICT_NAME);

		//insert new object into mySQL
		$district->insert($this->getPDO());

		//grab the district from the database and enforce that the object meets expectations
		$pdoDistrict = District::getDistrictByDistrictName($this->getPDO(), $district->getDistrictName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertEquals($pdoDistrict->getDistrictGeom(), $district->getDistrictGeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	} */

	/**
	 * test invalid GET by districtName
	 *
	 **/


	/*
	public function testValidDistrictGetAll() {
		// count number of row and save to compare after running test
		$numRows = $this->getConnection()->getRowCount("district");

		//create the district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->INVALID_DISTRICT_NAME);
		$district->insert($this->getPDO());

		//grab results from mySQL and enforce it meets expectations
		$results = District::getAllDistricts($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		$this->assertCount(1, $results);

		//grab the district from the database and enforce that the object meets expectations
		$pdoDistrict = $results[0];
		$this->assertEquals($pdoDistrict->getDistrictGeom(), $district->getDistrictgeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	} */
}
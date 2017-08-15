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
	 * @var array $VALID_DISTRICT_GEOM
	 *
	 **/
	protected $VALID_DISTRICT_GEOM = "ST_GeomFromText('Polygon((0 0,10 0,10 10,0 10,0 0))')";

	/**
	 * @var int $VALID_DISTRICT_ID
	 *
	 */
	protected $VALID_DISTRICT_ID = "1";

	/**
	 * @var string $VALID_DISTRICT_NAME
	 *
	 */
	protected $VALID_DISRICT_NAME = "district1";

	/**
	 * @var array $VALID_DISTRICT_GEOM_4
	 *
	 **/
	protected $VALID_DISTRICT_GEOM_4 = "ST_GeomFromText('Polygon((0 0,10 0,10 -10,0 -10,0 0))')";

	/**
	 * @var int $VALID_DISTRICT_ID_4
	 *
	 */
	protected $VALID_DISTRICT_ID_4 = "4";

	/**
	 * @var string $VALID_DISTRICT_NAME_4
	 *
	 */
	protected $VALID_DISRICT_NAME_4 = "district4";


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
	public function testInsertValidDistrict(): void {
		//count number of row and save to compare after running test
		$numrows = $this->getConnection()->getRowCount("district");

		////pretend to get District geojson and insert it into mySQL
		$district = new District($this->VALID_DISTRICT_ID, $this->VALID_DISTRICT_GEOM, $this->VALID_DISRICT_NAME);
		$district->insert($this->getPDO());

		//grab the data from MySQL and enforce that it meets expectations
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("district"));
		$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertEquals($pdoDistrict->getDistrictGeom(), $district->getDistrictGeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	}
	/**
	 * test invalid INSERT district
	 *
	 **/
	public function testInsertInvalidDistrict(): void {
		//create district with an id that already exists
		$district = new District("1", $this->VALID_DISTRICT_GEOM, $this->VALID_DISRICT_NAME);
		$district->insert($this->getPDO());
	}


	/**
	 * test valid UPDATE district
	 *
	 **/
	public function testUpdateValidDistrict(): void {
		// count number of row and save to compare after running test
		$numrows = $this->getConnection()->getRowCount("district");

		// create district object and insert it back into the db
		// using the same polygon as "district1"
		$district = new District("4", $this->VALID_DISTRICT_GEOM, $this->VALID_DISRICT_NAME);
		$district->insert($this->getPDO());

		// edit the district object then insert the object back into the database
		// changed district polygon to 4th quadrant poly
		$district->setDistrictGeom($this->VALID_DISTRICT_GEOM_4);
		$district->update($this->getPDO());

		// grab the quote out of the database and enforce the object meets expectations
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("quote"));
		$this->assertEquals($pdoDistrict->getDistrictId(), $district->getDistrictId());
		$this->assertEquals($pdoDistrict->getDistrictGeom(), $district->getDistrictgeom());
		$this->assertEquals($pdoDistrict->getDistrictName(), $district->getDistrictName());
	}
	/**
	 * test invalid UPDATE district
	 *
	 */
	public function testInvalidDistrictUpdate() {
		//create the district object
		$district = new District(null, $this->VALID_DISTRICT_GEOM, $this->VALID_DISRICT_NAME);

		//try to update a district object that does not exist: "Area 51"
		$district->update($this->getPDO());
	}


	/**
	 * test valid DELETE district
	 *
	 **/
	public function testValidQuoteDelete() {
		// count number of row and save to compare after running test
		$numrows = $this->getConnection()->getRowCount("district");

		// create the district object
		// not sure if we can keep using the same VALID_data???
		// are methods dropped after running each unit test???
		// i'm purposely making this long so that I don't overlook it
		// and forget that I need to ask for clarification HERE
		//												accidentally 	added misspelled "clarification" to homePC dictionary, need to get that out...
		// and waste a bunch of time figuring out a user unit test error /fail
		$district = new District("2", "ST_GeomFromText('Polygon((0 0,-10 0,-10 10,0 10,0 0))')", "district2");
		$district->insert($this->getPDO());

		//delete the district from the database
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("district"));
		$district->delete($this->getPDO());

		//enforce that the deletion was successful
		$pdoDistrict = District::getDistrictByDistrictId($this->getPDO(), $district->getDistrictId());
		$this->assertNull($pdoDistrict);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("district"));
	}
	/**
	 * test invalid DELETE district
	 *
	 **/
	public function testInvalidDistrictDelete() {
		//create the quote object
		$district = new District("2", "ST_GeomFromText('Polygon((0 0,-10 0,-10 10,0 10,0 0))')", "district2");

		//try to delete the object without putting it into the db
		$district->delete($this->getPDO());
	}


	/**
	 * test invalid GET district
	 *
	 **/
}
/**
 * test invalid GET district
 *
 **/
}

}
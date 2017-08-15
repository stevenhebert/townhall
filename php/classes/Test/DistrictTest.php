<?php

namespace Edu\Cnm\Townhall\Test;

use Edu\Cnm\Townhall\{District};

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
 **/
class DistrictTest extends TownhallTest {
	/**
	 * @var geom $VALID_DISTRICT_GEOM
	 **/
	protected $VALID_DISTRICT_GEOM = "ST_GeomFromText('Polygon((0 0,10 0,10 10,0 10,0 0))')";

	/**
	 * @var int $VALID_DISTRICT_ID
	 */
	protected $VALID_DISTRICT_ID = "2";

	/**
	 * @var string $VALID_DISTRICT_NAME
	 */
	protected $VALID_DISRICT_NAME = "district2";

	/** create dependent objects before running each test
	 **/
	public final function setUp() {
		// run the setup method so the test can run properly
		// this is where all dependencies would be squashed so the test could be run properly.
		parent::setUp();
	}

	/**
	 * test inserting a district and verify that the actual mySQL data matches
	 **/
	public function testInsertValidDistrict(): void {

		//count number of row and save to compare after running test
		$numrows = $this->getConnection()->getRowCount("district");

		//get District geojson and insert it into mySQL
		////pretend to get District geojson and insert it into mySQL
		$district = new District($this->VALID_DISTRICT_ID, $this->VALID_DISTRICT_GEOM, $this->VALID_DISRICT_NAME);
}

	/**
	 * test inserting a district that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidDistrict(): void {
		//create district with an id that already exists
		$district = new District("2", "ST_GeomFromText('Polygon((0 0,10 0,10 -10,0 -10,0 0))');", "district3");
		$district->insert($this->getPDO());
}

/**
 * test inserting a Tweet, editing it, and then updating it
 **/
}

/**
 * test updating a Tweet that already exists
 *
 * @expectedException \PDOException
 **/
}

/**
 * test creating a Tweet and then deleting it
 **/
}

/**
 * test deleting a Tweet that does not exist
 *
 * @expectedException \PDOException
 **/
}

/**
 * test inserting a Tweet and regrabbing it from mySQL
 **/
}

/**
 * test grabbing a Tweet that does not exist
 **/
}

/**
 * test inserting a Tweet and regrabbing it from mySQL
 **/
}

/**
 * test grabbing a Tweet that does not exist
 **/
}

/**
 * test grabbing a Tweet by tweet content
 **/
}

/**
 * test grabbing a Tweet by content that does not exist
 **/
}

/**
 * test grabbing a valid Tweet by sunset and sunrise date
 *
 */
}

/**
 * test grabbing all Tweets
 **/
}
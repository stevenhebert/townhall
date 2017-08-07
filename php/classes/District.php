<?php

namespace Edu\Cnm\Townhall;

/**
 * District Class
 * This class stores each districts geometric data and the name of the district
 * Referenced by Profile and Post
 *
 * @author Steven Hebert <shebert2@cnm.edu>
 * @version 1.0
 */

class District implements \JsonSerializable {
	/**
	 * id for this district
	 * this is the primary key
	 * @var int districtId
	 */
	private $districtId;

	/**
	 * geometry for this district
	 * @var geometry districtGeom
	 *
	 */
	private $districtGeom;

	/**
	 * name of this district
	 * @var string districtName
	 */
	private $districtName;
}
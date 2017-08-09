<?php

namespace Edu\Cnm\Townhall;

/**
 * District Class
 * This class stores each districts geometric data and the name of the district
 * Referenced by Profile and Post
 *
 * Accessor to be read from to determine users district
 *
 * Mutator writes district polygons to database
 *
 * @author Steven Hebert <shebert2@cnm.edu>
 * @version 1.0
 **/

class District {
	/**
	 * id for this district
	 * this is the primary key
	 * @var int districtId
	 **/
	private $districtId;

	/**
	 * geometry for this district
	 * @var geom districtGeom
	 *
	 **/
	private $districtGeom;

	/**
	 * name of this district
	 * @var string districtName
	 *
	 **/
	private $districtName;

	/** constructor for this district
	 * @param int $newDistrictId
	 * @param geometry $newDistrictGeom
	 * @param string $newDistrictName
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 *
	 **/
public fucntion __construct(?int $new)
	/**
	 * accessor for district id
	 *
	 * return int | null value of districtId
	 * lets user know to which district they belong
	 *
	 **/
	public function getDistrictId(): int {
		return ($this->districtId);
	}

	/**
	 * mutator method for district id
	 *
	 * @param int | null $newDistrictId value of new district id
	 * associates districts with their respective polygon
	 * who is receiving these exceptions if geojsons are imported into mysql automagically?
	 *
	 **/
	public function setDistrictId(int $newDistrictId): void {
//void if district id is null - assuming this means all polygons have been assigned - want to stop process
		if($newdistrictId === null) {
			$this->districtId = null;
			return;
		}
//verify that the districtId is positive
		if($newDistrictId <= 0) {
			throw(new \RangeException("district id not positive"));
		}
		//convert and store the districtId
		$this->districtId = $newDistrictId;
	}


	/**
	 * accessor for districtGeom
	 *
	 * @return geometry value (no longer array) of districtGeom
	 * reads district geometry data in order to run contains fn
	 * -> conceptually is the contains fn calling this from php or from mysql?
	 * ->-> if the latter, will this accessor actually be used?
	 *
	 **/
	public function getDistrictGeom(): array {
		return ($this->districtGeom);
	}

	/**
	 * mutator for districtGeom
	 *
	 * @param geometry $newDistrictGeom
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 *
	 * @notsureif /RangeException thinking this would be the bounds of lat, long coordinates "[180 180, -180 -180]"
	 *
	 * used for grabbing coordinates from ABQOpenData and INSERTing them into mySQL
	 *
	 * @@@@needAcheck for verifying the coordinate from a circuit (closed perimeter)
	 *
	 * @needAflag for multipoint polygons (polgons with holes! e.g.) Baarle Nassue);
	 *   assuming this would cause issues with ST_contains
	 *
	 * cant be null
	 * cant be empty
	 *
	 *
	 *
	 **/
	/**   public function setDistrictGeom(array $newDistrictGeom): void {
	 * if(empty($newDistrictGeom) === true) {
	 * throw(new \InvalidArgumentException())}
	 * }
	 **/


	public function isValidLatitude(float $newLat): bool {
		if($newLat < -90 || $newLat > 90) {
			throw(new \RangeException("lat not within valid range"));
		} else {
			return true;
		}
	}

	public function isValidLongitude(float $newLong): bool {
		if($newLong < -180 || $newLong > 180) {
			throw(new \RangeException("long not within valid range"));
		} else {
			return true;
		}
	}

}


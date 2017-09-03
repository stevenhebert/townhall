<?php

namespace Edu\Cnm\TownHall;

require_once("autoload.php");


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
 *
 **/
class District implements \JsonSerializable {

	/**
	 * id for this district
	 * this is the primary key
	 * @var int districtId
	 *
	 **/
	private $districtId;

	/**
	 * geometry for this district
	 * @var string districtGeom
	 *
	 **/
	private $districtGeom;

	/**
	 * name of this district
	 * @var string districtName
	 *
	 **/
	private $districtName;

	/**
	 * constructor for this district
	 *
	 * @param int $newDistrictId
	 * @param string $newDistrictGeom
	 * @param string $newDistrictName
	 *
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 *
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 *
	 **/
	public function __construct(?int $newDistrictId, string $newDistrictGeom, string $newDistrictName) {
		try {
			$this->setDistrictId($newDistrictId);
			$this->setDistrictGeom($newDistrictGeom);
			$this->setDistrictName($newDistrictName);
		} //determine what exception was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor for district id
	 *
	 * @return int | null value of districtId
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
	 * associates districts with their respective polygons
	 *
	 **/
	public function setDistrictId(?int $newDistrictId): void {
		//void if district id is null
		if($newDistrictId === null) {
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
	 * @return string value (no longer array) of districtGeom
	 *
	 **/
	public function getDistrictGeom(): string {
		return ($this->districtGeom);
	}

	/**
	 * mutator for districtGeom
	 *
	 * @param string $newDistrictGeom
	 * @throws \Exception if some other exception occurs
	 * @throws \RangeException if point has more than two elements (lat, long, ?)
	 * @throws \TypeError if data types violate type hints
	 *
	 **/
	public function setDistrictGeom(string $newDistrictGeom): void {
		// create temporary object

		$geomObject = json_decode($newDistrictGeom);
		if(empty($geomObject) === true) {
			throw(new \InvalidArgumentException("geom object empty or invalid"));
		}

		foreach($geomObject->coordinates[0] as $coordinates) {
			if(count($coordinates) !== 2) {
				throw(new \RangeException("more than two coordinates given"));
			}
			try {
				self::validateLatitude($coordinates[1]);
				self::validateLongitude($coordinates[0]);
			} catch(\Exception | \RangeException | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
			$this->districtGeom = $newDistrictGeom;
		}
	}


	/**
	 * helper methods for coordinate range validation
	 * @returns float $newLat
	 * @throws \RangeException if (-90 > lat > 90)
	 *
	 **/

	public static function validateLatitude(float $newLat): float {
		if($newLat < -90|| $newLat > 90) {
			throw(new \RangeException("lat not within valid range"));
		} else {
			return $newLat;
		}
	}

	/**
	 * helper methods for coordinate range validation
	 * @returns float $newLong
	 * @throws \RangeException if (-180 > long > 180)
	 *
	 **/

	public static function validateLongitude(float $newLong): float {
		if($newLong < -180 || $newLong > 180) {
			throw(new \RangeException("long not within valid range"));
		} else {
			return $newLong;
		}
	}

	/**
	 * accessor method for districtName
	 *
	 * @return string for name of district
	 *
	 */
	public function getDistrictName(): string {
		return ($this->districtName);
	}

	/**
	 * mutator method for districtName
	 *
	 * @return string for name of district
	 *
	 */
	public function setDistrictName(string $newDistrictName): void {
		// verify the districtName is valid
		if(strlen($newDistrictName) > 64) {
			throw(new \RangeException("name is too long"));
		}
		$this->districtName = $newDistrictName;
	}

	/**
	 * inserts the districts into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 **/
	public function insert(\PDO $pdo): void {
		//enforce the district id is null b/c dont want to insert into a district that already exists
		if($this->districtId !== null) {
			throw(new \PDOException("districtId already assigned"));
		}

		$query = "INSERT INTO district(districtGeom, districtName) VALUES (ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON(:districtGeom))), :districtName)";

		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["districtGeom" => $this->districtGeom, "districtName" => $this->districtName];
		$statement->execute($parameters);
		//update the null districtId with what mySQL returns
		$this->districtId = intval($pdo->lastInsertId());

	}

	/**
	 * deletes this district from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 *
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 **/
	public function delete(\PDO $pdo): void {
		//enforce the districtId is not null, cant delete something that doesn't exist
		if($this->districtId === null) {
			throw(new \PDOException("district not found, unable to delete"));
		}
		//create a query template
		$query = "DELETE FROM district WHERE districtId = :districtId";
		$statement = $pdo->prepare($query);
		//bind the district variables to the placeholders
		$parameters = ["districtId" => $this->districtId];
		$statement->execute($parameters);
	}

	/**
	 * updates this district in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 *
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 */
	public function update(\PDO $pdo): void {
		//enforce the districtId is not null, cant update a district if it doesn't exist
		if($this->districtId === null) {
			throw(new \PDOException("district not found, unable to delete"));
		}
		//create new query template and don't delete the bloody primary key
		$query = "UPDATE district SET districtGeom = ST_GeomFromGeoJSON(:districtGeom), districtName = :districtName WHERE districtId = :districtId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template

		$parameters = ["districtId" => $this->districtId, "districtGeom" => $this->districtGeom, "districtName" => $this->districtName];
		$statement->execute($parameters);
	}

	/**
	 * get district by districtId
	 *
	 * @param \PDO $pdo connection object
	 * @param int $districtId to search for
	 *
	 * @return district | null
	 *
	 * @throws \PDOException when mySQL error occur
	 * @throws \TypeError when variables are not the correct data type
	 *
	 */
	public static function getDistrictByDistrictId(\PDO $pdo, int $districtId): ?district {
		//negative district id absurd
		if($districtId <= 0) {
			throw(new \PDOException("districtId is not positive"));
		}
		//create query template
		$query = "SELECT districtId, ST_AsGeoJson(districtGeom), districtName FROM district WHERE districtId = :districtId";

		$statement = $pdo->prepare($query);
		//bind the districtId ti the place holder in the template
		$parameters = ["districtId" => $districtId];

		$statement->execute($parameters);
		//get district from mySQL
		try {
			$district = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$district = new District($row["districtId"], $row["ST_AsGeoJson(districtGeom)"], $row["districtName"]);
			}
		} catch(\Exception $exception) {
			//if row can't be converted re-throw it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($district);
	}

	/**
	 * GET district by Long Lat
	 *
	 * @param \PDO $pdo connection object
	 * @param int $districtId to search for
	 *
	 * @returns district | null
	 *
	 * @throws \PDOException when mySQL error occurs
	 * @throws \TypeError when variables are not the correct data type
	 *
	 */
	public static function getDistrictByLongLat(\PDO $pdo, float $longitude, float $latitude): ?district {
		// create temporary object
		try {
			self::validateLatitude($latitude);
			self::validateLongitude($longitude);
		} catch(\Exception | \RangeException | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query
		$query = "SELECT districtId, ST_AsGeoJson(districtGeom), districtName FROM district WHERE ST_CONTAINS(districtGeom, POINT(:longitude, :latitude)) = 1";
		$statement = $pdo->prepare($query);
		$parameters = ["longitude" => strval($longitude), "latitude" => strval($latitude)];
		$statement->execute($parameters);

		try {
			$district = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$district = new District($row["districtId"], $row["ST_AsGeoJson(districtGeom)"], $row["districtName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($district);
	}

	public static function getAllDistricts(\PDO $pdo): \SplFixedArray {
		//create query template
		$query = $query = "SELECT districtId, ST_AsGeoJson(districtGeom), districtName FROM district";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of districts
		$districts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$district = new District($row["districtId"], $row["ST_AsGeoJson(districtGeom)"], $row["districtName"]);
				$districts[$districts->key()] = $district;
				$districts->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($districts);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		unset($fields["districtGeom"]);
		return ($fields);
	}
}


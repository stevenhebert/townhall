<?php

namespace Edu\Cnm\Townhall;

require_once("autoload.php");


/**
 * Class for townhall post
 *
 * A post can be created when a user logs on to townhall.
 * Posts can be created in response to other posts.
 *
 * This is one of four classes in the townhall application
 * that allows people to create a profile in their district,
 * create a post, comment on posts, and vote on posts
 *
 * @author Leonora Sanchez-Rees <leonora621@yahoo.com>
 * @version 1.0.0
 **/
class Post implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for this post; this is the primary key
	 * @var int $postId
	 **/
	private $postId;
	/**
	 * id of the district of the profile who created post
	 * This may change if the person moves to a different district,
	 * so original district will be stored on the post
	 * @var int $postDistrictId
	 **/
	private $postDistrictId;
	/**
	 * id of the post that this post is responding to.  There
	 * may or may not be a parent post.  This class will only
	 * have a value if this a response to another post
	 *
	 * @var int $postParentId
	 **/
	private $postParentId;
	/**
	 * id of the profile/person who created the post
	 * @var int $postProfileId
	 */
	private $postProfileId;
	/**
	 * content of the post
	 * @var string $postContent
	 **/
	private $postContent;
	/**
	 * timestamp of the post.  will be added by the database
	 * @var \DateTime $postDateTime
	 **/
	private $postDateTime;

	/**
	 * constructor for Post
	 *
	 * @param int | null $newPostId id of this post or null if a new post
	 * @param int $newPostDistrictId id of the district the person who made the post lives in at the time of the post
	 * @param int | null $newPostParentId id of the post being commented on, null if none
	 * @param int $newPostProfileId id of the person making the post
	 * @param string $newPostContent content of the new post
	 * @param \DateTime | null $newPostDateTime timestamp of the post
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Doumentation:  https://php.net/manual/en/language.oop5.decon.php
	 *
	 **/
	public function __construct(?int $newPostId, int $newPostDistrictId, ?int $newPostParentId, int $newPostProfileId, string $newPostContent, $newPostDateTime = null) {
		try {
			$this->setPostId($newPostId);
			$this->setPostDistrictId($newPostDistrictId);
			$this->setPostParentId($newPostParentId);
			$this->setPostProfileId($newPostProfileId);
			$this->setPostContent($newPostContent);
			$this->setPostDateTime($newPostDateTime);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \ RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor for post id
	 *
	 * @return int | null value of post id
	 **/
	public function getPostId(): int {
		return ($this->postId);
	}

	/**
	 * mutator method for post id
	 *
	 * @param int | null $newPostId new value of post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newPostId is not an integer
	 **/
	public function setPostId(?int $newPostId): void {
		//if post id is null immediately return it
		if($newPostId === null) {
			$this->postId = null;
			return;
		}

		//verify that the post id is positive
		if($newPostId < 0) {
			throw(new \RangeException("post id is not positive"));
		}

		//convert and store the post id
		$this->postId = $newPostId;
	}

	/**
	 * accessor method for post district id
	 * @return int value of post district id
	 **/
	public function getPostDistrictId(): int {
		return ($this->postDistrictId);
	}

	/**
	 * mutator method for post district id
	 *
	 * @param int $newPostDistrictId new value of post district id
	 * @throws \RangeException if $newPostDistrictId is not positive
	 * @throws \TypeError if $newPostDistrictId is not an integer
	 *
	 **/
	public function setPostDistrictId(int $newPostDistrictId): void {

		//verify the post district id is positive
		if($newPostDistrictId <= 0) {
			throw(new \RangeException("post district id is not positive"));
		}

		//convert and store the post district id
		$this->postDistrictId = $newPostDistrictId;

	}

	/**
	 * accessor method for post parent id
	 *
	 * @return int | null value of post parent id
	 **/

	public function getPostParentId(): ?int {
		return ($this->postParentId);
	}

	/**
	 * mutator method for post parent id
	 *
	 * @param int | null $newPostParentId new value of post parent id
	 * @throws \RangeException if $newPostParentId is not positive
	 * @throws \TypeError if $newPostParentId is not an integer
	 **/
	public function setPostParentId(?int $newPostParentId): void {
		//if post parent id is null immediately return it
		if($newPostParentId === null) {
			$this->postParentId = null;
			return;
		}

		//verify the post parent id is positive
		if($newPostParentId <= 0) {
			throw(new \RangeException("post parent id is not positive"));
		}

		//convert and store the post parent id
		$this->postParentId = $newPostParentId;
	}


	/**
	 * accessor method for post profile id
	 *
	 * @return int value of post profile id
	 **/
	public function getPostProfileId(): int {
		return ($this->postProfileId);
	}

	/**mutator method for post profile id
	 *
	 * @param int $newPostProfileId new value of post profile id
	 * @throws \RangeException if $newPostProfileId is not positive
	 * @throws \TypeError if $newPostProfileId is not an integer
	 **/
	public function setPostProfileId(int $newPostProfileId): void {

		//verify the profile id is positive
		if($newPostProfileId <= 0) {
			throw(new \RangeException("post profile id is not positive"));
		}

		//convert and store the profile id
		$this->postProfileId = $newPostProfileId;
	}

	/**
	 * accessor method for post content
	 *
	 * @return string value of post content
	 **/
	public function getPostContent(): string {
		return ($this->postContent);
	}

	/**
	 * mutator method for post content
	 *
	 * @param string $newPostContent new value of post content
	 * @throws \InvalidArgumentException if $newPostContent is not a string or insecure
	 * @throws \RangeException if $newPostContent > 8192 characters
	 * @throws \TypeError if $newPostContent is not a string
	 *
	 **/
	public function setPostContent(string $newPostContent): void {
		//verify the post content is secure
		$newPostContent = trim($newPostContent);
		$newPostContent = filter_var($newPostContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostContent) === true) {
			throw(new \InvalidArgumentException("post content is empty or insecure"));
		}

		//verify the post content will fit in the database
		if(strlen($newPostContent) > 8192) {
			throw(new \RangeException("post content too large"));
		}

		//store the post content
		$this->postContent = $newPostContent;
	}

	/*
	 * accessor method for postDateTime
	 *
	 * @return \DateTime value of post date and time
	 **/
	public function getPostDateTime(): \DateTime {
		return ($this->postDateTime);
	}

	/**
	 * mutator method for post date time
	 *
	 * @param \DateTime |string |null $newPostDateTime post date time as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newPostDateTime is not a valid object or string
	 * @throws \RangeException if $newPostDateTime is a date that does not exist
	 *
	 **/
	public function setPostDateTime($newPostDateTime = null): void {
		//base case:  if the date is null, wait for mySQL
		if($newPostDateTime === null) {
			$this->postDateTime = null;
			return;
		}

		//store the post date using the ValidateDate trait
		try {
			$newPostDateTime = self::validateDateTime($newPostDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->postDateTime = $newPostDateTime;
	}

	/**
	 * inserts post into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL-related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		//enforce the postId is null. (i.e., don't insert a post that already exists.)
		if($this->postId !== null) {
			throw(new \PDOException("not a new post"));
		}
		//create a query template
		$query = "INSERT INTO post(postDistrictId, postParentId, postProfileId, postContent) VALUES (:postDistrictId, :postParentId, :postProfileId, :postContent)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["postDistrictId" => $this->postDistrictId, "postParentId" => $this->postParentId, "postProfileId" => $this->postProfileId, "postContent" => $this->postContent];
		$statement->execute($parameters);

		//update the null postId with what mySQL just gave us
		$this->postId = intval($pdo->lastInsertId());

		// generate a timestamp
		$tempPost = Post::getPostByPostId($pdo, $this->postId);
		$this->setPostDateTime($tempPost->getPostDateTime());
	}

	/**
	 * deletes this post from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		//enforce the postId is not null (i.e., don't delete a post that hasn't been inserted).
		if($this->postId === null) {
			throw(new \PDOException("unable to delete a post that doesn't exist"));
		}

		//create a query template
		$query = "DELETE FROM post WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["postId" => $this->postId];
		$statement->execute($parameters);
	}


	/**
	 * updates the post in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		//enforce the postId is not null (don't update a post that hasn't been inserted
		if($this->postId === null) {
			throw(new \PDOException("unable to update post that doesn't exist"));
		}

		//create query template
		$query = "UPDATE post SET postDistrictId = :postDistrictId, postParentId = :postParentId, postProfileId = :postProfileId, postContent = :postContent WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["postDistrictId" => $this->postDistrictId, "postParentId" => $this->postParentId, "postProfileId" => $this->postProfileId, "postContent" => $this->postContent, "postId" => $this->postId];
		$statement->execute($parameters);
		// update the auto generated timestamp
		$tempPost = Post::getPostByPostId($pdo, $this->postId);
		$this->setPostDateTime($tempPost->getPostDateTime());

	}

	/**
	 * GET the post by postId
	 *
	 * @param \PDO $pdo connection object
	 * @param int $postId to search for
	 * @return Post | null Post found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostId(\PDO $pdo, int $postId): ?Post {


		//sanitize the PostId before searching
		if($postId <= 0) {
			throw(new \PDOException("post Id is not positive"));
		}

		//create query template
		$query = "SELECT postId, postDistrictId, postParentId, postProfileId, postContent, postDateTime FROM post WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		//bind the post id to the place holder in the template
		$parameters = ["postId" => $postId];
		$statement->execute($parameters);

		//grab post from mySQL
		try {
			$post = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$post = new Post($row["postId"], $row["postDistrictId"], $row["postParentId"], $row["postProfileId"], $row["postContent"], $row["postDateTime"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($post);
	}

	/**
	 * GET the post by postDistrictId
	 *
	 * @param \PDO $pdo connection object
	 * @param int $postDistrictId to search for
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostDistrictId(\PDO $pdo, int $postDistrictId): \SplFixedArray {
		//sanitize the postDistrictId before searching
		if($postDistrictId <= 0) {
			throw(new \PDOException("post District Id is not positive"));
		}

		//create query template
		$query = "SELECT postId, postDistrictId, postParentId, postProfileId, postContent, postDateTime FROM post WHERE postDistrictId = :postDistrictId";
		$statement = $pdo->prepare($query);

		//bind the post district id to the place holder in the template
		$parameters = ["postDistrictId" => $postDistrictId];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postDistrictId"], $row["postParentId"], $row["postProfileId"], $row["postContent"], $row["postDateTime"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($posts);
	}

	/**
	 * GET the post by postParentId
	 *
	 * @param \PDO $pdo connection object
	 * @param int $postParentId to search for
	 * @return \SplFixedArray of posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostParentId(\PDO $pdo, int $postParentId): \SplFixedArray {
		//sanitize the postDistrictId before searching
		if($postParentId <= 0) {
			throw(new \PDOException("post Parent Id is not positive"));
		}

		//create query template
		$query = "SELECT postId, postDistrictId, postParentId, postProfileId, postContent, postDateTime FROM post WHERE postParentId = :postParentId";
		$statement = $pdo->prepare($query);

		//bind the post district id to the place holder in the template
		$parameters = ["postParentId" => $postParentId];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postDistrictId"], $row["postParentId"], $row["postProfileId"], $row["postContent"], $row["postDateTime"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($posts);
	}

	/**
	 * GET the post by postProfileId
	 *
	 * @param \PDO $pdo connection object
	 * @param int $postProfileId to search for
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostProfileId(\PDO $pdo, int $postProfileId): \SplFixedArray {
		//sanitize the postProfileId before searching
		if($postProfileId <= 0) {
			throw(new \PDOException("post Profile Id is not positive"));
		}

		//create query template
		$query = "SELECT postId, postDistrictId, postParentId, postProfileId, postContent, postDateTime FROM post WHERE postProfileId = :postProfileId";
		$statement = $pdo->prepare($query);

		//bind the post profile id to the place holder in the template
		$parameters = ["postProfileId" => $postProfileId];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postDistrictId"], $row["postParentId"], $row["postProfileId"], $row["postContent"], $row["postDateTime"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($posts);
	}


	/**
	 * GET the post by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $postContent post content to search for
	 * @return \SplFixedArray SPLFixedArray of posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostContent(\PDO $pdo, string $postContent): \SplFixedArray {
		//sanitize the description before searching
		$postContent = trim($postContent);
		$postContent = filter_var($postContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($postContent) === true) {
			throw(new \PDOException("post content is invalid"));
		}

		//escape any mySQL wild cards
		$postContent = str_replace("_", "\\_", str_replace("%", "\\%", $postContent));

		//create query template
		$query = "SELECT postId, postDistrictId, postParentId, postProfileId, postContent, postDateTime FROM post WHERE postContent LIKE :postContent";
		$statement = $pdo->prepare($query);

		//bind the post content to the place holder in the template
		$postContent = "%$postContent";
		$parameters = ["postContent" => $postContent];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postDistrictId"], $row["postParentId"], $row["postProfileId"], $row["postContent"], $row["postDateTime"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($posts);
	}


	/**
	 * GET an array of posts by postDateTime
	 *
	 * @param \PDO $pdo connection object
	 * @param \DateTime $sunrisePostDate beginning date of search
	 * @param \DateTime $sunsetPostDate ending date of search
	 * @return \SplFixedArray of posts found
	 * @throws \PDOException error when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @throws \InvalidArgumentException if either sun dates are in the wrong format
	 **/
	public static function getPostByPostDate(\PDO $pdo, $sunrisePostDate, $sunsetPostDate): \SplFixedArray {
		//enforce both dates are present
		if((empty($sunrisePostDate) === true) || (empty($sunsetPostDate) === true)) {
			throw(new \InvalidArgumentException("dates are empty or insecure"));
		}

		//ensure both dates are in the correct format and are secure
		try {
			$sunrisePostDate = self::validateDateTime($sunrisePostDate);
			$sunsetPostDate = self::validateDateTime($sunsetPostDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT postId, postDistrictId, postParentId, postProfileId, postContent, postDateTime FROM post WHERE postDateTime >= :sunrisePostDate AND postDateTime <= :sunsetPostDate";
		$statement = $pdo->prepare($query);

		//format the dates so that mySQL can use them
		$formattedSunriseDate = $sunrisePostDate->format("Y-m-d H:i:s.u");
		$formattedSunsetDate = $sunsetPostDate->format("Y-m-d H:i:s.u");


		$parameters = ["sunrisePostDate" => $formattedSunriseDate, "sunsetPostDate" => $formattedSunsetDate];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postDistrictId"], $row["postParentId"], $row["postProfileId"], $row["postContent"], $row["postDateTime"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($posts);
	}

	/**
	 * get all posts
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of posts found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllPosts(\PDO $pdo): \SplFixedArray {
		//create query template
		$query = "SELECT postId, postDistrictId, postParentId, postProfileId, postContent, postDateTime FROM post";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postDistrictId"], $row["postParentId"], $row["postProfileId"], $row["postContent"], $row["postDateTime"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($posts);
	}

	/*
	* needed to add the microsecond to the postDateTime field
	*
	* @param $fields object to process postDateTime
	*
	*/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		//format the data so that the front end can consume it
		$fields["postDateTime"] = round(floatval($this->postDateTime->format("U.u")) * 1000);
		return ($fields);
	}

}
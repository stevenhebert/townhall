<?php


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
class Post  {
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
	 * timestamp of the post
	 * @var \DateTime $postDateTime
	 **/
	private $postDateTime;
	/**
	 * constructor for Post
	 **/

	/**
	 * accessor for post id
	 *
	 * @return int | null value of post id
	 **/
	public function getPostId() : int {
		return($this->postId);
	}
	/**
	 * mutator method for post id
	 *
	 * @param int | null $newPostId new value of post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newPostId is not an integer
	 **/
	public function setPostId(?int $newPostId) : void {
		//if post id is null immediately return it
		if($newPostId === null) {
			$this->postId = null;
			return;
		}

		//verify that the post id is positive
		if($newPostId <= 0) {
			throw(new \RangeException("post id is not positive"));
		}

		//convert and store the post id
		$this->postId = $newPostId;
	}
	/**
	 * accessor method for post district id
	 * @return int value of post district id
	 **/
	public function getPostDistrictId() : int {
		return($this->postDistrictId);
	}
	/**
	 * mutator method for post district id
	 *
	 * @param int $newPostDistrictId new value of post district id
	 * @throws \RangeException if $newPostDistrictId is not positive
	 * @throws \TypeError if $newPostDistrictId is not an integer
	 *
	 **/
	public function setPostDistrictId(int $newPostDistrictId) : void {

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

public function getPostParentId() : int {
	return($this->postParentId);
}

/**
 * mutator method for post parent id
 *
 * @param int | null $newPostParentId new value of post parent id
 * @throws \RangeException if $newPostParentId is not positive
 * @throws \TypeError if $newPostParentId is not an integer
 **/
public function setPostParentId(?int $newPostParentId) : void {
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
	public function getPostProfileId() : int {
		return($this->postProfileId);
	}
	/**mutator method for post profile id
	 *
	 * @param int $newPostProfileId new value of post profile id
	 * @throws \RangeException if $newPostProfileId is not positive
	 * @throws \TypeError if $newPostProfileId is not an integer
	 **/
	public function setPostProfileId(int $newPostProfileId) : void {

		//verify the profile id is positive
		if($newPostProfileId <= 0 ) {
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
	public function getPostContent() : string {
		return($this->postContent);
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
	public function setPostContent(string $newPostContent) : void {
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






}
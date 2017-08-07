<?php
namespace Edu\Cnm\townhall;

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
	 * @var int $districtId
	**/
	private $districtId;
/**
 * id of the post that this post is responding to.  There
 * may or may not be a parent post.  This class will only
 * have a value if this a response to another post.
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
	 * @var string $postDateTime
	 **/
	private $postDateTime;


}
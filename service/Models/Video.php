<?php
namespace Models;
class Video
{
	const COL_ID = 'id';
	const COL_NAME = 'name';
	const COL_COMMENT = 'comment';
	const COL_THUMBNAIL = 'thumbnail';
	const COL_CREATEDAT = 'createdAt';
	const COL_LINK = 'link';
	const COL_CATEGORY_ID = 'category_id';

	private $id;
	private $name;
	private $comment;
	private $thumbnail;
	private $createdAt;
	private $link;
	private $category_id;

	public function __construct($name, $comment, $thumbnail, $createdAt, $link, $category_id, $id = null)
	{
		$this->setId($id);
		$this->setName($name);
		$this->setComment($comment);
		$this->setThumbnail($thumbnail);
		$this->setCreatedAt($createdAt);
		$this->setLink($link);
		$this->setCategory_id($category_id);
	}

	/**
	* @return mixed
	*/
	public function getId()
	{
		return $this->id;
	}

	/**
	* @param $id
	* @return $this
	*/
	public function setId($id)
	{
		$this->id = $id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getName()
	{
		return $this->name;
	}

	/**
	* @param $name
	* @return $this
	*/
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getComment()
	{
		return $this->comment;
	}

	/**
	* @param $comment
	* @return $this
	*/
	public function setComment($comment)
	{
		$this->comment = $comment;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getThumbnail()
	{
		return $this->thumbnail;
	}

	/**
	* @param $thumbnail
	* @return $this
	*/
	public function setThumbnail($thumbnail)
	{
		$this->thumbnail = $thumbnail;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	* @param $createdAt
	* @return $this
	*/
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getLink()
	{
		return $this->link;
	}

	/**
	* @param $link
	* @return $this
	*/
	public function setLink($link)
	{
		$this->link = $link;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getCategory_id()
	{
		return $this->category_id;
	}

	/**
	* @param $category_id
	* @return $this
	*/
	public function setCategory_id($category_id)
	{
		$this->category_id = $category_id;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"name" => $this->name, 
		"comment" => $this->comment, 
		"thumbnail" => $this->thumbnail, 
		"createdAt" => $this->createdAt, 
		"link" => $this->link, 
		"category_id" => $this->category_id, 
	);
	 return $object;
	}}
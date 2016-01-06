<?php
namespace Models;
class Article
{
	const COL_ID = 'id';
	const COL_TITLE = 'title';
	const COL_INTRONEWSDATA = 'introNewsData';
	const COL_NEWSDATA = 'newsData';
	const COL_PICTURE = 'picture';
	const COL_THUMBNAIL = 'thumbnail';
	const COL_CREATEDAT = 'createdAt';
	const COL_CATEGORY_ID = 'category_id';
	const COL_ISPOSTED = 'isPosted';

	private $id;
	private $title;
	private $introNewsData;
	private $newsData;
	private $picture;
	private $thumbnail;
	private $createdAt;
	private $category_id;
	private $isPosted;

	public function __construct($title, $introNewsData, $newsData, $picture, $thumbnail, $createdAt, $category_id, $isPosted, $id = null)
	{
		$this->setId($id);
		$this->setTitle($title);
		$this->setIntroNewsData($introNewsData);
		$this->setNewsData($newsData);
		$this->setPicture($picture);
		$this->setThumbnail($thumbnail);
		$this->setCreatedAt($createdAt);
		$this->setCategory_id($category_id);
		$this->setIsPosted($isPosted);
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
	public function getTitle()
	{
		return $this->title;
	}

	/**
	* @param $title
	* @return $this
	*/
	public function setTitle($title)
	{
		$this->title = $title;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getIntroNewsData()
	{
		return $this->introNewsData;
	}

	/**
	* @param $introNewsData
	* @return $this
	*/
	public function setIntroNewsData($introNewsData)
	{
		$this->introNewsData = $introNewsData;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getNewsData()
	{
		return $this->newsData;
	}

	/**
	* @param $newsData
	* @return $this
	*/
	public function setNewsData($newsData)
	{
		$this->newsData = $newsData;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getPicture()
	{
		return $this->picture;
	}

	/**
	* @param $picture
	* @return $this
	*/
	public function setPicture($picture)
	{
		$this->picture = $picture;
		
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


	/**
	* @return mixed
	*/
	public function getIsPosted()
	{
		return $this->isPosted;
	}

	/**
	* @param $isPosted
	* @return $this
	*/
	public function setIsPosted($isPosted)
	{
		$this->isPosted = $isPosted;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"title" => $this->title, 
		"introNewsData" => $this->introNewsData, 
		"newsData" => $this->newsData, 
		"picture" => $this->picture, 
		"thumbnail" => $this->thumbnail, 
		"createdAt" => $this->createdAt, 
		"category_id" => $this->category_id, 
		"isPosted" => $this->isPosted, 
	);
	 return $object;
	}}
<?php
namespace Models;
class Gallery
{
	const COL_ID = 'id';
	const COL_SOURCE = 'source';
	const COL_CAROUSEL = 'carousel';
	const COL_POST_DATE = 'post_date';
	const COL_CATEGORY_ID = 'category_id';
	const COL_TITLE = 'title';
	const COL_DESCRIPTION = 'description';

	private $id;
	private $source;
	private $carousel;
	private $post_date;
	private $category_id;
	private $title;
	private $description;

	public function __construct($source, $carousel, $post_date, $category_id, $title, $description, $id = null)
	{
		$this->setId($id);
		$this->setSource($source);
		$this->setCarousel($carousel);
		$this->setPost_date($post_date);
		$this->setCategory_id($category_id);
		$this->setTitle($title);
		$this->setDescription($description);
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
	public function getSource()
	{
		return $this->source;
	}

	/**
	* @param $source
	* @return $this
	*/
	public function setSource($source)
	{
		$this->source = $source;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getCarousel()
	{
		return $this->carousel;
	}

	/**
	* @param $carousel
	* @return $this
	*/
	public function setCarousel($carousel)
	{
		$this->carousel = $carousel;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getPost_date()
	{
		return $this->post_date;
	}

	/**
	* @param $post_date
	* @return $this
	*/
	public function setPost_date($post_date)
	{
		$this->post_date = $post_date;
		
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
	public function getDescription()
	{
		return $this->description;
	}

	/**
	* @param $description
	* @return $this
	*/
	public function setDescription($description)
	{
		$this->description = $description;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"source" => $this->source, 
		"carousel" => $this->carousel, 
		"post_date" => $this->post_date, 
		"category_id" => $this->category_id, 
		"title" => $this->title, 
		"description" => $this->description, 
	);
	 return $object;
	}}
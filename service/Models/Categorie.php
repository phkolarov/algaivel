<?php
namespace Models;
class Categorie
{
	const COL_ID = 'id';
	const COL_NAME = 'name';
	const COL_THUMBNAIL = 'thumbnail';
	const COL_CREATEDAT = 'createdAt';

	private $id;
	private $name;
	private $thumbnail;
	private $createdAt;

	public function __construct($name, $thumbnail, $createdAt, $id = null)
	{
		$this->setId($id);
		$this->setName($name);
		$this->setThumbnail($thumbnail);
		$this->setCreatedAt($createdAt);
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


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"name" => $this->name, 
		"thumbnail" => $this->thumbnail, 
		"createdAt" => $this->createdAt, 
	);
	 return $object;
	}}
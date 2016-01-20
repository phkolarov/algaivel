<?php
namespace Models;
class TagCategory
{
	const COL_ID = 'id';
	const COL_NAME = 'name';
	const COL_NAMEBG = 'nameBG';

	private $id;
	private $name;
	private $nameBG;

	public function __construct($name, $nameBG, $id = null)
	{
		$this->setId($id);
		$this->setName($name);
		$this->setNameBG($nameBG);
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
	public function getNameBG()
	{
		return $this->nameBG;
	}

	/**
	* @param $nameBG
	* @return $this
	*/
	public function setNameBG($nameBG)
	{
		$this->nameBG = $nameBG;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"name" => $this->name, 
		"nameBG" => $this->nameBG, 
	);
	 return $object;
	}}
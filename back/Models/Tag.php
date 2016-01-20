<?php
namespace Models;
class Tag
{
	const COL_ID = 'id';
	const COL_NAMEBG = 'nameBG';
	const COL_NAME = 'name';

	private $id;
	private $nameBG;
	private $name;

	public function __construct($nameBG, $name, $id = null)
	{
		$this->setId($id);
		$this->setNameBG($nameBG);
		$this->setName($name);
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


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"nameBG" => $this->nameBG, 
		"name" => $this->name, 
	);
	 return $object;
	}}
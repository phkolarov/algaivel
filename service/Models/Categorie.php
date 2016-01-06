<?php
namespace Models;
class Categorie
{
	const COL_ID = 'id';
	const COL_NAME = 'name';

	private $id;
	private $name;

	public function __construct($name, $id = null)
	{
		$this->setId($id);
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
		"name" => $this->name, 
	);
	 return $object;
	}}
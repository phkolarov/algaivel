<?php
namespace Models;
class Role
{
	const COL_ID = 'id';
	const COL_ROLE = 'role';

	private $id;
	private $role;

	public function __construct($role, $id = null)
	{
		$this->setId($id);
		$this->setRole($role);
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
	public function getRole()
	{
		return $this->role;
	}

	/**
	* @param $role
	* @return $this
	*/
	public function setRole($role)
	{
		$this->role = $role;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"role" => $this->role, 
	);
	 return $object;
	}}
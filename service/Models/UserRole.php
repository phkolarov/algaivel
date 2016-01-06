<?php
namespace Models;
class UserRole
{
	const COL_ID = 'id';
	const COL_USER_ID = 'user_id';
	const COL_ROLE_ID = 'role_id';

	private $id;
	private $user_id;
	private $role_id;

	public function __construct($user_id, $role_id, $id = null)
	{
		$this->setId($id);
		$this->setUser_id($user_id);
		$this->setRole_id($role_id);
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
	public function getUser_id()
	{
		return $this->user_id;
	}

	/**
	* @param $user_id
	* @return $this
	*/
	public function setUser_id($user_id)
	{
		$this->user_id = $user_id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getRole_id()
	{
		return $this->role_id;
	}

	/**
	* @param $role_id
	* @return $this
	*/
	public function setRole_id($role_id)
	{
		$this->role_id = $role_id;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"user_id" => $this->user_id, 
		"role_id" => $this->role_id, 
	);
	 return $object;
	}}
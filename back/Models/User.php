<?php
namespace Models;
class User
{
	const COL_ID = 'id';
	const COL_USERNAME = 'username';
	const COL_EMAIL = 'email';
	const COL_PASSWORD = 'password';
	const COL_ROLE_ID = 'role_id';
	const COL_F_NAME = 'f_name';
	const COL_L_NAME = 'l_name';
	const COL_GENDER = 'gender';
	const COL_DATE_OF_BIRTH = 'date_of_birth';
	const COL_REGISTERED_AT = 'registered_at';

	private $id;
	private $username;
	private $email;
	private $password;
	private $role_id;
	private $f_name;
	private $l_name;
	private $gender;
	private $date_of_birth;
	private $registered_at;

	public function __construct($username, $email, $password, $role_id, $f_name, $l_name, $gender, $date_of_birth, $registered_at, $id = null)
	{
		$this->setId($id);
		$this->setUsername($username);
		$this->setEmail($email);
		$this->setPassword($password);
		$this->setRole_id($role_id);
		$this->setF_name($f_name);
		$this->setL_name($l_name);
		$this->setGender($gender);
		$this->setDate_of_birth($date_of_birth);
		$this->setRegistered_at($registered_at);
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
	public function getUsername()
	{
		return $this->username;
	}

	/**
	* @param $username
	* @return $this
	*/
	public function setUsername($username)
	{
		$this->username = $username;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getEmail()
	{
		return $this->email;
	}

	/**
	* @param $email
	* @return $this
	*/
	public function setEmail($email)
	{
		$this->email = $email;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getPassword()
	{
		return $this->password;
	}

	/**
	* @param $password
	* @return $this
	*/
	public function setPassword($password)
	{
		$this->password = $password;
		
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


	/**
	* @return mixed
	*/
	public function getF_name()
	{
		return $this->f_name;
	}

	/**
	* @param $f_name
	* @return $this
	*/
	public function setF_name($f_name)
	{
		$this->f_name = $f_name;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getL_name()
	{
		return $this->l_name;
	}

	/**
	* @param $l_name
	* @return $this
	*/
	public function setL_name($l_name)
	{
		$this->l_name = $l_name;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getGender()
	{
		return $this->gender;
	}

	/**
	* @param $gender
	* @return $this
	*/
	public function setGender($gender)
	{
		$this->gender = $gender;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getDate_of_birth()
	{
		return $this->date_of_birth;
	}

	/**
	* @param $date_of_birth
	* @return $this
	*/
	public function setDate_of_birth($date_of_birth)
	{
		$this->date_of_birth = $date_of_birth;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getRegistered_at()
	{
		return $this->registered_at;
	}

	/**
	* @param $registered_at
	* @return $this
	*/
	public function setRegistered_at($registered_at)
	{
		$this->registered_at = $registered_at;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"username" => $this->username, 
		"email" => $this->email, 
		"password" => $this->password, 
		"role_id" => $this->role_id, 
		"f_name" => $this->f_name, 
		"l_name" => $this->l_name, 
		"gender" => $this->gender, 
		"date_of_birth" => $this->date_of_birth, 
		"registered_at" => $this->registered_at, 
	);
	 return $object;
	}}
<?php
namespace Models;
class User
{
	const COL_ID = 'id';
	const COL_USERNAME = 'username';
	const COL_PASSWORD = 'password';
	const COL_REGISTERDATE = 'registerDate';
	const COL_EMAILVERIFIED = 'emailVerified';
	const COL_EMAIL = 'email';
	const COL_CREATEDAT = 'createdAt';
	const COL_UPDATEDAT = 'updatedAt';

	private $id;
	private $username;
	private $password;
	private $registerDate;
	private $emailVerified;
	private $email;
	private $createdAt;
	private $updatedAt;

	public function __construct($username, $password, $registerDate, $emailVerified, $email, $createdAt, $updatedAt, $id = null)
	{
		$this->setId($id);
		$this->setUsername($username);
		$this->setPassword($password);
		$this->setRegisterDate($registerDate);
		$this->setEmailVerified($emailVerified);
		$this->setEmail($email);
		$this->setCreatedAt($createdAt);
		$this->setUpdatedAt($updatedAt);
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
	public function getRegisterDate()
	{
		return $this->registerDate;
	}

	/**
	* @param $registerDate
	* @return $this
	*/
	public function setRegisterDate($registerDate)
	{
		$this->registerDate = $registerDate;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getEmailVerified()
	{
		return $this->emailVerified;
	}

	/**
	* @param $emailVerified
	* @return $this
	*/
	public function setEmailVerified($emailVerified)
	{
		$this->emailVerified = $emailVerified;
		
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
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	* @param $updatedAt
	* @return $this
	*/
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"username" => $this->username, 
		"password" => $this->password, 
		"registerDate" => $this->registerDate, 
		"emailVerified" => $this->emailVerified, 
		"email" => $this->email, 
		"createdAt" => $this->createdAt, 
		"updatedAt" => $this->updatedAt, 
	);
	 return $object;
	}}
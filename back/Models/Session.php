<?php
namespace Models;
class Session
{
	const COL_ID = 'id';
	const COL_USER_ID = 'user_id';
	const COL_SESSION = 'session';

	private $id;
	private $user_id;
	private $session;

	public function __construct($user_id, $session, $id = null)
	{
		$this->setId($id);
		$this->setUser_id($user_id);
		$this->setSession($session);
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
	public function getSession()
	{
		return $this->session;
	}

	/**
	* @param $session
	* @return $this
	*/
	public function setSession($session)
	{
		$this->session = $session;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"user_id" => $this->user_id, 
		"session" => $this->session, 
	);
	 return $object;
	}}
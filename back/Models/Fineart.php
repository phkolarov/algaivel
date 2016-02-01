<?php
namespace Models;
class Fineart
{
	const COL_ID = 'id';
	const COL_FINEARTONE = 'fineArtOne';
	const COL_FINEARTTWO = 'fineArtTwo';
	const COL_FINEARTTHREE = 'fineArtThree';
	const COL_FINEARTCONTENT = 'fineArtContent';

	private $id;
	private $fineArtOne;
	private $fineArtTwo;
	private $fineArtThree;
	private $fineArtContent;

	public function __construct($fineArtOne, $fineArtTwo, $fineArtThree, $fineArtContent, $id = null)
	{
		$this->setId($id);
		$this->setFineArtOne($fineArtOne);
		$this->setFineArtTwo($fineArtTwo);
		$this->setFineArtThree($fineArtThree);
		$this->setFineArtContent($fineArtContent);
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
	public function getFineArtOne()
	{
		return $this->fineArtOne;
	}

	/**
	* @param $fineArtOne
	* @return $this
	*/
	public function setFineArtOne($fineArtOne)
	{
		$this->fineArtOne = $fineArtOne;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getFineArtTwo()
	{
		return $this->fineArtTwo;
	}

	/**
	* @param $fineArtTwo
	* @return $this
	*/
	public function setFineArtTwo($fineArtTwo)
	{
		$this->fineArtTwo = $fineArtTwo;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getFineArtThree()
	{
		return $this->fineArtThree;
	}

	/**
	* @param $fineArtThree
	* @return $this
	*/
	public function setFineArtThree($fineArtThree)
	{
		$this->fineArtThree = $fineArtThree;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getFineArtContent()
	{
		return $this->fineArtContent;
	}

	/**
	* @param $fineArtContent
	* @return $this
	*/
	public function setFineArtContent($fineArtContent)
	{
		$this->fineArtContent = $fineArtContent;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"fineArtOne" => $this->fineArtOne, 
		"fineArtTwo" => $this->fineArtTwo, 
		"fineArtThree" => $this->fineArtThree, 
		"fineArtContent" => $this->fineArtContent, 
	);
	 return $object;
	}}
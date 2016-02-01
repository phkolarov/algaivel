<?php
namespace Models;
class Aboutmeinfotable
{
	const COL_ID = 'id';
	const COL_ABOUTMEIMAGESOURCE = 'aboutMeImageSource';
	const COL_ABOUTMECONTENT = 'aboutMeContent';
	const COL_ABOUTMECONTENTBG = 'aboutMeContentBG';

	private $id;
	private $aboutMeImageSource;
	private $aboutMeContent;
	private $aboutMeContentBG;

	public function __construct($aboutMeImageSource, $aboutMeContent, $aboutMeContentBG, $id = null)
	{
		$this->setId($id);
		$this->setAboutMeImageSource($aboutMeImageSource);
		$this->setAboutMeContent($aboutMeContent);
		$this->setAboutMeContentBG($aboutMeContentBG);
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
	public function getAboutMeImageSource()
	{
		return $this->aboutMeImageSource;
	}

	/**
	* @param $aboutMeImageSource
	* @return $this
	*/
	public function setAboutMeImageSource($aboutMeImageSource)
	{
		$this->aboutMeImageSource = $aboutMeImageSource;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getAboutMeContent()
	{
		return $this->aboutMeContent;
	}

	/**
	* @param $aboutMeContent
	* @return $this
	*/
	public function setAboutMeContent($aboutMeContent)
	{
		$this->aboutMeContent = $aboutMeContent;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getAboutMeContentBG()
	{
		return $this->aboutMeContentBG;
	}

	/**
	* @param $aboutMeContentBG
	* @return $this
	*/
	public function setAboutMeContentBG($aboutMeContentBG)
	{
		$this->aboutMeContentBG = $aboutMeContentBG;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"aboutMeImageSource" => $this->aboutMeImageSource, 
		"aboutMeContent" => $this->aboutMeContent, 
		"aboutMeContentBG" => $this->aboutMeContentBG, 
	);
	 return $object;
	}}
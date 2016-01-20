<?php
namespace Models;
class TagsCategorie
{
	const COL_ID = 'id';
	const COL_TAG_CATEGORY_ID = 'tag_category_id';
	const COL_TAG_ID = 'tag_id';

	private $id;
	private $tag_category_id;
	private $tag_id;

	public function __construct($tag_category_id, $tag_id, $id = null)
	{
		$this->setId($id);
		$this->setTag_category_id($tag_category_id);
		$this->setTag_id($tag_id);
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
	public function getTag_category_id()
	{
		return $this->tag_category_id;
	}

	/**
	* @param $tag_category_id
	* @return $this
	*/
	public function setTag_category_id($tag_category_id)
	{
		$this->tag_category_id = $tag_category_id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getTag_id()
	{
		return $this->tag_id;
	}

	/**
	* @param $tag_id
	* @return $this
	*/
	public function setTag_id($tag_id)
	{
		$this->tag_id = $tag_id;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"tag_category_id" => $this->tag_category_id, 
		"tag_id" => $this->tag_id, 
	);
	 return $object;
	}}
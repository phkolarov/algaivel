<?php
namespace Models;
class GalleryCategorie
{
	const COL_ID = 'id';
	const COL_GALLERY_ID = 'gallery_id';
	const COL_CATEGORY_ID = 'category_id';

	private $id;
	private $gallery_id;
	private $category_id;

	public function __construct($gallery_id, $category_id, $id = null)
	{
		$this->setId($id);
		$this->setGallery_id($gallery_id);
		$this->setCategory_id($category_id);
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
	public function getGallery_id()
	{
		return $this->gallery_id;
	}

	/**
	* @param $gallery_id
	* @return $this
	*/
	public function setGallery_id($gallery_id)
	{
		$this->gallery_id = $gallery_id;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getCategory_id()
	{
		return $this->category_id;
	}

	/**
	* @param $category_id
	* @return $this
	*/
	public function setCategory_id($category_id)
	{
		$this->category_id = $category_id;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"gallery_id" => $this->gallery_id, 
		"category_id" => $this->category_id, 
	);
	 return $object;
	}}
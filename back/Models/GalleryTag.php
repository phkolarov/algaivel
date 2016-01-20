<?php
namespace Models;
class GalleryTag
{
	const COL_ID = 'id';
	const COL_GALLERY_ID = 'gallery_id';
	const COL_TAG_ID = 'tag_id';

	private $id;
	private $gallery_id;
	private $tag_id;

	public function __construct($gallery_id, $tag_id, $id = null)
	{
		$this->setId($id);
		$this->setGallery_id($gallery_id);
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
		"gallery_id" => $this->gallery_id, 
		"tag_id" => $this->tag_id, 
	);
	 return $object;
	}}
<?php
namespace Models;
class Article
{
	const COL_ID = 'id';
	const COL_TITLE = 'title';
	const COL_CONTENT = 'content';
	const COL_POST_DATE = 'post_date';
	const COL_ARTICLEIMAGE = 'articleImage';
	const COL_TITLEBG = 'titleBG';
	const COL_CONTENTBG = 'contentBG';

	private $id;
	private $title;
	private $content;
	private $post_date;
	private $articleImage;
	private $titleBG;
	private $contentBG;

	public function __construct($title, $content, $post_date, $articleImage, $titleBG, $contentBG, $id = null)
	{
		$this->setId($id);
		$this->setTitle($title);
		$this->setContent($content);
		$this->setPost_date($post_date);
		$this->setArticleImage($articleImage);
		$this->setTitleBG($titleBG);
		$this->setContentBG($contentBG);
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
	public function getTitle()
	{
		return $this->title;
	}

	/**
	* @param $title
	* @return $this
	*/
	public function setTitle($title)
	{
		$this->title = $title;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getContent()
	{
		return $this->content;
	}

	/**
	* @param $content
	* @return $this
	*/
	public function setContent($content)
	{
		$this->content = $content;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getPost_date()
	{
		return $this->post_date;
	}

	/**
	* @param $post_date
	* @return $this
	*/
	public function setPost_date($post_date)
	{
		$this->post_date = $post_date;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getArticleImage()
	{
		return $this->articleImage;
	}

	/**
	* @param $articleImage
	* @return $this
	*/
	public function setArticleImage($articleImage)
	{
		$this->articleImage = $articleImage;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getTitleBG()
	{
		return $this->titleBG;
	}

	/**
	* @param $titleBG
	* @return $this
	*/
	public function setTitleBG($titleBG)
	{
		$this->titleBG = $titleBG;
		
		return $this;
	}


	/**
	* @return mixed
	*/
	public function getContentBG()
	{
		return $this->contentBG;
	}

	/**
	* @param $contentBG
	* @return $this
	*/
	public function setContentBG($contentBG)
	{
		$this->contentBG = $contentBG;
		
		return $this;
	}


	 public function FullObjectGeter()
	{
	$object = (object)array(
		"id" => $this->id, 
		"title" => $this->title, 
		"content" => $this->content, 
		"post_date" => $this->post_date, 
		"articleImage" => $this->articleImage, 
		"titleBG" => $this->titleBG, 
		"contentBG" => $this->contentBG, 
	);
	 return $object;
	}}
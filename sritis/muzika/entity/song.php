<?php

class entity_song {
	private $category;
	private $title;
	private $file_name;
	private $splFileinfo;
	private $getMTime;
	
	public function __construct($file_name) {
		$this->file_name = $file_name;
		$this->splFileinfo = new SplFileInfo($file_name);
		$this->getMTime = $this->splFileinfo->getMTime();
	}

	public function getCategory() {
		return $this->category;
	}

	public function setCategory($category) {
		$this->category = $category;
		return $this;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	
	public function getId() {
		return ( $this->getCategory() == '.' ? '' : $this->getCategory() . '%2F') . $this->getTitle();
	}
	
	public function getMTime() {
		return $this->getMTime;
	}
}

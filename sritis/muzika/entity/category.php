<?php

class entity_category extends ArrayObject {
	/**
	 * 
	 * @var string
	 */
	private $title;

	/**
	 * 
	 * @var string
	 */
	private $name;
	
	public function __construct($name = null, $title = null, $songs = array()) {
		if(null !== $name) {
			$this->setName($name);
		}
		if(null !== $title) {
			$this->setTitle($title);
		}
		if(is_array($songs)) {
			parent::__construct($songs);
		}
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

}

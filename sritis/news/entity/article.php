<?php

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class entity_article {
	/**
	 * 
	 * @var integer
	 */
	private $id;
	
	/**
	 * 
	 * @var string
	 */
	private $pavadinimas;
	
	/**
	 * 
	 * @var string
	 */
	private $autorius;
	
	/**
	 * 
	 * @var string
	 */
	private $tekstas;
	
	/**
	 * 
	 * @var string
	 */
	private $tema;
	
	/**
	 * 
	 * @var DateTime
	 */
	private $laikas;

	/**
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getPavadinimas() {
		return $this->pavadinimas;
	}

	/**
	 * @param string $pavadinimas
	 */
	public function setPavadinimas($pavadinimas) {
		$this->pavadinimas = trim($pavadinimas);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getAutorius() {
		return $this->autorius;
	}

	/**
	 * @param string $autorius
	 */
	public function setAutorius($autorius) {
		$this->autorius = trim($autorius);
		return $this;
	}

	/**
	 * shortens text
	 * 
	 * @param integer $ilgis
	 * @param string $ellipsis
	 * @return string
	 */
	public function getTrumpasTekstas($ilgis = 200, $ellipsis = '...') {
		$tmp = strip_tags($this->getTekstas(), '<br/>');
		if (strlen($tmp) > $ilgis) {
			$words = explode(' ', substr($tmp, 0, $ilgis));
			array_pop($words);
			$tmp = implode(' ', $words) . $ellipsis;
		}
		return $tmp;
	}

	/**
	 * @return string
	 */
	public function getTekstas() {
		return $this->tekstas;
	}

	/**
	 * @param string $tekstas
	 */
	public function setTekstas($tekstas) {
		$this->tekstas = trim($tekstas);
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTema() {
		return $this->tema;
	}

	/**
	 * @param string $tema
	 */
	public function setTema($tema) {
		$this->tema = trim($tema);
		return $this;
	}

	/**
	 * @return DateTime|string
	 */
	public function getLaikas($format = "%Ym. %B %ed. %R") {
		if (!$this->laikas instanceof DateTime) {
			$this->setLaikas($this->laikas);
		}
		if (null === $format) {
			return $this->laikas;
		}
		return strftime($format, $this->laikas->getTimestamp());
	}

	/**
	 * @param string|DateTime $laikas
	 */
	public function setLaikas($laikas) {
		// DateTime::createFromFormat ( string $format , string $time [, DateTimeZone $timezone ] )
		if($laikas instanceof DateTime) {
			$this->laikas = $laikas;
		} else {
			$this->laikas = new DateTime((string) $laikas);
		}
		return $this;
	}

	/**
	 * 
	 * @param integer $days
	 * @return boolean
	 */
	public function isNew($days = 7) {
		$diff = $this->getLaikas(null)->diff(new DateTime());
		return $diff->days < $days;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getSlug() {
		return str_pad($this->getId(), 3, '0', STR_PAD_LEFT) . '_' . $this->getPavadinimas();
	}
	
	/**
	 * 
	 * @param array $data
	 */
	public function exchangeArray($data) {
		if(!is_array($data)) {
			return;
		}
		foreach ($data as $key=>$value) {
			$setter = 'set'.ucfirst($key);
			if(method_exists($this, $setter)) {
				$this->$setter($value);
			}
		}
	}
}

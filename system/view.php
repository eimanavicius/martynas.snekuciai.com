<?php

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class system_view {
	public $dir;
	public $basedir = 'martynas_mvc';
	
	/**
	 * 
	 * @var string
	 */
	protected $_controller = null;
	
	/**
	 * 
	 * @var string
	 */
	protected $_ext = '.php';

	/**
	 * 
	 * @param object $old
	 * @return system_view
	 */
	public static function cloneFrom($old) {
		$view = new self();
		if ($old instanceof view) {
			$vars = get_object_vars($old);
			foreach ($vars as $k => $v) {
				$view->$k = $v;
			}
		}
		return $view;
	}

	/**
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	public function assign($key, $value = null) {
		if (is_array($key)) {
			foreach ($key as $k => $v) {
				if($k[0] != '_') {
					$this->$k = $v;
				}
			}
		} elseif (is_string($key) && $key[0] != '_') {
			$this->$key = $value;
		}
	}
	
	/**
	 * 
	 * @param string $name
	 */
	public function render($name) {
		$filename = "sritis/".$this->dir."/".$name.$this->getExt();
		if(file_exists($filename)) {
			include($filename);
		}
	}
	
	/**
	 * 
	 * @param string $name
	 */
	public function rodyk($name = "rodyk") {
		$this->render("../../vaizdas/header");
		$this->render($name);
		$this->render("../../vaizdas/footer");
	}
	
	/**
	 * alias to render
	 * @param string $name
	 * @see system_view::render($name)
	 */
	public function iterpk($name = "rodyk") {
		$this->render($name);
	}

	/**
	 * 
	 * @param unknown $sritis
	 */
	public function krauk($control, $action = 'rodyk') {
		$name = $control . "_control";
		if(!class_exists($name)) {
			require_once("sritis/" . $control . "/" . $name . ".php");
		}
		$sritis = new $name();

		$sritis->view = clone $this;
		$sritis->view->dir = $control;
		
		$sritis->$action();
	}

	/**
	 * 
	 * @param string $adresas
	 * @return string
	 */
	public function baseurl($adresas = "") {
		$linkas = "http://" . $_SERVER['HTTP_HOST'] . "/" . $this->basedir . "/" . $adresas;
		return $linkas;
	}

	/**
	 * @return string
	 */
	public function getController() {
		return $this->_controller;
	}

	/**
	 * @param string $controller
	 */
	public function setController($_controller) {
		$this->_controller = $_controller;
		return $this;
	}
	
	public function getExt() {
		return $this->ext;
	}
	
	public function setExt($ext) {
		if($ext == 'json') {
			$this->ext = '.json.php';
		} else {
			$this->ext = '.php';
		}
		return $this;
	}

	/**
	 * 
	 * @param string $action
	 * @param string $controller
	 * @param array $params
	 * @return string
	 */
	public function url($action = null, $controller = null, $params = array()) {
		$controller = $controller ? $controller : $this->getController();
		if(!is_array($params)) {
			$params = array_slice(func_get_args(), 2);
		}
		if(null === $action) {
			$adresas = array($controller);
		} else {
			$adresas = array_merge(array($controller, $action), $params);
		}
		$query = '';
		if (array_key_exists('_get', $adresas)) {
			$query = '?' . http_build_query($adresas['_get'], '', '&', PHP_QUERY_RFC3986);
			unset($adresas['_get']);
		}
		$adresas = array_map('rawurlencode', $adresas);
		$adresas = implode('/', $adresas) . $query;
		return $this->baseurl($adresas);
	}
	
	/**
	 * 
	 * @param string $name
	 * @param array $params
	 */
	public function partial($name, $params = array()) {
		$view = new system_view();
		$view->assign($params);
		$view->setController($this->getController());
		$view->setExt($this->getExt());
		$view->dir = $this->dir;
		
		$view->render('partial_' . $name);
	}

	/**
	 * 
	 * @param string $partial
	 */
	public function paginate($partial = 'pagination') {
		$this->partial($partial, $this->pagination);
	}
	
	/**
	 * 
	 * @param string $style
	 * @return string
	 */
	public function inlineStyle($style = 'custom') {
		if(file_exists($style)) {
			return '<style type="text/css">' . str_replace(array("\n", "\r", "\t"), '', file_get_contents($file)) . '</style>';
		}
	}
}

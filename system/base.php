<?php

require_once 'system/view.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
abstract class system_base {
	/**
	 * 
	 * @var string
	 */
	protected $name = null;

	/**
	 * 
	 * @var string
	 */
	protected $dir = null;

	/**
	 * 
	 * @var system_model
	 */
	protected $model = null;

	/**
	 * 
	 * @var string
	 */
	protected $action = 'rodyk';

	/**
	 * 
	 * @var array
	 */
	protected $params = array();

	/**
	 * 
	 * @var boolean
	 */
	protected $autoRender = true;

	/**
	 * 
	 * @var system_view
	 */
	protected $view = null;

	/**
	 * 
	 */
	public function __construct($view = null) {
		// be view controleris pas tave nelabai dirba, tai gal ji perdavinek per konstruktoriu
		if ($view instanceof system_view) {
			$this->setView($view);
		}

		$this->initLocale();
		$this->init();
	}

	/**
	 * 
	 */
	protected function initLocale() {
		// Set language to Lithuanian
		putenv('LC_ALL=lt_LT');
		setlocale(LC_ALL, 'lt_LT.UTF-8');
		if(file_exists($this->getDir() . 'locale')) {
			// Specify location of translation tables
			bindtextdomain($this->getName(), $this->getDir() . 'locale');
			// Choose domain
			textdomain($this->getName());
		}
	}

	/**
	 * 
	 */
	protected function init() {

	}

	/**
	 * 
	 * @param string $name
	 * @param array $arguments
	 */
	public function __call($name, $arguments) {
		$name = strtolower($name);
		$action_method = $name . 'Action';
		if (method_exists($this, $action_method)) {
			$this->setAction($name);
			$return = call_user_func_array(array($this, $action_method), $arguments + $this->getParams());
			$this->render();
			return $return;
		}
		$this->view->rodyk('error');
	}

	/**
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name) {
		$method_name = 'get' . ucfirst($name);
		if (method_exists($this, $method_name)) {
			return $this->$method_name();
		}
		return null;
	}

	/**
	 * 
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		$setter = 'set' . ucfirst($name);
		if (method_exists($this, $setter)) {
			$this->$setter($value);
		}
	}

	/**
	 * 
	 * @param string $name
	 * @return system_model
	 */
	public function loadModel($name = null, $sritis = null) {
		$class_name = ($name ? $name : $this->getName()) . '_class';
		if (!class_exists($class_name)) {
			if ($sritis && file_exists('sritis/' . $sritis . '/' . $class_name . '.php')) {
				include_once 'sritis/' . $sritis . '/' . $class_name . '.php';
			} else if (file_exists($this->getDir() . $class_name . '.php')) {
				include_once $this->getDir() . $class_name . '.php';
			} else {
				return null;
			}
		}
		return new $class_name;
	}

	/**
	 * 
	 */
	public function render() {
		// kadangi render kvieciamas visada, pasilikime galimybe atsisakyti view'o renderinimo
		if ($this->autoRender) {
			$this->view->rodyk($this->getAction());
		}
	}

	/**
	 * @return the boolean
	 */
	public function getAutoRender() {
		return $this->autoRender;
	}

	/**
	 * @param  $autoRender
	 */
	public function setAutoRender($autoRender) {
		$this->autoRender = $autoRender;
		return $this;
	}

	/**
	 * @return system_model
	 */
	public function getModel() {
		if (null === $this->model) {
			$this->model = $this->loadModel();
		}
		return $this->model;
	}

	/**
	 * @param object $model
	 */
	public function setModel($model) {
		$this->model = $model;
		return $this;
	}

	/**
	 * 
	 * @param string $message
	 */
	protected function error($message = null) {
		$this->view->error_message = $message;
		$this->setAction('error');
	}

	/**
	 * @return the unknown_type
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * @return the unknown_type
	 */
	public function getParam($name, $default = null) {
		return array_key_exists($name, $this->params) ? $this->params[$name] : $default;
	}

	/**
	 * @param unknown_type $params
	 */
	public function setParams($params) {
		$this->params = $params;
		return $this;
	}

	/**
	 * @return the unknown_type
	 */
	public function getQuery($name = null, $default = null) {
		if(null === $name) {
			return $_GET;
		}
		return array_key_exists($name, $_GET) ? $_GET[$name] : $default;
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isPost() {
		return (strtolower($_SERVER['REQUEST_METHOD']) == 'post');
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function getPost($name = null, $default = null) {
		if(null === $name) {
			return $_POST;
		}
		return array_key_exists($name, $_POST) ? $_POST[$name] : $default;
	}

	/**
	 * 
	 * @return system_view
	 */
	public function getView() {
		return $this->view;
	}

	/**
	 * 
	 * @param system_view $view
	 * @return base
	 */
	public function setView($view) {
		if (!$view instanceof system_view) {
			$view = system_view::cloneFrom($view);
		}
		$view->setController($this->getName());
		$this->view = $view;
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getName() {
		if (null === $this->name) {
			// vardas pagal klase
			$this->name = explode("_", get_class($this));
			$this->name = reset($this->name);
		}
		return $this->name;
	}

	/**
	 * 
	 * @param string $name
	 * @return system_base
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @return the string
	 */
	public function getDir() {
		if (null === $this->dir) {
			// sritis pagal klase
			$this->dir = 'sritis/' . $this->getName() . '/';
		}
		return $this->dir;
	}

	/**
	 * @param  $dir
	 */
	public function setDir($dir) {
		$this->dir = $dir;
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getAction() {
		return $this->action;
	}

	/**
	 * 
	 * @param unknown $action
	 * @return system_base
	 */
	public function setAction($action) {
		$this->action = $action;
		return $this;
	}

	public function redirect($action, $controller = null, $params = array()) {
		$url = $this->getView()->url($action, $controller, $params);
		header('Location: ' . $url);
		exit();
	}
}

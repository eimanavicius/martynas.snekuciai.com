<?php

require_once 'system/base.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class statistika_control extends system_base {
	/**
	 * 
	 */
	public function rodykAction() {
		$this->getView()->duomenys = $this->getModel()->statistika();
	}
}

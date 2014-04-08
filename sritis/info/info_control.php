<?php

require_once 'system/view.php';
require_once 'system/base.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class info_control extends system_base {
	protected function apieAction() {
	}
	
	protected function cvAction() {
	}
	
	protected function darbaiAction() {
		$this->getView()->darbai = $this->getModel()->getDarbai();
	}
}

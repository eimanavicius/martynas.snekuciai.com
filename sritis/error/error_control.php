<?php

require_once 'system/base.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class error_control extends system_base {
	public function rodykAction() {
		header("HTTP/1.0 404 Not Found");
	}

}

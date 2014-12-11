<?php

require_once 'system/model.php';

/**
 *
 */
class meniu_class extends system_model {
	public function gauti_foto_kategorijas() {
		$failas = '/home/martynas/www/greitas.com/afoto/';
		$listas = $this->listas($failas);
		ksort($listas);
		return $listas;
	}

	function listas($failas) {
		$listas = array();
		$failas = realpath($failas);
		if(!$failas) {
			return array();
		}
		$handle = opendir($failas);
		if($handle)
		while (false !== ($entry = readdir($handle))) {
			if ($entry != ".." && $entry != "." && is_dir($failas . '/' . $entry)) {
				$listas[$entry] = $this->listas($failas . '/' . $entry);
			}
		}
		return $listas;
	}

}

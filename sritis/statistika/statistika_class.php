<?php

require_once 'system/model.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class statistika_class extends system_model {

	/**
	 * 
	 * @return unknown
	 */
	public function statistika() {
		$db = $this->getPdo();
		$kiek = $db->query("select count(DISTINCT ip) from statistic WHERE laikas >= '" . date("Y-m-d H:i:s", strtotime("-1 day")) . "' GROUP BY ip")->fetch(PDO::FETCH_COLUMN, 0);
		return $kiek;
	}

}

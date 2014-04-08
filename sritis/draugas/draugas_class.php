<?php

require_once 'system/model.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class draugas_class extends system_model {
	/**
	 * 
	 * @var PDO
	 */
	protected $pdo;
	
	/**
	 * 
	 * @return PDO
	 */
	public function getPdo() {
		global $config;
		if(null === $this->pdo) {
			$this->pdo = new PDO($config->martynas_pdo_dsn, $config->martynas_pdo_user, $config->martynas_pdo_password, $config->pdo_options);
		}
		return $this->pdo;
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getChats($lytis = 'vaikinai') {
		$opts = array(
			'http'=>array(
				'method' => 'GET',
				'header' => implode("\r\n", array('User-Agent: snekuciai'))
			)
		);
		
		$context = stream_context_create($opts);

		$url = 'http://nerijus.greitas.com/proxy.php?';
		$query_data = array(
			'action' => 'getChats',
			'lytis' => $lytis,
			'page' => $this->page
		);
		
		$data = file_get_contents($url . http_build_query($query_data), false, $context);
		list($result, $params) = unserialize($data);
		
		foreach (array('limit', 'offset', 'total_pages', 'total_items', 'page') as $key) {
			if(array_key_exists($key, $params)) {
				$this->$key = $params[$key];
			}
		}
		
// 		foreach ($params as $k=>$v) {
// 			if(in_array($k, array('limit', 'offset', 'total_pages', 'total_items', 'page'))) {
// 				$this->$k = $v;
// 			}
// 		}
		
		return $result;
		
// 		$pdo = $this->getPdo();
		
// 		$lytis = $lytis == 'merginos' ? 'merginos' : 'vaikinai';
		
// 		$table_pokalbiai = $lytis.'_pokalbiai';
// 		$table_info = $lytis;
		
// 		$paginationSql = "SELECT %s FROM (SELECT DISTINCT `id` FROM `{$table_pokalbiai}` GROUP BY `id` ORDER BY COUNT(*) DESC) AS `a` ";
// 		$paginationSql = "SELECT %s FROM (SELECT DISTINCT `id` FROM `{$table_pokalbiai}` GROUP BY `id` ORDER BY `laikas` DESC) AS `a` ";
// 		$paginationSql .= $this->getPaginationSql($paginationSql);
		
// 		$ids = $pdo->query(sprintf($paginationSql, '*'), PDO::FETCH_COLUMN, 0)->fetchAll();
		
// 		$sql = "SELECT `vp`.*, `v`.`vardas`, `v`.`foto_maza` FROM `{$table_pokalbiai}` AS `vp` "
// 			."LEFT JOIN `{$table_info}` AS `v` ON (`v`.`id` = `vp`.`id`) "
// 			."WHERE `vp`.`id` IN (" . implode(',', $ids) . ") "
// 			."ORDER BY `vp`.`laikas` ASC"
// 			;
		
// 		$result = $pdo->query($sql, PDO::FETCH_ASSOC)->fetchAll();
// 		return $result;
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getGroupedChats($chats = null) {
		$result = array();
		$chats = is_array($chats) ? $chats : $this->getChats();
		/* @var $row entity_article */
		foreach ($chats as $row) {
			$result[$row['id']][] = $row;
		}
		ksort($result);
		return $result;
	}
}

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
     * @param string $gender
     * @return array
     */
	public function getChats($gender = 'vaikinai') {
        try {
            list($result, $params) = $this->downloadPagedChats($gender);
        } catch (\Zend\Http\Client\Exception\RuntimeException $e) {
            $result = $params = array();
        }

		foreach (array('limit', 'offset', 'total_pages', 'total_items', 'page') as $key) {
			if(array_key_exists($key, $params)) {
				$this->$key = $params[$key];
			}
		}

		return $result;
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

    /**
     * @param $gender
     * @return array
     */
    protected function downloadPagedChats($gender)
    {
        $url = 'http://nerijus.greitas.com/proxy.php?';
        $query = array(
            'action' => 'getChats',
            'lytis' => $gender,
            'page' => $this->page
        );
        $headers = array('header' => array('User-Agent' => 'snekuciai'));

        $data = \Zend\Http\ClientStatic::get($url, $query, $headers);

        list($result, $params) = unserialize($data);
        return array($result, $params);
    }
}

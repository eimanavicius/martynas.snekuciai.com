<?php

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
abstract class system_model {
	protected $offset = 0;
	protected $limit = 10;
	protected $paginate = false;
	protected $total_pages = 1;
	protected $total_items = 2;
	protected $page = 1;

	/**
	 * 
	 * @return PDO
	 */
	public function getPdo() {
		static $database = null;
		if (null === $database) {
			global $db;
			if ($db instanceof PDO) {
				$database = $db;
			} else {
				throw new Exception('No DB connection!');
			}
		}
		return $database;
	}

	/**
	 * 
	 */
	public function getPaginationSql($totalSql = null, $params = array()) {
		$sql = '';
		if ($this->doPaginate()) {
			if ($totalSql) {
				$totalSql = sprintf($totalSql, 'COUNT(*)');
				$total = $this->getPdo()->prepare($totalSql);
				foreach ($params as $key => $value) {
					$total->bindParam($key, $value);
				}
				$total->execute();
				$total = (int) $total->fetchColumn();
				$this->calcPagination($total);
			}
			$sql = ' LIMIT ' . $this->limit . ' OFFSET ' . $this->offset;
		}
		return $sql;
	}

	/**
	 * 
	 * @return array()
	 */
	public function getPaginationVars() {
		return array('limit' => $this->limit, 'offset' => $this->offset, 'total_pages' => $this->total_pages, 'total_items' => $this->total_items, 'page' => $this->page);
	}

	/**
	 * 
	 * @param integer $total_items
	 */
	protected function calcPagination($total_items) {
		$page = (int) $this->page;
		$total_pages = ceil($total_items / $this->limit);
		if (1 > $page || $page > $total_pages) {
			$page = 1;
		}
		$this->total_pages = $total_pages;
		$this->total_items = $total_items;
		$this->page = $page;
		$this->offset = ($page - 1) * $this->limit;
	}

	/**
	 * @return system_model|boolean
	 */
	public function doPaginate($paginate = null) {
		if (null === $paginate) {
			return $this->paginate;
		}
		$this->paginate = (bool) $paginate;
		return $this;
	}

	/**
	 * @param integer $limit
	 */
	public function setLimit($limit) {
		$this->limit = $limit;
		return $this;
	}

	/**
	 * 
	 * @param integer $page
	 * @return system_model
	 */
	public function setPage($page) {
		$this->page = $page;
		return $this;
	}

}

<?php

require_once 'system/model.php';
require_once 'entity/article.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class news_class extends system_model {
	/**
	 * 
	 * @param integer $id
	 * @return entity_article
	 */
	public function getArticle($id) {
		$pdo = $this->getPdo();
		$sql = "SELECT `n`.*, `t`.`pavadinimas` AS `tema` FROM `naujienos` AS `n` LEFT JOIN `temos` AS `t` ON `t`.`id` = `n`.`tema_id` WHERE `n`.`id` = :id LIMIT 1";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetchObject('entity_article');
		return $result;
	}
	
	/**
	 * 
	 * @param string $category
	 * @return array
	 */
	public function getArticlesByCategory($category) {
		$pdo = $this->getPdo();
		$sql = "SELECT %s FROM `naujienos` AS `n` LEFT JOIN `temos` AS `t` ON `t`.`id` = `n`.`tema_id` WHERE `t`.`pavadinimas` = :category ORDER BY `laikas` DESC";
		$sql .= $this->getPaginationSql($sql, array(':category' => $category));
		$statement = $pdo->prepare(sprintf($sql, '`n`.*, `t`.`pavadinimas` AS `tema`'));
		$statement->bindParam(':category', $category);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_CLASS, 'entity_article');
		return $result;
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getArticles($query = null) {
		$pdo = $this->getPdo();
		$sql = "SELECT %s FROM `naujienos` AS `n` LEFT JOIN `temos` AS `t` ON `t`.`id` = `n`.`tema_id` ";
		if(null !== $query) {
			$query = str_replace('%', '\\%%', $query);
			$query = str_replace('_', '\\_', $query);
			$query = $pdo->quote('%%' . $query . '%%');
			$sql .= "WHERE (`n`.`pavadinimas` LIKE " . $query 
				. " OR `tekstas` LIKE " . $query 
				. " OR `autorius` LIKE " . $query
				. " OR `t`.`pavadinimas` LIKE " . $query
				. ") ";
		}
		$sql .= "ORDER BY `laikas` DESC";
		$sql .= $this->getPaginationSql($sql);
		$result = $pdo->query(sprintf($sql, '`n`.*, `t`.`pavadinimas` AS `tema`'), PDO::FETCH_CLASS, 'entity_article')
			->fetchAll();
		return $result;
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getCategorizedArticles($articles = null) {
		$result = array();
		$articles = is_array($articles) ? $articles : $this->getArticles();
		/* @var $row entity_article */
		foreach ($articles as $row) {
			$result[$row->getTema()][] = $row;
		}
		return $result;
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getCategoriesList() {
		$pdo = $this->getPdo();
		$categoriesSql = "SELECT `pavadinimas` FROM  `temos` ORDER BY CAST(`ordering` AS INTEGER) ASC ";
		return $pdo->query($categoriesSql, PDO::FETCH_COLUMN, 0)->fetchAll();
	}
	
	/**
	 * 
	 */
	public function getCategories() {
		$pdo = $this->getPdo();
		$sql = "SELECT %s FROM  `temos` ORDER BY CAST(`ordering` AS INTEGER) ASC ";
		$sql .= $this->getPaginationSql($sql);
		return $pdo->query(sprintf($sql, '*, (SELECT COUNT(*) FROM `naujienos` WHERE `naujienos`.`tema_id` = `temos`.`id`) AS `count`'), PDO::FETCH_ASSOC)->fetchAll();
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getAuthorsList() {$pdo = $this->getPdo();
		$categoriesSql = "SELECT DISTINCT `autorius` FROM  `naujienos`";
		return $pdo->query($categoriesSql, PDO::FETCH_COLUMN, 0)->fetchAll();
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getFrontArticles($limit = 5) {
		$pdo = $this->getPdo();
		$categories = $this->getCategoriesList();
		$sql = array();
		foreach ($categories as $category) {
			$sql[] = "SELECT * FROM (SELECT `n`.*, `t`.`pavadinimas` AS `tema`, `t`.`ordering` AS `ordering_category` FROM  `naujienos` AS `n` LEFT JOIN `temos` AS `t` ON `t`.`id` = `n`.`tema_id` WHERE `t`.`pavadinimas` = " . $pdo->quote($category) . " ORDER BY `laikas` DESC LIMIT " . $limit . ") AS `naujienos_tbl`";
		}
		$result = array();
		if($sql) {
			$result = $pdo->query(implode(' UNION ', $sql) . ' ORDER BY `laikas` DESC ', PDO::FETCH_CLASS, 'entity_article')->fetchAll();
		}
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $id
	 */
	public function deleteArticle($id) {
		$pdo = $this->getPdo();
		$article = $this->getArticle($id);
		if(!$article) {
			return false;
		}
		$sql = "DELETE FROM `naujienos` WHERE `id` = :id";
		$statement = $pdo->prepare($sql);
		$statement->bindParam(':id', $id);
		$success = true;
		if($statement->execute()) {
			$sql = "SELECT COUNT(`naujienos`.`id`) FROM `naujienos` WHERE `tema_id` = ?";
			$sth = $pdo->prepare($sql);
			$sth->bindParam(1, $article->tema_id, PDO::PARAM_INT);
			$sth->execute();
			$count = (int) $sth->fetch(PDO::FETCH_COLUMN, 0);
			if($count === 0) {
				$this->deleteArticleCategory($article->tema_id);
			}
		}
		return $success;
	}
	
	/**
	 * 
	 * @param unknown $id
	 */
	public function deleteArticleCategory($id) {
		$pdo = $this->getPdo();
		$sql = "DELETE FROM `naujienos` WHERE `tema_id` = ?";
		$success = false;
		if($pdo->prepare($sql)->execute(array($id))) {
			$sql = "DELETE FROM `temos` WHERE `id` = ?";
			$success = $pdo->prepare($sql)->execute(array($id));
		}
		return $success;
	}
	
	/**
	 * 
	 * @param unknown $id
	 * @param unknown $ordering
	 */
	public function updateOrdering($id, $ordering) {
		$pdo = $this->getPdo();
		$sql = "UPDATE `temos` SET `ordering` = ? WHERE `id` = ?";
		if(is_array($id)) {
			$success = true;
			foreach ($id as $ordering=>$cat_id) {
				$success = $success && $pdo->prepare($sql)->execute(array(intval($ordering) + 1, $cat_id));
			}
			return $success;
		}
		return $pdo->prepare($sql)->execute(array($ordering, $id));
	}
	
	/**
	 * 
	 * @param string $pavadinimas
	 */
	public function createCategory($pavadinimas) {
		$pdo = $this->getPdo();
		$sth = $pdo->prepare('SELECT `id` FROM `temos` WHERE `pavadinimas` = ? LIMIT 1');
		$sth->execute(array($pavadinimas));
		$id = $sth->fetch(PDO::FETCH_COLUMN, 0);
		if(!$id) {
			$pdo->prepare('INSERT INTO `temos` (`pavadinimas`, `ordering`) VALUES (?, 1 + (SELECT MAX(CAST(`ordering` AS INTEGER)) FROM `temos`))')
				->execute(array($pavadinimas));
			$id = $pdo->lastInsertId();
		}
		return $id;
	}
	
	/**
	 * 
	 * @param entity_article $article
	 */
	public function saveArticle(entity_article $article) {
		$errors = $this->validateArticle($article);
		if(empty($errors)) {
			$isNew = (null === $article->getId());
			$sql = "UPDATE `naujienos` SET ";
			if($isNew) {
				$article->setLaikas(new DateTime());
				$sql = "INSERT INTO `naujienos` (`tema_id`, `autorius`, `laikas`, "
					. "`pavadinimas`, `tekstas`) VALUES (:tema_id, :autorius, "
					. ":laikas, :pavadinimas, :tekstas) ";
			} else {
				$sql .= "`tema_id` = :tema_id, `autorius` = :autorius, `laikas` = :laikas, "
					."`pavadinimas` = :pavadinimas, `tekstas` = :tekstas ";
				$sql .= "WHERE `id` = :id";
			}
			$pdo = $this->getPdo();
			$sth = $pdo->prepare($sql);
			$sth->bindValue(':tema_id', $this->createCategory($article->getTema()));
			$sth->bindValue(':autorius', $article->getAutorius());
			$sth->bindValue(':laikas', $article->getLaikas('%F %T'));
			$sth->bindValue(':pavadinimas', $article->getPavadinimas());
			$sth->bindValue(':tekstas', $article->getTekstas());
			if(!$isNew) {
				$sth->bindValue(':id', $article->getId());
			}
			
			return $sth->execute() ? array() : array(gettext('Database error.'));
		}
		return $errors;
	}
	
	/**
	 * 
	 * @param entity_article $article
	 * @return array
	 */
	public function validateArticle(entity_article $article) {
		$errors = array();
		if($article->getTema() == '') {
			$errors[] = gettext('Please, fill category field.');
		}
		if($article->getAutorius() == '') {
			$errors[] = gettext('Please, fill author field.');
		}
		if($article->getPavadinimas() == '') {
			$errors[] = gettext('Please, fill title field.');
		}
		if($article->getTekstas() == '') {
			$errors[] = gettext('Please, fill content field.');
		}
		return $errors;
	}
}

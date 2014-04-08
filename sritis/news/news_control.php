<?php

require_once 'system/view.php';
require_once 'system/base.php';
require_once 'entity/article.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class news_control extends system_base {
	/**
	 * 
	 */
	protected function rodykAction() {
		$this->setAction('articles');
		$this->articlesAction();
	}

	/**
	 * 
	 */
	protected function articlesAction() {
		$model = $this->getModel();
		$articles = $model->getFrontArticles();
		$articles = $model->getCategorizedArticles($articles);
		$this->view->articles = $articles;
	}

	/**
	 * 
	 * @param string $category
	 */
	protected function categoryAction($category = null) {
		if (null === $category) {
			$this->error('Nenurodyta kategorija!');
			return;
		}
		$model = $this->getModel();
		$articles = $model->doPaginate(true)
			->setLimit(5)
			->setPage($this->getQuery('page', 1))
			->getArticlesByCategory($category);
		$pagination = $model->getPaginationVars();
		$pagination['route'] = array(
			$this->getAction(),
			$this->getName(),
			$category
		);
		$this->view->assign(compact('category', 'articles', 'pagination'));
		if (empty($this->view->articles)) {
			$this->error('Kategorija neegzistuoja!');
		}
	}

	/**
	 * 
	 * @param integer $id
	 */
	protected function articleAction($id = null) {
		if (null === $id) {
			$this->error('Nenurodyta naujiena!');
			return;
		}
		$this->view->article = $this->getModel()->getArticle($id);
		if (empty($this->view->article)) {
			$this->error('Naujiena neegzistuoja!');
		}
	}
	
	protected function admin_listAction() {
		$model = $this->getModel();
		$query = $this->getQuery('query', '');
		$articles = $model->doPaginate(true)
			->setPage($this->getQuery('page', 1))
			->getArticles($query);
		$pagination = $model->getPaginationVars();
		$pagination['route'] = array(
			$this->getAction(),
			$this->getName()
		);
		if($query) {
			$pagination['route']['_get']['query'] = $query;
		}
		$this->view->assign(compact('articles', 'pagination', 'query'));
	}
	
	protected function admin_list_categoriesAction() {
		$model = $this->getModel();
		$categories = $model->doPaginate(true)
			->setPage($this->getQuery('page', 1))
			->getCategories();
		$pagination = $model->getPaginationVars();
		$pagination['route'] = array(
			$this->getAction(),
			$this->getName()
		);
		$this->view->assign(compact('categories', 'pagination'));
	}
	
	protected function admin_ordering_categoryAction() {
		if($this->isPost()) {
			$id = $this->getPost('id');
			$ordering = $this->getPost('ordering');
			$this->getModel()->updateOrdering($id, $ordering);
		}
		$this->redirect('admin_list_categories');
	}
	
	protected function admin_delete_categoryAction($id) {
		if($id && $this->isPost()) {
			$model = $this->getModel();
			$model->deleteArticleCategory($id);
		}
		$this->redirect('admin_list_categories');
	}
		
	protected function admin_formAction($id = null) {
		$errors = array();
		$article = null;
		if($id) {
			$article = $this->getModel()->getArticle($id);
		}
		if(!$article instanceof entity_article) {
			$id = null;
			$article = new entity_article();
		}
		if($this->isPost()) {
			$article->exchangeArray($this->getPost());
			$errors = $this->getModel()->saveArticle($article);
			if(empty($errors)) {
				$this->redirect('admin_list');
			}
		}
		$categories = $this->getModel()->getCategoriesList();
		$authors = $this->getModel()->getAuthorsList();
		$this->view->assign(compact('article', 'id', 'errors', 'categories', 'authors'));
	}
	
	protected function admin_deleteAction($id = null) {
		if($id && $this->isPost()) {
			$model = $this->getModel();
			$model->deleteArticle($id);
		}
		$this->redirect('admin_list');
	}
	
	protected function authorsAction() {
		$authors = $this->getModel()->getAuthorsList();
		$this->getView()->assign('authors', $authors);
	}
	
	protected function categoriesAction() {
		$categories = $this->getModel()->getCategoriesList();
		$this->getView()->assign('categories', $categories);
	}
}

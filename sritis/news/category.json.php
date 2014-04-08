<?php
/* @var $this system_view */

header('Content-type: application/json');

$articles = array();
foreach($this->articles as $article) {
	$articles[] = array(
		'_links' => array(
			'self' => $this->url('article', null, $article->getId()) . '.json'
		),
		'title' => $article->getPavadinimas(),
		'content' => $article->getTekstas(),
		'createdAt' => $article->getLaikas(),
		'author' => $article->getAutorius(),
	);
}

$category = array(
	'_links' => array(
		'self' => $this->url('category', null, $this->category) . '.json',
		'front' => $this->url() . '.json'
	),
	'_embedded' => array(
		'article' => $articles
	),
	'title' => $this->category,
	'page' => $this->pagination['page'],
	'total_pages' => $this->pagination['total_pages']
);

echo json_encode($category);
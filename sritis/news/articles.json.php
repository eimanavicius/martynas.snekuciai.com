<?php
/* @var $this system_view */

header('Content-type: application/json');

$categories = array();
foreach($this->articles as $title => $category) {
	$articles = array();
	foreach($category as $article) {
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
	$categories[] = array(
		'_links' => array(
			'self' => $this->url('category', null, $title) . '.json'
		),
		'_embedded' => array(
			'article' => $articles
		),
		'title' => $title
	);
}

echo json_encode(array(
	'_links' => array(
		'self' => $this->url() . '.json'
	),
	'_embedded' => array(
		'category' => $categories 
	)
));

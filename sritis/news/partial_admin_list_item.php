<?php
/* @var $this system_view */
/* @var $article entity_article */
$article = $this->article;

echo '<a href="',
$this->url('article', null, $article->getId(), $article->getTema(), $article->getPavadinimas()),
'"><strong>', htmlspecialchars($article->getPavadinimas()), '</strong></a><br/>';
echo '<small>Paskelbta: ', $article->getLaikas(), '. Autorius: ',
$article->getAutorius(), '</small>';
echo '<div>', $article->getTrumpasTekstas(), '</div>';
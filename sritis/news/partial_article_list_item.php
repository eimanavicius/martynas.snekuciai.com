<?php
/* @var $this system_view */
/* @var $article entity_article */
$article = $this->article;

echo '<h3><a' . ($article->isNew() ? ' class="nauja"' : '') . ' href="',
$this->url('article', null, $article->getId(), $article->getTema(), $article->getPavadinimas()),
'">', htmlspecialchars($article->getPavadinimas()), '</a></h3>';
echo '<p><small>Paskelbta: ', $article->getLaikas(), '. Autorius: ',
$article->getAutorius(), '</small></p>';
echo '<p>', $article->getTrumpasTekstas(), '</p>';
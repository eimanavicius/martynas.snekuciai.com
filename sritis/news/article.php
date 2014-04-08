<?php

/* @var $article entity_article */
$article = $this->article;

echo '<p>';
echo '<a role="btn" href="', $this->url('category', null, $article->getTema()), '">', 
	sprintf(gettext('Back to %s'), $article->getTema()), '</a> ';
echo '<a role="btn" href="', $this->url(), '">', gettext('Back to news'), '</a>';
echo '</p>';

echo '<div class="ui-news ui-widget"><div class="ui-widget-header">';
	echo '<h1>', $article->getPavadinimas(), '</h1>';
echo '</div><div class="ui-widget-content ui-corner-bottom">';
	echo '<p><small>Paskelbta: ', $article->getLaikas(), ', ', $article->getAutorius(), 
		'. Kategorija: ', $article->getTema(), '.</small></p>';
	echo nl2br($article->getTekstas(), true);
echo '</div></div>';
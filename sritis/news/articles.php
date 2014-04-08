<?php
/* @var $this system_view */

echo '<h1>', gettext('News'), '</h1>';

foreach ($this->articles as $title => $articles) {
	echo '<div class="ui-news ui-widget"><div class="ui-widget-header">';
	echo '<h2><a href="', $this->url('category', null, $title), 
		'">', htmlspecialchars($title), '</a></h2>';
	echo '</div><div class="ui-widget-content ui-corner-bottom">';
	/* @var $article entity_article */
	foreach ($articles as $k => $article) {
		if ($k != 0) {
			echo '<hr/>';
		}
		$this->partial('article_list_item', compact('article'));
	}
	echo '</div></div>';
}

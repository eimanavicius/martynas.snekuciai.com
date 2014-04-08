<?php
/* @var $this system_view */

echo '<p>';
echo '<a href="', $this->url(), '" role="btn">', gettext('Back to news'), '</a>';
echo '</p>';
echo '<div class="ui-news ui-widget"><div class="ui-widget-header">';
echo '<h2>', $this->category, '</h2>';
echo '</div><div class="ui-widget-content ui-corner-bottom">';

/* @var $article entity_article */
foreach ($this->articles as $k=>$article) {
	if($k != 0) {
		echo '<hr/>';
	}
	$this->partial('article_list_item', compact('article'));
}
echo '</div></div>';

$this->paginate('pagination');

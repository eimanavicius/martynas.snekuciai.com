<?php
/* @var $this system_view */

echo '<h1>', gettext("Admin Listing"), ' <a href="', $this->url('admin_form'), 
	'" class="btn btn-success">', gettext('New'), '</a>',
	'<form class="pull-right" action="', $this->url('admin_list'), '">',
  	'<input type="text" class="search-query" placeholder="', gettext("Search"), '" name="query" value="', $this->query, '" />',
	'</form></h2>';

if($this->articles) {
	$this->paginate('pagination');
	
	echo '<table border=1 cellspacing=0 cellpadding=0 width=100%>';
	/* @var $article entity_article */
	foreach ($this->articles as $k=>$article) {
		echo '<tr><td style="padding: 6px;">', $article->getId(), '</td><td style="padding: 6px;">';
		$this->partial('admin_list_item', compact('article'));
		echo '</td><td style="white-space:nowrap;padding: 6px;">';
		echo '<a href="', $this->url('admin_form', null, $article->getId()), 
			'" class="btn btn-warning">', gettext('Edit'), 
			'</a> <form style="display:inline" method="post" action="', 
			$this->url('admin_delete', null, $article->getId()), 
			'"><input type="submit" value="', gettext('Delete'), 
			'" onclick="return confirm(\'', gettext('Do you realy want to delete?'), 
			'\')" class="btn btn-danger" /></form>';
		echo '</td></tr>';
	}
	echo '</table>';
	
	$this->paginate('pagination');
} else {
	echo '<p>', gettext('No articles found.'), '</p>';
}
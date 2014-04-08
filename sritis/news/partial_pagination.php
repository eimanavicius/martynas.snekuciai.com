<?php

if($this->total_pages == 1) {
	// skip pagination section
	return;
}

$sep = isset($this->sep) ? $this->sep : ' ';

echo '<p class="pagination">';

if($this->page > 1) {
	$route = $this->route;
	$route['_get']['page'] = $this->page - 1;
	echo '<a class="prev" href="', htmlspecialchars($this->url(
			array_shift($route), array_shift($route), $route
	)), '">', gettext('Previous'), '</a>', $sep;
}

$scope = isset($this->scope) ? $this->scope : 5; // is sonu po 5
$printStart = 0;
if($this->page > $scope) {
	$printStart = $this->page - $scope;
}
$printEnd = $this->page + $scope;
if($this->total_pages < $printEnd) {
	$printEnd = $this->total_pages;
}

for ($i = 1; $i <= $this->total_pages; $i++) {
	if($i < $printStart) {
		if($i == $printStart -1) {
			echo '<span class="gap">...</span>', $sep;
		}
		continue;
	}
	if($i > $printEnd) {
		echo $sep, '<span class="gap">...</span>';
		break;
	}
	if($i != $printStart && $i != 1) {
		echo $sep;
	}
	if($i == $this->page) {
		echo '<span class="active">', $i, '</span>'; 
	} else {
		$route = $this->route;
		$route['_get']['page'] = $i;
		echo '<a href="', htmlspecialchars($this->url(
				array_shift($route), array_shift($route), $route
			)), '">', $i, '</a>';
	}
}

if($this->page < $this->total_pages) {
	$route = $this->route;
	$route['_get']['page'] = $this->page + 1;
	echo $sep, '<a class="next" href="', htmlspecialchars($this->url(
			array_shift($route), array_shift($route), $route
	)), '">', gettext('Next'), '</a>';
}

echo '<br/><span class="page-of-pages">', sprintf(gettext('Page %d of %d'), $this->page, $this->total_pages), '</span>';

echo '</p>';
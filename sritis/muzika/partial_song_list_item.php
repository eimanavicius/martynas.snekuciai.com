<?php 
	$song = $this->song;
	echo '<li><span class="ui-icon ui-icon-volume-on"></span> <a class="song" href="', $this->url('download', null, $song->getId()), '"/>', $song->getTitle(), '</a></li>';
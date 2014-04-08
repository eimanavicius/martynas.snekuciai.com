<?php 

if($this->albums) {
	echo '<div class="songs-list">';
	foreach($this->albums as $item) {
		if($item instanceof entity_category) {
			$moreBtn = false;
			echo '<h3>',$item->getTitle(),'</h3>';
			echo '<div><ul>';
			$k=0;
			foreach ($item as $song) {
				if(++$k > 5) {
					$moreBtn = true;
					break;
				}
				$this->partial('song_list_item', compact('song'));
			}
			echo '</ul>';
			if($moreBtn) {
				echo '<a href="', $this->url($song->getCategory()), '" role="more-songs-btn">Daugiau</a>';
			}
			echo '</div>';
		}
	}
	echo '</div>';
}
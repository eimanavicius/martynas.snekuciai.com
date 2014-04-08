<?php

require_once 'system/base.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class meniu_control extends system_base {
	/**
	 * 
	 */
	public function rodyk() {
		$news_model = $this->loadModel('news', 'news');
		$music_model = $this->loadModel('muzika', 'muzika');
		$articles_categories = $news_model->getCategoriesList();
		$music_albums = $music_model->getAlbums();
		$foto_direktorijos = $this->getModel()->gauti_foto_kategorijas();
		$this->getView()->assign(compact('articles_categories', 'foto_direktorijos', 'music_albums'));
		$this->getView()->render("top-menu");
	}
}

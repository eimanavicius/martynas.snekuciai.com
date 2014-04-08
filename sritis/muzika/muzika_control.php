<?php

require_once 'system/view.php';
require_once 'system/base.php';

/**
 * 
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class muzika_control extends system_base {
	/**
	 * 
	 * @param string $name
	 * @param array $arguments
	 */
	public function __call($name, $arguments) {
		$config = new config;
		if(preg_match('/^[a-z0-9. ]+$/i', $name) && $name != 'download' && $name != 'rodyk' /*&& file_exists($config->audio_dir . '/' . $name)*/) {
			array_unshift($arguments, $name);
			$name = 'rodyk';
		}
		parent::__call($name, $arguments);
	}
	
	/**
	 * 
	 */
	protected function downloadAction($id) {
		$this->setAutoRender(false);
		$config = new config;
// 		$file = realpath($config->audio_dir . '/' . str_replace('%2F', '/', $id));
// 		if(substr($id, -4) !== '.mp3' || !$file || !is_file($file)
// 			|| substr($file, 0, strlen($config->audio_dir)) != $config->audio_dir
// 		) {
// 			$this->redirect();
// 			return;
// 		}
		$file = 'http://greitas.com/audio/'.implode('/', array_map(function($a){
			return rawurlencode($a);
		}, explode('%2F', $id)));
		
		$song = basename($file);
		header('Content-type: audio/mpeg');
		header('Content-Disposition: attachment; filename="'.$song.'"');
		$fp = fopen($file, "r"); 
		while (!feof($fp))
		{
		    echo fread($fp, 1024); 
		    flush();
		}  
		fclose($fp); 
	}
	
	/**
	 * 
	 */
	protected function rodykAction($album = null) {
		$config = new config;
		if(null !== $album) {
			$dir = $config->audio_dir . '/' . $album;
		} else {
			$dir = $config->audio_dir . '/.';
		}
		$model = $this->getModel();
		$audiotheque = $model->getSongs($dir);

		$albums = array();
		$songs = array();
		$model->filter($audiotheque, $albums, $songs);

		$sortSongs = $model->getSongsSort();
		$sortAlbums = $model->getAlbumsSort();

		uasort($songs, $sortSongs);
		uasort($albums, $sortAlbums);
		foreach ($albums as $item) {
			$item->uasort($sortSongs);
		}
		
		$this->getView()->assign(compact('songs', 'albums', 'sortSongs', 'sortAlbums', 'album'));
	}
}

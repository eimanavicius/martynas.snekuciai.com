<?php

require_once 'system/model.php';
require_once 'entity/song.php';
require_once 'entity/category.php';

/**
 *
 * @author Nerijus Eimanavičius <nerijus@eimanavicius.lt>
 *
 */
class muzika_class extends system_model {
	/**
	 *
	 */
	public function getAlbums() {
		$audiotheque = $this->getAudiotheque();
		$songs = array();
		$albums = array();
		$this->filter($audiotheque, $albums, $songs);
		uasort($albums, $this->getAlbumsSort());
		return $albums;
	}

	/**
	 *
	 * @return entity_category
	 */
	public function getAudiotheque() {
		$config = new config;
		$audiotheque = $this->getSongs($config->audio_dir.'/.');
		return $audiotheque;
	}

	/**
	 *
	 * @return entity_category
	 */
	public function getSongs($kelias, $album = null) {
        return $this->collectLocalSongs($kelias, $album);
	}

	/**
	 *
	 * @return Callable
	 */
	public function getSongsSort() {
		return function($itemA, $itemB){
			$a = $itemA->getMTime();
			$b = $itemB->getMTime();
			if ($a == $b) {
				return 0;
			}
			return ($a > $b) ? -1 : 1;
		};
	}

	/**
	 *
	 * @return Callable
	 */
	public function getAlbumsSort() {
		return function($itemA, $itemB) {
			$a = $itemA->getTitle();
			$b = $itemB->getTitle();
			if(
			(!is_numeric($a[0]) && is_numeric($b[0]))
			|| (is_numeric($a[0]) && !is_numeric($b[0]))
			) {
				return is_numeric($a[0]) ? -1 : 1;
			}
			return strcasecmp($a, $b) * (is_numeric($a[0]) ? -1 : 1);
		};
	}

	/**
	 *
	 * @param unknown $audiotheque
	 * @param unknown $albums
	 * @param unknown $songs
	 */
	public function filter($audiotheque, &$albums, &$songs) {
		foreach($audiotheque as $item) {
			if($item instanceof entity_song) {
				$songs[] = $item;
			} else if($item instanceof entity_category) {
				$albums[] = $item;
			}
		}
	}

    /**
     * @param $kelias
     * @param $album
     * @return mixed
     */
    public function fetchSongsFromRemote($kelias, $album)
    {
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => implode("\r\n", array('User-Agent: snekuciai'))
            )
        );
        $context = stream_context_create($opts);

        $url = 'http://nerijus.greitas.com/proxy.php?';
        $query_data = array(
            'action' => 'getSongs',
            'kelias' => $kelias,
            'album' => serialize($album)
        );

        $data = file_get_contents($url . http_build_query($query_data), false, $context);
        list($result, $params) = unserialize($data);

        return $result;
    }

    /**
     * @param $kelias
     * @param $album
     * @return entity_category
     */
    public function collectLocalSongs($kelias, $album)
    {
        if (null === $album) {
            $album = new entity_category();
        }
        if (file_exists($kelias)) {
            $handle = opendir($kelias);
            while (false !== ($file = readdir($handle))) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $failas = $kelias . '/' . $file;
                if (is_dir($failas)) {
                    $category = new entity_category($file, ucfirst($file));
                    $album->append($category);
                    $this->getSongs($failas, $category);
                } else if (substr($file, -4) == '.mp3') {
                    $song = new entity_song($failas);
                    $song->setCategory(basename($kelias))
                        ->setTitle($file);
                    $album->append($song);
                }

            }
        }
        return $album;
    }
}

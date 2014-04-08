<?php

$this->paginate();

foreach ($this->chats as $id => $chat) {
	$fm = reset($chat);
	$fm['foto_maza'] = str_replace('greitas.com', 'namie.lt', $fm['foto_maza']);
	echo '<div><h2 style="background: rgb(140, 199, 218);"><img src="', $fm['foto_maza'], '" alt="" align=middle /> ', $fm['vardas'], '</h2>';
	$ilgis = strlen($fm['vardas']);
	$ilgis = $ilgis < 5 ? 5 : $ilgis;
	$ilgis++;
	$name = str_pad('Botas', $ilgis, " ", STR_PAD_LEFT);
	$name = str_replace(" ", "&nbsp;", $name);
	echo '<small>', $fm['laikas'], ',</small> <strong><code>', $name, ':</code></strong> <span class="zinute">', $this->first_message, '</span><br/>';
	foreach ($chat as $message) {
		$name = ($message['raso'] == 1 ? $fm['vardas'] : 'Botas');
		$name = str_pad($name, $ilgis, " ", STR_PAD_LEFT);
		$name = str_replace(" ", "&nbsp;", $name);
		echo '<small>', $message['laikas'], ',</small> <strong><code>', $name, ':</code></strong> <span class="zinute">', $message['zinute'], '</span><br/>';
	}
	echo '</div>';
}

$this->paginate();

// echo '<pre>';
// var_dump($this->chats);
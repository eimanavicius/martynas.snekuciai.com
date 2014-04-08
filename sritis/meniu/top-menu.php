<ul class="top-menu">
	<li><a href="news">NAUJIENOS</a><?php

		echo '<ul>';
		foreach ($this->articles_categories as $category) {
			echo '<li><a href="' . $this->url("category", "news",  $category) . '">' . $category . '</a></li>';
		}
		echo '</ul>';

	?></li>
	<li>
		<span>BOTAS</span>
		<ul>
			<li><a href="<?php echo $this->url("vaikinai", "draugas"); ?>">Pokalbiai su vaikinais</a></li>
			<li><a href="<?php echo $this->url("merginos", "draugas"); ?>">Pokalbiai su merginomis</a></li>
		</ul>
	</li>
	<li><a href="<?php echo $this->baseurl("muzika"); ?>">MUZIKA</a><?php 
	
		echo '<ul>';
		/* @var $album entity_category */
		foreach ($this->music_albums as $album) {
			echo '<li><a href="' . $this->url($album->getName(), "muzika") . '">' . $album->getTitle() . '</a></li>';
		}
		echo '</ul>';
	
	?></li>
	<li><span>FOTO</span><?php 
		print_listas($this->foto_direktorijos); 
	?></li>
	<li>
		<span>INFORMACIJA</span>
		<ul>
			<li><a href="<?php echo $this->baseurl("info/apie"); ?>">Apie mane</a></li>
			<li><a href="<?php echo $this->baseurl("info/cv"); ?>">CV</a></li>
			<li><a href="<?php echo $this->baseurl("info/darbai"); ?>">Atlikti darbai</a></li>
			<li><a href="<?php echo $this->baseurl("statistika"); ?>">Statistika</a></li>
		</ul>
	</li>
</ul>
<?php

function print_listas($listas, $base = '') {
	echo '<ul>';
	foreach ($listas as $dir => $subdirs) {
		echo '<li class="' . (empty($subdirs) ? '' : 'taskiukai') . '">';
		echo '<a href="foto/dir/' . $base . $dir . '">' . $base . $dir . '</a>';
		if (!empty($subdirs)) {
			print_listas($subdirs, $base . $dir . '/');
		}
		echo '</li>';
	}
	echo '</ul>';
}

?>
<script type="text/javascript">
	$('ul.top-menu li').on('mouseover', function(){
		$(this).addClass('submenu');
	}).on('mouseleave', function(){
		$(this).removeClass('submenu');
	});
	$( "ul.top-menu>li>ul" ).menu();
</script>
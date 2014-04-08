<h1>Atlikti darbai</h1>
<?php foreach($this->darbai as $darbas): ?>

<div class="darbas clearfix">
	<a href="<?php echo $darbas['img']; ?>" rel="prettyPhoto[darbai]" title="<?php echo $darbas['title']; ?>"><img src="<?php echo $darbas['img']; ?>" alt="" /></a>
	<h2><?php echo $darbas['title']; ?></h2>
	<p><?php echo $darbas['desc']; ?></p>
</div>
<?php endforeach; ?>
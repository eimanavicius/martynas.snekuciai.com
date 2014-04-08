<?php
/* @var $this system_view */
/* @var $article entity_article */
$article = $this->article;

echo '<a class="btn" href="', $this->url('admin_list'), '">', gettext('Back'), '</a>';
echo '<h1>', (is_null($this->id) ? gettext('New article') : gettext('Edit article')), '</h1>';

if ($this->errors) {
	echo '<div class="alert alert-block alert-error"><h4>', gettext('Errors'), '</h4>';
	foreach ($this->errors as $error) {
		echo $error, '<br/>';
	}
	echo '</div>';
}

?>
<div class="ui-widget">
	<form action="<?php echo $this->url('admin_form', null, is_null($this->id) ? array() : $article->getId()); ?>" method="post">
	
		<p><input id="category" type="text" style="width:90%" title="<?php echo gettext('Category'); ?>" placeholder="<?php echo gettext('Category'); ?>" name="tema" value="<?php echo htmlspecialchars($article->getTema()); ?>" /></p>
		<p><input id="author" type="text" style="width:90%" title="<?php echo gettext('Author'); ?>" placeholder="<?php echo gettext('Author'); ?>" name="autorius" value="<?php echo htmlspecialchars($article->getAutorius()); ?>" /></p>
		<p><input type="text" style="width:90%" title="<?php echo gettext('Title'); ?>" placeholder="<?php echo gettext('Title'); ?>" name="pavadinimas" value="<?php echo htmlspecialchars($article->getPavadinimas()); ?>" /></p>
		<p><input type="datetime" style="width:90%" title="<?php echo gettext('Date'); ?>" placeholder="<?php echo gettext('Date'); ?>" name="laikas" value="<?php echo htmlspecialchars($article->getLaikas('%F %X')); ?>" /></p>
		<p><textarea style="width:90%" placeholder="<?php echo gettext('Content'); ?>" name="tekstas" cols="30" rows="20"><?php echo htmlspecialchars($article->getTekstas()); ?></textarea></p>
		<p><input type="submit" value="<?php echo gettext('Save'); ?>" class="btn btn-success" /></p>
	
	</form>
</div>
<script type="text/javascript">
(function($) {
	var categories = <?php echo json_encode($this->categories); ?>,
		authors = <?php echo json_encode($this->authors); ?>;
	initAutocomplete('#category', categories)
	initAutocomplete('#author', authors);
	function initAutocomplete(selector, source) {
		$(selector).autocomplete({
	        delay: 0,
	        minLength: 0,
			source: source
		}).on('focus', function(){
			var $this = $(this);
			$this.autocomplete( "search", $this.val() );
		});
	}
})(jQuery);
</script>
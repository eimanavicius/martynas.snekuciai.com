<?php

/* @var $this system_view */

echo '<h1>', gettext("Admin Listing Categories"), '</h1>';

if($this->categories) {
	$this->paginate('pagination');
	
	echo '<table id=admin border=1 cellspacing=0 cellpadding=0 width=100% data-ajax-ordering="', $this->url('admin_ordering_category'), '">';
	foreach ($this->categories as $category) {
		echo '<tr data-id=', $category['id'], '><td style="padding: 6px;width: 5%">', $category['id'], 
			'</td><td style="padding: 6px;width: 75%">', $category['pavadinimas'],
			' (', $category['count'], ')', '</td><td style="padding: 6px;width: 5%;" class="ordering" data-id=', $category['id'], '>', 
			$category['ordering'],
			'</td><td style="padding: 6px;width: 15%; text-align:center;">',
			'<form style="display:inline" method="post" action="', 
			$this->url('admin_delete_category', null, $category['id']), 
			'"><input type="submit" value="', gettext('Delete'), 
			'" onclick="return confirm(\'', gettext('Do you realy want to delete?'), 
			'\')" class="btn btn-danger" /></form>',
			'</td></tr>';
	}
	echo '</table>';

	$this->paginate('pagination');
} else {
	echo '<p>', gettext('No categories found.'), '</p>';
}

?>
<script type="text/javascript">
(function($){
	var $adminTable = $('#admin');
	$adminTable.on('click', '.ordering', function(event) {
		if(!$(event.target).is('td')) {
			return;
		}
		var $this = $(this),
			val = parseInt($this.data('value') | $this.text()),
			input = $('<input/>', {
				val: val,
				css: {
					width: 20
				}
			});
		$this.data('value', val);
		$this.data('input', input);
		$this.html(input);
		input.focus().select();
	}).on('keyup', '.ordering', function(event){
		console.log(event.keyCode);
		var $this = $(this);
		if(13 == event.keyCode) {
			var val = $this.data('input').val();
			$this.html(val);
			$.post($adminTable.data('ajax-ordering'), {id: $this.data('id'), ordering: val}, function(data){
				$('table').html( $(data).find('table#admin').html() );
				sortable();
			});
		}
	});
	(function sortable() {
		$('>tbody',$adminTable).sortable({
			update: function( event, ui ) {
				var ids = $(this).sortable( "toArray", {attribute: 'data-id'} );
				$.post($adminTable.data('ajax-ordering'), {id: ids}, function(data){
					$('table').html( $(data).find('table#admin').html() );
					sortable();
				});
			}
		}).disableSelection();
	})();
})(jQuery);
</script>
<style type="text/css">
.ui-sortable-placeholder {
	height: 48px;
}
.ui-sortable-helper {
	cursor: move;
}
</style>
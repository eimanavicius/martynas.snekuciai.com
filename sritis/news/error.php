<div class="ui-widget">
	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<strong>Klaida:</strong><?php 

echo isset($this->error_message) ? $this->error_message : 'NĖRA TOKIOS SRITIES';

?></p>
	</div>
</div>
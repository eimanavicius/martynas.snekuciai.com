<?php

echo '<div class="songs-page">';

echo '<h1>Muzika', ($this->album ? ' ' . htmlspecialchars(ucfirst($this->album)) : ''), '</h1>';

echo '<p>', 'Geriausia muzika iš MC DJ Martynas kolekcijos', '</p>';

if ($this->songs) {
	echo '<div class="album-content ui-widget"><div class="ui-widget-content ui-corner-all"><ul>';
	foreach ($this->songs as $song) {
		$this->partial('song_list_item', compact('song'));
	}
	echo '</ul></div></div>';
}

$this->partial('albums_list', array('albums' => $this->albums));

if ($this->album) {
	echo '<a role="back-btn" href="', $this->url(), '">Atgal</a>';
}

echo '</div>';

?>
<div id="dialog-message" title="Daina"><p></p></div>
<div id="player" class="ui-helper-hidden"></div>
<script type="text/javascript">
$(function() {
    var icons = {
      header: 'ui-icon-folder-collapsed',
      activeHeader: 'ui-icon-folder-open'
    }, 
    $player = $('#player'),
    $dialog = $('#dialog-message').dialog({
        modal: true,
        autoOpen: false,
        buttons: [
          {
        	  text: 'Groti',
              id: 'play',
              click: function() {
	        	var $this = $(this);
	        	if(null === play()) {
		        	playing = true;
		        	$playBtn.button('option', 'label', 'Krauna...');
		        	$this.one('dialogclose', function(){
		        		play(null);
		            });
		       	    $player.jPlayer({
		                ready: function() { 
		                	$player.jPlayer("setMedia", {
		                        mp3: $this.data('stream')
		                    });
		                	play(true);
		                },
		                ended: function() {
		                	play(false);
		                },
		                swfPath: "/img"
		       	    });
	        	} else if (play()) {
	        		play(false);
	        	} else {
	        		play(true);
	        	}
	          },
          },
          {
        	text: 'Parsisiųsti',
          	click: function() {
            	document.location = $(this).dialog('close').data('download');
          	}
          }
        ]
    }),
	$playBtn = $('#play'),
    playing = null,
	play = function(state) {
		if(typeof(state) == 'undefined') {
			return playing;
		}
		if(state === null) {
    		$player.jPlayer('destroy');
        	$playBtn.button('option', 'label', 'Groti');
        	$playBtn.button('option', 'icons', { primary: 'ui-icon-play' });
    		playing = null;
		} else if(state) {
    		$player.jPlayer('play');
        	$playBtn.button('option', 'label', 'Pauzė');
        	$playBtn.button('option', 'icons', { primary: 'ui-icon-pause' });
    		playing = true;
		} else {
    		$player.jPlayer('pause');
        	$playBtn.button('option', 'label', 'Groti');
        	$playBtn.button('option', 'icons', { primary: 'ui-icon-play' });
    		playing = false;
		}
	};
	play(null);
    $('.songs-list').accordion({
      icons: icons,
      collapsible: true,
      heightStyle: 'content',
      active: false
    });
    $('[role="more-songs-btn"]').button({
        icons: {
            primary: 'ui-icon-play'
        }
    });
    $('[role="back-btn"]').button();
    $('a.song').on('click', function(event){
        var $this = $(this);
        event.preventDefault();
        $dialog.dialog('open')
	    	.data({
		    	stream: $this.attr('href'),
		    	download: $this.attr('href')
	        })
        	.find('>p')
        		.text($this.text());
    });
});
</script>
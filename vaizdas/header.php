<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<base href="<?php echo $this->baseurl(); ?>">
		<title>Vasara</title>
        <link href="favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/start/jquery-ui.css" />
		<link href="css/prettyPhoto.css" rel="stylesheet" type="text/css">
		<link href="css/stilius.css" rel="stylesheet" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script src="js/jquery.prettyPhoto.js"></script>
		<script src="js/jquery.jplayer.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('a[rel^="prettyPhoto"]').prettyPhoto({social_tools: "",theme: 'facebook'});
				$('a[role="btn"]').button();
			});
		</script>
	</head>
	<body>
		<div class="head">
			<div class="ritasi">
				<?php $this->krauk('meniu'); ?>

				<div class="turinys clearfix">
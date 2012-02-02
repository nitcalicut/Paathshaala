<!DOCTYPE HTML>
<html>
<head>
<title>Paathshaala Contribute</title>
<?php
	include 'source.php';
	include 'functions/ui.php';
	if(!checksession()){
		redirect();
	} else {
		$u = new user ($_SESSION['uid']);
	}
	echo $header;
?>
<link rel='stylesheet' href='css/video-js.css'>
<link rel='stylesheet' href='css/video.css'>
</head>
<body>
<div id='topbar'></div>
<img src="pics/load.gif" id='loading' style='display:none;'>
<div id='container'>
	<?php	echo $topBar;
			echo $feedback; ?>
	<span style='font-size:24px; color:#3A75AF'> Contribute to paathshaala</span> <span id="helpTrigger" style='font-size:14px'> [help] </span>
	<div id='helpMessage' class='message' style='border:0px; display:none'>
		We have a lot of unpublished videos with us which is not yet searchable. Your contribution will make this video public and useful for others.<br/><i>One small step for a student, one giant leap for student kind.</i><br />Please dont mess up !
	</div>
	<div class='mainLeft'>
	<div class='videodiv'></div>
	</div> <!--/ main left -->
	<div class='mainRight'>
	<div class='message' id='helpLog' >
		Describe video details along
	</div>
	<form class='newVideoSubmit'>
		<input type="text" id="title" placeholder="Enter a title for your new video"/>
		<input type="text" id="tags" placeholder="Now few comma seperated tags"/>
		<textarea id='desc' placeholder="Now add a good description to make this video searchable and useful for others"></textarea>
		<div class='newVideoSubmitButton'>Submit video to paathshaala :)</div>
	</form>
</div> <!-- /main right -->
</div><!-- /container -->
<?php
	echo $bottomBar;
	echo $scripts;
	echo $piwik; 
?>
<script src='js/video.js' type='text/javascript'></script>
<script type='text/javascript'>
$(document).ready(function() {
	P.getVideo();
	$('span#helpTrigger').click(function(){
		$('div#helpMessage').slideToggle();
	});

});
</script>

</body>
</html>

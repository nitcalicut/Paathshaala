<?php
	/**
	* JSON containing all the video uploaded by the logged in user.
	*/
	include_once '../functions/class.content.php';
	include_once '../functions/class.video.php';
	include_once '../functions/class.user.php';
	include_once '../functions/interface.php';
	if(checkSession()){
		$uid=$_SESSION['uid'];	
		echo getUserUploadedVideosJson($uid);		
	}
	else{
		redirect();
	}
	
?>

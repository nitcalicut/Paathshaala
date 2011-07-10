<?php
	/**
	* JSON returning disliked videos of a logged in user.
	*/
	include_once '../functions/class.content.php';
	include_once '../functions/class.video.php';
	include_once '../functions/class.user.php';
	include_once '../functions/interface.php';
	session_start();
	if(checkSession()){
		$uid=$_SESSION['uid'];	
		echo getUserVideoLikesJson($uid,1);
	}
	else{
		redirect();
	}
	
?>

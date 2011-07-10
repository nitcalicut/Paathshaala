<?php
	/**
	* JSON returning liked videos of the logged in user.
	*/
	include_once '../functions/class.content.php';
	include_once '../functions/class.video.php';
	include_once '../functions/class.user.php';
	include_once '../functions/interface.php';
	if(checkSession()){
		$uid=$_SESSION['uid'];	
		echo getUserVideoLikesJson($uid,-1);
	}
	else{
		redirect();
	}
	
?>

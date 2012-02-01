<?php
	session_start();
	include '../functions/class.video.php';
	global $global_user_folder;
	$v = new video($_POST['title'],$_POST['desc'],$_SESSION['uid'],"SP",$global_user_folder,$_POST['file']);
	if($v->getContentId()){
		$v->addTags($_POST['tags']);
		echo "{ \"status\" : 1 }";
	}
	else{
		echo "{ \"status\" : 0 }";
	}
?>

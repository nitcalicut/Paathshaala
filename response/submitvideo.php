<?php

	include '../functions/class.video.php';
	session_start();
	global $global_raw_videos_folder, $global_user_folder;
	if(	isset($_POST['title']) &&
		isset($_POST['desc']) &&
		isset($_SESSION['uid']) &&
		isset($_POST['file']) &&
		isset($_POST['tags'])){
			$v = new video($_POST['title'],
							$_POST['desc'],
							$_SESSION['uid'],
							"SP",
							"videos",
							$_POST['file']);
			if($v->getContentId()){
				$v->addTags($_POST['tags']);
				$mvcommand = "mv ".$_SERVER["DOCUMENT_ROOT"]."/".$global_raw_videos_folder."/".$_POST['file'].".ogv" ." ".$_SERVER["DOCUMENT_ROOT"]."/"."videos"."/".$v->getContentId().$_POST['file'].".ogv";
				$mv = shell_exec($mvcommand);
				echo "{ \"status\" : 1 ,\"cid\" : ".$v->getContentId()."}";
			}
			else{
				echo "{ \"status\" : 0 }";
			}
	}
	else{
		echo "{ \"status\" : 0 }";
	}

	


?>

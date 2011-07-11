<?php
	/**
	* Report Comment as a spam. 
	*/

	include_once '../functions/class.comment.php';
	$uid=$_SESSION['uid'];
	$comid = $_POST['commentId'];
	$revid = $_POST['revId'];
	if(isset($uid) && isset($comid) && isset($revid)){
		comment::report($comid,$revid,$uid);
	}

?>

<?php
	/**
	* Delete Comment from couch, based on on comment ID and revision ID.
	*/

	include_once '../functions/class.comment.php';
	$c=new comment();
	$c->delete($_POST['commentId'],$_POST['revId']);

?>
